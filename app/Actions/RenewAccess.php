<?php

namespace App\Actions;

use App\Models\User;
use App\Services\AuditService;
use App\Services\CredentialService;

/**
 * Renueva la credencial de acceso de un usuario.
 */
class RenewAccess
{
    public function __construct(private CredentialService $credentials, private AuditService $audit) {}

    /**
     * Activa al usuario por el número de meses indicado y audita el cambio.
     */
    public function handle(User $user, int $months = 12): User
    {
        $old = $user->only(['status', 'access_expires_at', 'revoked_at']);
        $this->credentials->activate($user, now()->addMonths($months));
        $this->audit->log('access.renewed', $user, $old, $user->only(['status', 'access_expires_at', 'revoked_at']));
        return $user;
    }
}
