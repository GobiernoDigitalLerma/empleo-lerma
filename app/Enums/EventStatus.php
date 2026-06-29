<?php

namespace App\Enums;

/**
 * Estados de publicación de eventos visibles en el portal.
 */
enum EventStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';

    /**
     * Etiqueta en español para administración de eventos.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Borrador',
            self::Published => 'Publicado',
            self::Archived => 'Archivado',
        };
    }
}
