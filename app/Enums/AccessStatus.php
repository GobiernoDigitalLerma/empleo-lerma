<?php

namespace App\Enums;

/**
 * Estado de acceso del usuario.
 *
 * Permite bloquear dashboards sin eliminar cuentas históricas o auditables.
 */
enum AccessStatus: string
{
    case Active = 'active';
    case Expired = 'expired';
    case Suspended = 'suspended';
    case Revoked = 'revoked';

    /**
     * Etiqueta en español para paneles administrativos.
     */
    public function label(): string
    {
        return match ($this) {
            self::Active => 'Activo',
            self::Expired => 'Vencido',
            self::Suspended => 'Suspendido',
            self::Revoked => 'Revocado',
        };
    }
}
