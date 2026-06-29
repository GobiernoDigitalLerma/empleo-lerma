<?php

namespace Tests\Feature;

use App\Enums\AccessStatus;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pruebas de seguridad para middleware de rol y vigencia.
 */
class AccessMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Un ciudadano no debe entrar al dashboard administrativo.
     */
    public function test_admin_dashboard_requires_admin_role(): void
    {
        $user = User::factory()->create(['role' => UserRole::Citizen, 'status' => AccessStatus::Active]);

        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
    }

    /**
     * Un usuario revocado queda bloqueado aunque tenga el rol correcto.
     */
    public function test_revoked_user_is_blocked(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::Admin,
            'status' => AccessStatus::Revoked,
            'revoked_at' => now(),
        ]);

        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
    }
}
