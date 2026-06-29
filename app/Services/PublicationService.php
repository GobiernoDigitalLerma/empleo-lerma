<?php

namespace App\Services;

use App\Enums\EventStatus;
use App\Enums\VacancyStatus;
use App\Models\Event;
use App\Models\Vacancy;

/**
 * Servicio para publicar contenido revisado por administración.
 */
class PublicationService
{
    /**
     * Marca una vacante como publicada y registra quién la aprobó.
     */
    public function publishVacancy(Vacancy $vacancy, int $approvedBy): Vacancy
    {
        $vacancy->forceFill([
            'status' => VacancyStatus::Published,
            'published_at' => now(),
            'approved_at' => now(),
            'approved_by' => $approvedBy,
            'rejected_at' => null,
            'rejection_reason' => null,
        ])->save();

        return $vacancy;
    }

    /**
     * Marca un evento como publicado por un usuario administrador.
     */
    public function publishEvent(Event $event, int $userId): Event
    {
        $event->forceFill([
            'status' => EventStatus::Published,
            'published_at' => now(),
            'updated_by' => $userId,
        ])->save();

        return $event;
    }
}
