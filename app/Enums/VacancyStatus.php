<?php

namespace App\Enums;

/**
 * Estados del ciclo de vida de una vacante.
 */
enum VacancyStatus: string
{
    case Draft = 'draft';
    case PendingReview = 'pending_review';
    case Published = 'published';
    case Expired = 'expired';
    case Covered = 'covered';
    case Rejected = 'rejected';

    /**
     * Etiqueta en español para listados y filtros de vacantes.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Borrador',
            self::PendingReview => 'Pendiente de revisión',
            self::Published => 'Publicada',
            self::Expired => 'Vencida',
            self::Covered => 'Cubierta',
            self::Rejected => 'Rechazada',
        };
    }
}
