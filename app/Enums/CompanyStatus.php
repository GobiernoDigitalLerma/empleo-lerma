<?php

namespace App\Enums;

/**
 * Estados de revisión y operación de una empresa registrada.
 */
enum CompanyStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Rejected = 'rejected';
    case Suspended = 'suspended';

    /**
     * Etiqueta en español para paneles administrativos.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Active => 'Activa',
            self::Rejected => 'Rechazada',
            self::Suspended => 'Suspendida',
        };
    }
}
