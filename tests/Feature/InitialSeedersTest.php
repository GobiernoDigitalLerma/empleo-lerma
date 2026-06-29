<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Catalog;
use App\Models\Company;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Verifica la carga inicial segura para producción.
 */
class InitialSeedersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * AdminSeeder crea el administrador sin depender de datos demo.
     */
    public function test_admin_seeder_creates_initial_admin(): void
    {
        $this->seed(AdminSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@lerma.gob.mx',
            'role' => UserRole::Admin->value,
        ]);
    }

    /**
     * AdminSeeder y CatalogSeeder son suficientes para una base productiva inicial.
     */
    public function test_production_seeders_create_admin_and_catalogs_without_demo_companies(): void
    {
        $this->seed([
            AdminSeeder::class,
            CatalogSeeder::class,
        ]);

        $this->assertSame(1, User::where('role', UserRole::Admin->value)->count());
        $this->assertGreaterThan(0, Catalog::query()->count());
        $this->assertSame(0, Company::query()->count());
    }
}
