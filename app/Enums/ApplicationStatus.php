<?php

namespace App\Enums;

/**
 * Estados del proceso de postulación ciudadano-vacante.
 */
enum ApplicationStatus: string
{
    case Submitted = 'submitted';
    case Reviewed = 'reviewed';
    case Contacted = 'contacted';
    case Hired = 'hired';
    case Rejected = 'rejected';
    case Withdrawn = 'withdrawn';

    /**
     * Etiqueta en español para dashboards de seguimiento.
     */
    public function label(): string
    {
        return match ($this) {
            self::Submitted => 'Enviada',
            self::Reviewed => 'Revisada',
            self::Contacted => 'Contactado',
            self::Hired => 'Contratado',
            self::Rejected => 'Rechazada',
            self::Withdrawn => 'Retirada',
        };
    }
}
