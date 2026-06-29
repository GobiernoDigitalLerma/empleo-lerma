<?php

namespace Tests\Feature;

use App\Enums\AccessStatus;
use App\Enums\CompanyStatus;
use App\Enums\EventStatus;
use App\Enums\UserRole;
use App\Enums\VacancyStatus;
use App\Models\Catalog;
use App\Models\Company;
use App\Models\Event;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Verifica que los rubros principales del administrador ya rendericen vistas reales.
 */
class AdminModulesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Los módulos admin deben responder con tablas/filtros operables.
     */
    public function test_admin_operational_sections_render(): void
    {
        $this->seed();

        $admin = User::factory()->create([
            'role' => UserRole::Admin,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);

        $sections = [
            '/admin/usuarios' => 'Nombre, correo o teléfono',
            '/admin/empresas' => 'Empresa, RFC o correo',
            '/admin/vacantes' => 'Nombre de vacante',
            '/admin/eventos' => 'Nuevo evento',
            '/admin/catalogos' => 'Nuevo valor',
            '/admin/notificaciones' => 'Notificaciones',
            '/admin/auditoria' => 'Auditoría',
        ];

        foreach ($sections as $uri => $expectedText) {
            $this->actingAs($admin)
                ->get($uri)
                ->assertOk()
                ->assertSee($expectedText);
        }
    }

    /**
     * La aprobación de empresa debe cambiar estado y generar auditoría.
     */
    public function test_admin_can_approve_company_from_dashboard(): void
    {
        $this->seed();

        $admin = User::where('role', UserRole::Admin)->firstOrFail();
        $company = \App\Models\Company::firstOrFail();

        $this->actingAs($admin)
            ->patch(route('admin.companies.approve', $company))
            ->assertRedirect();

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'status' => 'active',
            'approved_by' => $admin->id,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'admin.companies.approve',
            'auditable_id' => $company->id,
        ]);
    }

    /**
     * Admin debe revisar vacantes pendientes sin usar la vista pública.
     */
    public function test_admin_can_view_pending_vacancy_in_internal_detail(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::Admin,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);

        $companyUser = User::factory()->create([
            'role' => UserRole::Company,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);

        $company = Company::create([
            'user_id' => $companyUser->id,
            'business_name' => 'Empresa pendiente',
            'logo_path' => 'images/brand/empresa-demo.svg',
            'status' => CompanyStatus::Active,
        ]);

        $vacancy = Vacancy::create([
            'company_id' => $company->id,
            'title' => 'Vacante pendiente de revisión',
            'slug' => 'vacante-pendiente-revision-test',
            'open_positions' => 1,
            'status' => VacancyStatus::PendingReview,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.vacancies.show', $vacancy))
            ->assertOk()
            ->assertSee('Vacante pendiente de revisión')
            ->assertSee('images/brand/empresa-demo.svg')
            ->assertSee('Pendiente de revisión');

        $this->actingAs($admin)
            ->get(route('vacancies.show', $vacancy))
            ->assertNotFound();
    }

    /**
     * Admin puede eliminar valores de catálogo que aún no están usados.
     */
    public function test_admin_can_delete_unused_catalog_value(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::Admin,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);

        $catalog = Catalog::create([
            'type' => 'municipality',
            'name' => 'Metepec',
            'code' => 'metepec',
            'is_active' => true,
            'sort_order' => 99,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.catalogs.destroy', $catalog))
            ->assertRedirect();

        $this->assertDatabaseMissing('catalogs', [
            'id' => $catalog->id,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'admin.catalogs.delete',
            'auditable_id' => $catalog->id,
        ]);
    }

    /**
     * Admin no puede eliminar catálogos ya usados; debe desactivarlos.
     */
    public function test_admin_cannot_delete_used_catalog_value(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::Admin,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);

        $catalog = Catalog::create([
            'type' => 'municipality',
            'name' => 'Lerma',
            'code' => 'lerma',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $companyUser = User::factory()->create([
            'role' => UserRole::Company,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);

        Company::create([
            'user_id' => $companyUser->id,
            'business_name' => 'Empresa con municipio',
            'municipality' => 'Lerma',
            'status' => CompanyStatus::Active,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.catalogs.destroy', $catalog))
            ->assertRedirect()
            ->assertSessionHasErrors('catalog');

        $this->assertDatabaseHas('catalogs', [
            'id' => $catalog->id,
        ]);
    }

    /**
     * La creación de eventos acepta imagen de publicidad cargada por formulario.
     */
    public function test_admin_can_create_event_with_uploaded_image(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::Admin,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.events.store'), [
            'title' => 'Feria de empleo con imagen',
            'description' => 'Evento con publicidad cargada desde administración.',
            'event_date' => now()->addWeek()->format('Y-m-d H:i:s'),
            'location' => 'Lerma',
            'status' => EventStatus::Published->value,
            'image_file' => UploadedFile::fake()->image('evento.png', 900, 500),
        ]);

        $response->assertRedirect(route('admin.events.index'));

        $event = Event::where('title', 'Feria de empleo con imagen')->firstOrFail();

        $this->assertStringStartsWith('images/events/', $event->image_path);
        $this->assertFileExists(public_path($event->image_path));

        File::delete(public_path($event->image_path));
    }
}
