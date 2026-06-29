<?php

namespace Database\Seeders;

use App\Enums\AccessStatus;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

/**
 * Crea el usuario administrador inicial de Empleo Lerma.
 *
 * En producción exige credenciales explícitas por variables de entorno para
 * evitar que una instalación real quede con contraseñas demo.
 */
class AdminSeeder extends Seeder
{
    /**
     * Registra el administrador base de forma idempotente.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', app()->isProduction() ? null : 'admin@lerma.gob.mx');
        $password = env('ADMIN_PASSWORD', app()->isProduction() ? null : 'Password123!');

        if (blank($email) || blank($password)) {
            throw new RuntimeException('Configura ADMIN_EMAIL y ADMIN_PASSWORD antes de crear el administrador.');
        }

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Administrador Empleo Lerma'),
                'password' => Hash::make($password),
                'role' => UserRole::Admin,
                'status' => AccessStatus::Active,
                'email_verified_at' => now(),
            ]
        );
    }
}
