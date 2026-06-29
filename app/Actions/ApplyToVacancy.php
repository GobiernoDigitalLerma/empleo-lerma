<?php

namespace App\Actions;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\CitizenProfile;
use App\Models\Vacancy;
use App\Notifications\ApplicationCreatedNotification;
use App\Notifications\CitizenApplicationCreatedNotification;
use Illuminate\Validation\ValidationException;

/**
 * Crea una postulación ciudadana de forma transaccional.
 *
 * Centraliza las validaciones críticas para evitar doble postulación, vacantes
 * no publicables o perfiles ciudadanos incompletos.
 */
class ApplyToVacancy
{
    /**
     * Valida reglas de negocio y registra la postulación con historial inicial.
     */
    public function handle(Vacancy $vacancy, CitizenProfile $profile, ?string $coverMessage = null): Application
    {
        if (! $vacancy->newQuery()->whereKey($vacancy->id)->publicable()->exists()) {
            throw ValidationException::withMessages(['vacancy' => 'La vacante no está disponible para postulación.']);
        }

        if (! $profile->user?->hasActiveAccess() || ! $profile->hasMinimumProfile()) {
            throw ValidationException::withMessages(['profile' => 'El perfil ciudadano no está vigente o completo.']);
        }

        $application = Application::firstOrCreate(
            ['vacancy_id' => $vacancy->id, 'citizen_profile_id' => $profile->id],
            [
                'company_id' => $vacancy->company_id,
                'status' => ApplicationStatus::Submitted,
                'cover_message' => $coverMessage,
                'submitted_at' => now(),
            ]
        );

        if (! $application->wasRecentlyCreated) {
            throw ValidationException::withMessages(['vacancy' => 'Ya existe una postulación para esta vacante.']);
        }

        $application->statusHistory()->create([
            'from_status' => null,
            'to_status' => ApplicationStatus::Submitted->value,
            'changed_by' => $profile->user_id,
            'notes' => 'Postulación creada por ciudadano.',
        ]);

        $application->load(['vacancy', 'company.user', 'citizenProfile.user']);
        $application->company?->user?->notify(new ApplicationCreatedNotification($application));
        $application->citizenProfile?->user?->notify(new CitizenApplicationCreatedNotification($application));

        return $application;
    }
}
