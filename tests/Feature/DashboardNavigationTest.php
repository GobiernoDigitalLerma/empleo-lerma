<?php

namespace Tests\Feature;

use App\Enums\AccessStatus;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Verifica que cada rol vea una navegación operativa distinta.
 */
class DashboardNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_admin_menu_items(): void
    {
        $user = $this->verifiedUser(UserRole::Admin);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Ciudadanos')
            ->assertSee('Empresas')
            ->assertSee('Auditoría');
    }

    public function test_admin_users_section_renders_operational_table(): void
    {
        $user = $this->verifiedUser(UserRole::Admin);
        $citizen = $this->verifiedUser(UserRole::Citizen);
        $company = $this->verifiedUser(UserRole::Company);

        $this->actingAs($user)
            ->get('/admin/usuarios')
            ->assertOk()
            ->assertSee('Ciudadanos')
            ->assertSee('Nombre, correo o teléfono')
            ->assertSee('Renovar')
            ->assertSee($citizen->email)
            ->assertDontSee($user->email)
            ->assertDontSee($company->email);
    }

    public function test_company_sees_company_menu_items(): void
    {
        $user = $this->verifiedUser(UserRole::Company);

        $this->actingAs($user)
            ->get('/empresa/dashboard')
            ->assertOk()
            ->assertSee('Datos empresariales')
            ->assertSee('Nueva vacante')
            ->assertSee('Postulados');
    }

    public function test_citizen_sees_citizen_menu_items(): void
    {
        $user = $this->verifiedUser(UserRole::Citizen);

        $this->actingAs($user)
            ->get('/ciudadano/dashboard')
            ->assertOk()
            ->assertSee('Mis datos')
            ->assertSee('Mi currículum')
            ->assertSee('Vacantes para mí');
    }

    /**
     * Crea un usuario listo para pasar auth, verified y access.active.
     */
    private function verifiedUser(UserRole $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'status' => AccessStatus::Active,
            'email_verified_at' => now(),
            'access_expires_at' => now()->addMonth(),
        ]);
    }
}
