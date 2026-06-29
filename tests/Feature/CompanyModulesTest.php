<?php

namespace Tests\Feature;

use App\Enums\AccessStatus;
use App\Enums\CompanyStatus;
use App\Enums\UserRole;
use App\Enums\VacancyStatus;
use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Valida el flujo operativo de empresa: perfil, vacantes, postulados y avisos.
 */
class CompanyModulesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Las secciones principales del dashboard empresa deben cargar con vistas reales.
     */
    public function test_company_operational_sections_render(): void
    {
        $this->seed();

        $company = Company::firstOrFail();
        $user = $company->user;

        $sections = [
            route('company.profile.edit') => 'Datos empresariales',
            route('company.vacancies.index') => 'Nueva vacante',
            route('company.vacancies.create') => 'Información de la vacante',
            route('company.applicants.index') => 'Postulados',
            route('company.notifications.index') => 'Notificaciones',
        ];

        foreach ($sections as $uri => $expectedText) {
            $this->actingAs($user)
                ->get($uri)
                ->assertOk()
                ->assertSee($expectedText);
        }
    }

    /**
     * El formulario de nueva vacante debe tener action POST real para guardar.
     */
    public function test_create_vacancy_view_contains_post_form(): void
    {
        $company = $this->makeCompany(CompanyStatus::Active);

        $this->actingAs($company->user)
            ->get(route('company.vacancies.create'))
            ->assertOk()
            ->assertSee('method="POST"', false)
            ->assertSee('action="'.route('company.vacancies.store').'"', false);
    }

    /**
     * Una empresa activa puede enviar una vacante a revisión municipal.
     */
    public function test_active_company_can_create_pending_review_vacancy(): void
    {
        $company = $this->makeCompany(CompanyStatus::Active);

        $this->actingAs($company->user)
            ->post(route('company.vacancies.store'), [
                'title' => 'Capturista administrativo',
                'employment_type' => 'Tiempo completo',
                'short_description' => 'Captura y seguimiento documental.',
                'municipality' => 'Lerma',
                'state' => 'Estado de México',
                'monthly_salary' => 9800,
                'open_positions' => 2,
                'intent' => 'submit',
            ])
            ->assertRedirect(route('company.vacancies.index'));

        $this->assertDatabaseHas('vacancies', [
            'company_id' => $company->id,
            'title' => 'Capturista administrativo',
            'status' => VacancyStatus::PendingReview->value,
        ]);
    }

    /**
     * Una empresa pendiente puede guardar borrador, pero no enviarlo a revisión.
     */
    public function test_pending_company_cannot_submit_vacancy_for_review(): void
    {
        $company = $this->makeCompany(CompanyStatus::Pending);

        $this->actingAs($company->user)
            ->from(route('company.vacancies.create'))
            ->post(route('company.vacancies.store'), [
                'title' => 'Auxiliar de almacén',
                'open_positions' => 1,
                'intent' => 'submit',
            ])
            ->assertRedirect(route('company.vacancies.create'))
            ->assertSessionHasErrors('intent');

        $this->assertDatabaseMissing('vacancies', [
            'company_id' => $company->id,
            'title' => 'Auxiliar de almacén',
        ]);
    }

    /**
     * El enlace público sólo debe aparecer cuando la vacante ya es visible.
     */
    public function test_public_link_is_hidden_until_vacancy_is_published(): void
    {
        $company = $this->makeCompany(CompanyStatus::Active);

        $draft = Vacancy::create([
            'company_id' => $company->id,
            'title' => 'Vacante en borrador',
            'slug' => 'vacante-en-borrador-test',
            'open_positions' => 1,
            'status' => VacancyStatus::Draft,
        ]);

        $published = Vacancy::create([
            'company_id' => $company->id,
            'title' => 'Vacante publicada',
            'slug' => 'vacante-publicada-test',
            'open_positions' => 1,
            'status' => VacancyStatus::Published,
            'published_at' => now(),
            'expires_at' => now()->addMonth(),
        ]);

        $this->actingAs($company->user)
            ->get(route('company.vacancies.index'))
            ->assertOk()
            ->assertDontSee(route('vacancies.show', $draft), false)
            ->assertSee(route('vacancies.show', $published), false);
    }

    /**
     * Cuando admin aprueba una vacante, empresa debe poder abrirla en público.
     */
    public function test_public_link_appears_after_admin_approves_vacancy(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::Admin,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);
        $company = $this->makeCompany(CompanyStatus::Active);
        $vacancy = Vacancy::create([
            'company_id' => $company->id,
            'title' => 'Vacante aprobada por admin',
            'slug' => 'vacante-aprobada-por-admin-test',
            'open_positions' => 1,
            'status' => VacancyStatus::PendingReview,
            'expires_at' => today(),
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.vacancies.approve', $vacancy))
            ->assertRedirect();

        $this->actingAs($company->user)
            ->get(route('company.vacancies.index'))
            ->assertOk()
            ->assertSee(route('vacancies.show', $vacancy), false);
    }

    /**
     * Una empresa no debe editar vacantes pertenecientes a otra empresa.
     */
    public function test_company_cannot_edit_another_company_vacancy(): void
    {
        $company = $this->makeCompany(CompanyStatus::Active, 'empresa-a@lerma.gob.mx');
        $otherCompany = $this->makeCompany(CompanyStatus::Active, 'empresa-b@lerma.gob.mx');

        $foreignVacancy = Vacancy::create([
            'company_id' => $otherCompany->id,
            'title' => 'Vacante ajena',
            'slug' => 'vacante-ajena-test',
            'open_positions' => 1,
            'status' => VacancyStatus::Draft,
        ]);

        $this->actingAs($company->user)
            ->get(route('company.vacancies.edit', $foreignVacancy))
            ->assertNotFound();
    }

    /**
     * Crea usuario y empresa mínimos para no depender de factories adicionales.
     */
    private function makeCompany(CompanyStatus $status, string $email = 'empresa.test@lerma.gob.mx'): Company
    {
        $user = User::factory()->create([
            'name' => 'Empresa Test',
            'email' => $email,
            'role' => UserRole::Company,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);

        return Company::create([
            'user_id' => $user->id,
            'business_name' => 'Empresa Test',
            'rfc' => strtoupper(fake()->bothify('???######??#')),
            'primary_email' => $email,
            'primary_phone' => '7280000000',
            'municipality' => 'Lerma',
            'state' => 'Estado de México',
            'status' => $status,
        ]);
    }
}
