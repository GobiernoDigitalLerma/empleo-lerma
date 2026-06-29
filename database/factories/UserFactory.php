<?php

namespace Database\Factories;

use App\Enums\AccessStatus;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Factory base para usuarios de pruebas.
 *
 * Genera cuentas activas y verificadas para que los tests puedan enfocarse en
 * el comportamiento del módulo que están validando.
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define datos seguros y repetibles para crear usuarios en tests.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => fake()->numerify('728#######'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => UserRole::Citizen,
            'status' => AccessStatus::Active,
            'access_expires_at' => now()->addYear(),
        ];
    }
}
