<?php

namespace Tests\Feature;

use App\Enums\AccessStatus;
use App\Enums\ApplicationStatus;
use App\Enums\CompanyStatus;
use App\Enums\UserRole;
use App\Enums\VacancyStatus;
use App\Models\Application;
use App\Models\CitizenProfile;
use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
use App\Notifications\AdminCompanyRegisteredNotification;
use App\Notifications\AdminVacancyRegisteredNotification;
use App\Notifications\ApplicationCreatedNotification;
use App\Notifications\CitizenApplicationCreatedNotification;
use App\Notifications\CitizenHiredNotification;
use App\Notifications\CitizenVacancyCoveredNotification;
use App\Notifications\CitizenVacancyExpiredNotification;
use App\Notifications\CompanyVacancyCoveredNotification;
use App\Notifications\CompanyVacancyCreatedNotification;
use App\Notifications\CompanyVacancyExpiredNotification;
use App\Notifications\CredentialExpiredNotification;
use App\Notifications\CredentialExpiringNotification;
use App\Notifications\VacancyApprovedNotification;
use App\Notifications\VacancyRejectedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

/**
 * Verifica disparadores de notificaciones por perfil y eventos críticos.
 */
class NotificationFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Admin recibe aviso cuando una empresa nueva queda pendiente de aprobación.
     */
    public function test_company_registration_notifies_admin(): void
    {
        Notification::fake();

        $admin = $this->makeUser(UserRole::Admin);

        $this->post(route('register'), [
            'type' => 'company',
            'name' => 'Empresa Registro',
            'email' => 'registro@empresa.test',
            'phone' => '7280000000',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'business_name' => 'Empresa Registro',
            'rfc' => 'REG010101AA1',
        ])->assertRedirect(route('verification.notice'));

        Notification::assertSentTo($admin, AdminCompanyRegisteredNotification::class);
        Notification::assertSentTo(User::where('email', 'registro@empresa.test')->first(), \App\Notifications\CompanyRegisteredNotification::class);
    }

    /**
     * Crear una vacante pendiente notifica a empresa y administradores.
     */
    public function test_pending_vacancy_notifies_company_and_admin(): void
    {
        Notification::fake();

        $admin = $this->makeUser(UserRole::Admin);
        $company = $this->makeCompany();

        $this->actingAs($company->user)
            ->post(route('company.vacancies.store'), [
                'title' => 'Vacante notificable',
                'open_positions' => 1,
                'intent' => 'submit',
            ])
            ->assertRedirect(route('company.vacancies.index'));

        Notification::assertSentTo($company->user, CompanyVacancyCreatedNotification::class);
        Notification::assertSentTo($admin, AdminVacancyRegisteredNotification::class);
    }

    /**
     * La notificación admin de vacante se envía a queue para que el worker la procese.
     */
    public function test_pending_vacancy_queues_admin_notification(): void
    {
        Mail::fake();
        Queue::fake();

        $admin = $this->makeUser(UserRole::Admin);
        $company = $this->makeCompany();

        $this->actingAs($company->user)
            ->post(route('company.vacancies.store'), [
                'title' => 'Vacante inmediata admin',
                'open_positions' => 1,
                'intent' => 'submit',
            ])
            ->assertRedirect(route('company.vacancies.index'));

        $this->assertQueuedNotificationFor($admin, AdminVacancyRegisteredNotification::class);
    }

    /**
     * La bandeja admin muestra sólo notificaciones del administrador actual.
     */
    public function test_admin_notifications_page_only_shows_current_admin_notifications(): void
    {
        $admin = $this->makeUser(UserRole::Admin);
        $otherAdmin = $this->makeUser(UserRole::Admin);
        $company = $this->makeCompany();
        $adminVacancy = $this->makeVacancy($company, VacancyStatus::PendingReview, 'admin-visible-test');
        $otherVacancy = $this->makeVacancy($company, VacancyStatus::PendingReview, 'admin-hidden-test');
        $companyVacancy = $this->makeVacancy($company, VacancyStatus::Published, 'company-hidden-test');

        Notification::sendNow($admin, new AdminVacancyRegisteredNotification($adminVacancy));
        Notification::sendNow($otherAdmin, new AdminVacancyRegisteredNotification($otherVacancy));
        Notification::sendNow($company->user, new CompanyVacancyCreatedNotification($companyVacancy));

        $this->actingAs($admin)
            ->get(route('admin.notifications.index'))
            ->assertOk()
            ->assertSee('Admin Visible Test')
            ->assertDontSee('Admin Hidden Test')
            ->assertDontSee('Company Hidden Test');
    }

    /**
     * Los correos operativos usan saludo personalizado y cierre institucional.
     */
    public function test_notification_mail_copy_is_personalized_and_branded(): void
    {
        $admin = $this->makeUser(UserRole::Admin, ['name' => 'Laura Administración']);
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::PendingReview);

        $mail = (new AdminVacancyRegisteredNotification($vacancy))->toMail($admin);

        $this->assertSame('Hola, Laura Administración', $mail->greeting);
        $this->assertContains(
            'Te compartimos una actualización del Sistema Municipal de Empleo Lerma.',
            $mail->introLines
        );
        $this->assertStringContainsString('Ayuntamiento de Lerma', $mail->salutation);
    }

    /**
     * La plantilla HTML usa el logo oficial en lugar de texto genérico de Laravel.
     */
    public function test_notification_mail_template_uses_official_lerma_logo(): void
    {
        $html = view('vendor.mail.html.header', ['url' => config('app.url')])->render();

        $this->assertStringContainsString('https://lerma.gob.mx/wp-content/uploads/logo_lerma.svg', $html);
        $this->assertStringContainsString('alt="Ayuntamiento de Lerma"', $html);
    }

    /**
     * El HTML final del correo no debe conservar el footer default en inglés.
     */
    public function test_rendered_notification_mail_footer_is_in_spanish(): void
    {
        $admin = $this->makeUser(UserRole::Admin, ['name' => 'Laura Administración']);
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::PendingReview);

        $html = (string) (new AdminVacancyRegisteredNotification($vacancy))->toMail($admin)->render();

        $this->assertStringContainsString('Derechos reservados', $html);
        $this->assertStringContainsString('Ayuntamiento de Lerma', $html);
        $this->assertStringNotContainsString('All rights reserved', $html);
    }

    /**
     * Aprobación y rechazo de vacantes avisan a la empresa dueña.
     */
    public function test_admin_vacancy_decisions_notify_company(): void
    {
        Notification::fake();

        $admin = $this->makeUser(UserRole::Admin);
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::PendingReview);

        $this->actingAs($admin)->patch(route('admin.vacancies.approve', $vacancy))->assertRedirect();
        Notification::assertSentTo($company->user, VacancyApprovedNotification::class);

        $otherVacancy = $this->makeVacancy($company, VacancyStatus::PendingReview, 'vacante-rechazo-test');
        $this->actingAs($admin)->patch(route('admin.vacancies.reject', $otherVacancy))->assertRedirect();
        Notification::assertSentTo($company->user, VacancyRejectedNotification::class);
    }

    /**
     * Al aprobar una vacante se encola la notificación para la empresa.
     */
    public function test_approved_vacancy_queues_company_notification(): void
    {
        Mail::fake();
        Queue::fake();

        $admin = $this->makeUser(UserRole::Admin);
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::PendingReview);

        $this->actingAs($admin)
            ->patch(route('admin.vacancies.approve', $vacancy))
            ->assertRedirect();

        $this->assertQueuedNotificationFor($company->user, VacancyApprovedNotification::class);
    }

    /**
     * Una postulación avisa tanto a empresa como a ciudadano.
     */
    public function test_application_creation_notifies_company_and_citizen(): void
    {
        Notification::fake();

        $citizen = $this->makeCitizenWithProfile();
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::Published);

        $this->actingAs($citizen)
            ->post(route('citizen.vacancies.apply', $vacancy))
            ->assertRedirect(route('citizen.applications.index'));

        Notification::assertSentTo($company->user, ApplicationCreatedNotification::class);
        Notification::assertSentTo($citizen, CitizenApplicationCreatedNotification::class);
    }

    /**
     * La postulación debe encolar notificaciones para empresa y ciudadano.
     */
    public function test_application_creation_queues_database_notifications(): void
    {
        Mail::fake();
        Queue::fake();

        $citizen = $this->makeCitizenWithProfile();
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::Published);

        $this->actingAs($citizen)
            ->post(route('citizen.vacancies.apply', $vacancy))
            ->assertRedirect(route('citizen.applications.index'));

        $this->assertQueuedNotificationFor($company->user, ApplicationCreatedNotification::class);
        $this->assertQueuedNotificationFor($citizen, CitizenApplicationCreatedNotification::class);
    }

    /**
     * Cuando admin marca cubierta una vacante, avisa a empresa y postulantes.
     */
    public function test_admin_marking_vacancy_covered_notifies_company_and_applicants(): void
    {
        Notification::fake();

        $admin = $this->makeUser(UserRole::Admin);
        $citizen = $this->makeCitizenWithProfile();
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::Published);
        $this->makeApplication($citizen->citizenProfile, $vacancy);

        $this->actingAs($admin)
            ->patch(route('admin.vacancies.covered', $vacancy))
            ->assertRedirect();

        Notification::assertSentTo($company->user, CompanyVacancyCoveredNotification::class);
        Notification::assertSentTo($citizen, CitizenVacancyCoveredNotification::class);
    }

    /**
     * Cuando empresa marca cubierta una vacante, avisa a los ciudadanos postulados.
     */
    public function test_company_marking_vacancy_covered_notifies_applicants(): void
    {
        Notification::fake();

        $citizen = $this->makeCitizenWithProfile();
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::Published);
        $this->makeApplication($citizen->citizenProfile, $vacancy);

        $this->actingAs($company->user)
            ->patch(route('company.vacancies.covered', $vacancy))
            ->assertRedirect();

        Notification::assertSentTo($citizen, CitizenVacancyCoveredNotification::class);
    }

    /**
     * Cuando empresa marca contratado, el ciudadano recibe aviso.
     */
    public function test_hired_status_notifies_citizen(): void
    {
        Notification::fake();

        $citizen = $this->makeCitizenWithProfile();
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::Published);
        $application = $this->makeApplication($citizen->citizenProfile, $vacancy);

        $this->actingAs($company->user)
            ->patch(route('company.applicants.status', $application), [
                'status' => ApplicationStatus::Hired->value,
            ])
            ->assertRedirect();

        Notification::assertSentTo($citizen, CitizenHiredNotification::class);
    }

    /**
     * Comandos programables notifican credenciales y vacantes vencidas.
     */
    public function test_scheduled_notification_commands_send_expected_notifications(): void
    {
        Notification::fake();

        $expiringCompany = $this->makeUser(UserRole::Company, ['access_expires_at' => now()->addDays(3)]);
        $expiredCitizen = $this->makeUser(UserRole::Citizen, ['access_expires_at' => now()->subDay()]);
        $company = $this->makeCompany();
        $citizen = $this->makeCitizenWithProfile();
        $vacancy = $this->makeVacancy($company, VacancyStatus::Published, 'vacante-vencida-test', ['expires_at' => now()->subDay()]);
        $this->makeApplication($citizen->citizenProfile, $vacancy);

        Artisan::call('notifications:access-expiration');
        Artisan::call('notifications:vacancy-expiration');

        Notification::assertSentTo($expiringCompany, CredentialExpiringNotification::class);
        Notification::assertSentTo($expiredCitizen, CredentialExpiredNotification::class);
        Notification::assertSentTo($company->user, CompanyVacancyExpiredNotification::class);
        Notification::assertSentTo($citizen, CitizenVacancyExpiredNotification::class);
    }

    /**
     * Los usuarios pueden marcar notificaciones propias como leídas.
     */
    public function test_company_can_mark_own_notifications_as_read(): void
    {
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::Published);

        Notification::sendNow($company->user, new CompanyVacancyCreatedNotification($vacancy));
        $notification = $company->user->notifications()->firstOrFail();

        $this->actingAs($company->user)
            ->patch(route('company.notifications.read', $notification))
            ->assertRedirect();

        $this->assertNotNull($notification->fresh()->read_at);
    }

    /**
     * Una empresa no puede marcar notificaciones de otra cuenta.
     */
    public function test_company_cannot_mark_other_user_notification_as_read(): void
    {
        $company = $this->makeCompany();
        $otherCompany = $this->makeCompany();
        $vacancy = $this->makeVacancy($otherCompany, VacancyStatus::Published);

        Notification::sendNow($otherCompany->user, new CompanyVacancyCreatedNotification($vacancy));
        $notification = $otherCompany->user->notifications()->firstOrFail();

        $this->actingAs($company->user)
            ->patch(route('company.notifications.read', $notification))
            ->assertNotFound();
    }

    /**
     * Marcar todas como leídas actualiza las pendientes del usuario autenticado.
     */
    public function test_citizen_can_mark_all_notifications_as_read(): void
    {
        $citizen = $this->makeCitizenWithProfile();
        $company = $this->makeCompany();
        $vacancy = $this->makeVacancy($company, VacancyStatus::Published);
        $application = $this->makeApplication($citizen->citizenProfile, $vacancy);

        Notification::sendNow($citizen, new CitizenApplicationCreatedNotification($application));
        Notification::sendNow($citizen, new CitizenHiredNotification($application));

        $this->actingAs($citizen)
            ->patch(route('citizen.notifications.read-all'))
            ->assertRedirect();

        $this->assertSame(0, $citizen->fresh()->unreadNotifications()->count());
    }

    /**
     * Crea usuario verificado y vigente con rol específico.
     */
    private function makeUser(UserRole $role, array $overrides = []): User
    {
        return User::factory()->create($overrides + [
            'role' => $role,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);
    }

    /**
     * Crea empresa activa con usuario relacionado.
     */
    private function makeCompany(): Company
    {
        $user = $this->makeUser(UserRole::Company);

        return Company::create([
            'user_id' => $user->id,
            'business_name' => 'Empresa Notificable',
            'primary_email' => $user->email,
            'status' => CompanyStatus::Active,
        ]);
    }

    /**
     * Crea ciudadano con perfil mínimo para postularse.
     */
    private function makeCitizenWithProfile(): User
    {
        $user = $this->makeUser(UserRole::Citizen);

        CitizenProfile::create([
            'user_id' => $user->id,
            'full_name' => 'Ciudadano Notificable',
            'curp' => fake()->regexify('[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9]{2}'),
            'phone' => '7280000000',
            'completed_at' => now(),
        ]);

        return $user->fresh();
    }

    /**
     * Crea vacante para pruebas de aprobación, postulación o vencimiento.
     */
    private function makeVacancy(Company $company, VacancyStatus $status, string $slug = 'vacante-notificable-test', array $overrides = []): Vacancy
    {
        return Vacancy::create($overrides + [
            'company_id' => $company->id,
            'title' => str($slug)->replace('-', ' ')->title(),
            'slug' => $slug,
            'open_positions' => 1,
            'status' => $status,
            'published_at' => $status === VacancyStatus::Published ? now() : null,
            'expires_at' => now()->addMonth(),
        ]);
    }

    /**
     * Registra una postulación existente para pruebas de seguimiento.
     */
    private function makeApplication(CitizenProfile $profile, Vacancy $vacancy): Application
    {
        return Application::create([
            'vacancy_id' => $vacancy->id,
            'company_id' => $vacancy->company_id,
            'citizen_profile_id' => $profile->id,
            'status' => ApplicationStatus::Submitted,
            'submitted_at' => now(),
        ]);
    }

    /**
     * Verifica que una notificación queued apunte al usuario esperado.
     */
    private function assertQueuedNotificationFor(User $user, string $notificationClass): void
    {
        Queue::assertPushed(SendQueuedNotifications::class, function (SendQueuedNotifications $job) use ($user, $notificationClass) {
            return $job->notification instanceof $notificationClass
                && $job->notifiables->contains(fn ($notifiable) => $notifiable->is($user));
        });
    }
}
