<?php

use App\Enums\AccessStatus;
use App\Enums\UserRole;
use App\Enums\VacancyStatus;
use App\Models\User;
use App\Models\Vacancy;
use App\Notifications\CompanyVacancyExpiredNotification;
use App\Notifications\CredentialExpiredNotification;
use App\Notifications\CredentialExpiringNotification;
use App\Notifications\CitizenVacancyExpiredNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Comando de ejemplo de Laravel; aquí se agregarán tareas de mantenimiento programables.
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Determina si el usuario ya recibió una notificación equivalente.
 */
$alreadyNotified = function (User $user, string $type, string $key, mixed $value): bool {
    return $user->notifications()
        ->where('type', $type)
        ->get()
        ->contains(fn ($notification) => ($notification->data[$key] ?? null) === $value);
};

/**
 * Notifica credenciales de empresas y ciudadanos próximas a vencer o vencidas.
 */
Artisan::command('notifications:access-expiration', function () use ($alreadyNotified) {
    $roles = [UserRole::Company->value, UserRole::Citizen->value];

    User::query()
        ->whereIn('role', $roles)
        ->where('status', AccessStatus::Active->value)
        ->whereBetween('access_expires_at', [now(), now()->addDays(7)])
        ->get()
        ->each(function (User $user) use ($alreadyNotified) {
            $date = optional($user->access_expires_at)->toDateString();

            if (! $alreadyNotified($user, CredentialExpiringNotification::class, 'access_expires_at', $date)) {
                $user->notify(new CredentialExpiringNotification($user));
            }
        });

    User::query()
        ->whereIn('role', $roles)
        ->whereNotNull('access_expires_at')
        ->where('access_expires_at', '<', now())
        ->get()
        ->each(function (User $user) use ($alreadyNotified) {
            $date = optional($user->access_expires_at)->toDateString();

            if (! $alreadyNotified($user, CredentialExpiredNotification::class, 'access_expires_at', $date)) {
                $user->notify(new CredentialExpiredNotification($user));
            }

            if ($user->status === AccessStatus::Active) {
                $user->forceFill(['status' => AccessStatus::Expired])->save();
            }
        });

    $this->info('Notificaciones de credenciales procesadas.');
})->purpose('Notify companies and citizens about expiring or expired access credentials');

/**
 * Notifica vacantes vencidas no cubiertas a empresa y ciudadanos postulados.
 */
Artisan::command('notifications:vacancy-expiration', function () use ($alreadyNotified) {
    Vacancy::query()
        ->with(['company.user', 'applications.citizenProfile.user', 'applications.vacancy'])
        ->where('is_covered', false)
        ->whereNotNull('expires_at')
        ->where('expires_at', '<', now())
        ->whereIn('status', [VacancyStatus::Published->value, VacancyStatus::Expired->value])
        ->get()
        ->each(function (Vacancy $vacancy) use ($alreadyNotified) {
            if ($vacancy->status !== VacancyStatus::Expired) {
                $vacancy->forceFill(['status' => VacancyStatus::Expired])->save();
            }

            $companyUser = $vacancy->company?->user;
            if ($companyUser && ! $alreadyNotified($companyUser, CompanyVacancyExpiredNotification::class, 'vacancy_id', $vacancy->id)) {
                $companyUser->notify(new CompanyVacancyExpiredNotification($vacancy));
            }

            $vacancy->applications->each(function ($application) use ($alreadyNotified) {
                $citizenUser = $application->citizenProfile?->user;

                if ($citizenUser && ! $alreadyNotified($citizenUser, CitizenVacancyExpiredNotification::class, 'application_id', $application->id)) {
                    $citizenUser->notify(new CitizenVacancyExpiredNotification($application));
                }
            });
        });

    $this->info('Notificaciones de vacantes vencidas procesadas.');
})->purpose('Notify companies and applicants about expired uncovered vacancies');

Schedule::command('notifications:access-expiration')->dailyAt('07:00');
Schedule::command('notifications:vacancy-expiration')->dailyAt('07:15');
