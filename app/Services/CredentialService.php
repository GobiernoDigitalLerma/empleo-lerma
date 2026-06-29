<?php

namespace App\Services;

use App\Enums\AccessStatus;
use App\Models\User;
use Carbon\CarbonInterface;

/**
 * Servicio para administrar vigencia y bloqueo de credenciales.
 */
class CredentialService
{
    /**
     * Activa o renueva acceso hasta una fecha determinada.
     */
    public function activate(User $user, ?CarbonInterface $expiresAt = null): User
    {
        $user->forceFill([
            'status' => AccessStatus::Active,
            'access_expires_at' => $expiresAt ?? now()->addYear(),
            'revoked_at' => null,
        ])->save();

        return $user;
    }

    /**
     * Suspende temporalmente el acceso sin borrar al usuario.
     */
    public function suspend(User $user): User
    {
        $user->forceFill(['status' => AccessStatus::Suspended])->save();
        return $user;
    }

    /**
     * Revoca el acceso y conserva la fecha para trazabilidad.
     */
    public function revoke(User $user): User
    {
        $user->forceFill(['status' => AccessStatus::Revoked, 'revoked_at' => now()])->save();
        return $user;
    }
}
