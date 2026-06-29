<?php

namespace Tests\Feature;

use App\Enums\AccessStatus;
use App\Enums\CompanyStatus;
use App\Enums\UserRole;
use App\Enums\VacancyStatus;
use App\Models\CitizenProfile;
use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Valida el dashboard ciudadano: perfil, currículum, postulaciones y avisos.
 */
class CitizenModulesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Las secciones principales del ciudadano deben renderizar vistas reales.
     */
    public function test_citizen_operational_sections_render(): void
    {
        $this->seed();

        $user = User::where('role', UserRole::Citizen)->firstOrFail();

        $sections = [
            route('citizen.profile.edit') => 'Mis datos',
            route('citizen.resume.edit') => 'Mi currículum',
            route('citizen.applications.index') => 'Mis postulaciones',
            route('citizen.vacancies.recommended') => 'Vacantes para mí',
            route('citizen.notifications.index') => 'Notificaciones',
        ];

        foreach ($sections as $uri => $expectedText) {
            $this->actingAs($user)
                ->get($uri)
                ->assertOk()
                ->assertSee($expectedText);
        }
    }

    /**
     * El ciudadano puede completar el perfil mínimo requerido para postular.
     */
    public function test_citizen_can_update_profile(): void
    {
        $user = $this->makeCitizen();

        $this->actingAs($user)
            ->put(route('citizen.profile.update'), [
                'full_name' => 'Ciudadano Prueba',
                'curp' => 'CUPR900101HMCXXX01',
                'phone' => '7280000000',
                'municipality' => 'Lerma',
                'state' => 'Estado de México',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('citizen_profiles', [
            'user_id' => $user->id,
            'full_name' => 'Ciudadano Prueba',
            'curp' => 'CUPR900101HMCXXX01',
        ]);

        $this->assertNotNull($user->fresh()->citizenProfile->completed_at);
    }

    /**
     * El ciudadano puede guardar escolaridad, experiencia y preferencias.
     */
    public function test_citizen_can_update_resume_sections(): void
    {
        $user = $this->makeCitizenWithProfile();

        $this->actingAs($user)
            ->put(route('citizen.resume.update'), [
                'education_level' => 'Bachillerato',
                'academic_status' => 'Concluido',
                'job_title' => 'Auxiliar administrativo',
                'functions' => 'Captura de datos y seguimiento documental.',
                'desired_position' => 'Capturista',
                'desired_employment_type' => 'Tiempo completo',
                'preferred_municipality' => 'Lerma',
            ])
            ->assertRedirect();

        $profile = $user->fresh()->citizenProfile;

        $this->assertDatabaseHas('citizen_education', [
            'citizen_profile_id' => $profile->id,
            'education_level' => 'Bachillerato',
        ]);

        $this->assertDatabaseHas('citizen_preferences', [
            'citizen_profile_id' => $profile->id,
            'desired_position' => 'Capturista',
        ]);
    }

    /**
     * El CV se guarda en storage privado y queda registrado como documento vigente.
     */
    public function test_citizen_can_upload_private_cv(): void
    {
        Storage::fake('local');

        $user = $this->makeCitizenWithProfile();

        $this->actingAs($user)
            ->post(route('citizen.resume.cv.upload'), [
                'cv_file' => UploadedFile::fake()->create('cv.pdf', 128, 'application/pdf'),
            ])
            ->assertRedirect();

        $document = $user->fresh()->citizenProfile->documents()->firstOrFail();

        Storage::disk('local')->assertExists($document->path);

        $this->assertDatabaseHas('citizen_documents', [
            'citizen_profile_id' => $user->citizenProfile->id,
            'type' => 'cv',
            'is_current' => true,
        ]);
    }

    /**
     * Un ciudadano con perfil completo puede postularse a una vacante pública.
     */
    public function test_citizen_can_apply_to_public_vacancy(): void
    {
        $user = $this->makeCitizenWithProfile();
        $vacancy = $this->makePublishedVacancy();

        $this->actingAs($user)
            ->post(route('citizen.vacancies.apply', $vacancy))
            ->assertRedirect(route('citizen.applications.index'));

        $this->assertDatabaseHas('applications', [
            'vacancy_id' => $vacancy->id,
            'citizen_profile_id' => $user->citizenProfile->id,
            'status' => 'submitted',
        ]);
    }

    /**
     * Crea ciudadano activo sin perfil para probar creación automática.
     */
    private function makeCitizen(): User
    {
        return User::factory()->create([
            'role' => UserRole::Citizen,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);
    }

    /**
     * Crea ciudadano con perfil mínimo completo para flujos protegidos.
     */
    private function makeCitizenWithProfile(): User
    {
        $user = $this->makeCitizen();

        CitizenProfile::create([
            'user_id' => $user->id,
            'full_name' => 'Ciudadano Prueba',
            'curp' => 'CUPR900101HMCXXX01',
            'phone' => '7280000000',
            'municipality' => 'Lerma',
            'state' => 'Estado de México',
            'completed_at' => now(),
        ]);

        return $user->fresh();
    }

    /**
     * Crea una vacante visible públicamente para validar postulaciones.
     */
    private function makePublishedVacancy(): Vacancy
    {
        $companyUser = User::factory()->create([
            'role' => UserRole::Company,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);

        $company = Company::create([
            'user_id' => $companyUser->id,
            'business_name' => 'Empresa Pública',
            'status' => CompanyStatus::Active,
        ]);

        return Vacancy::create([
            'company_id' => $company->id,
            'title' => 'Capturista público',
            'slug' => 'capturista-publico-test',
            'open_positions' => 1,
            'status' => VacancyStatus::Published,
            'published_at' => now(),
            'expires_at' => now()->addMonth(),
        ]);
    }
}
