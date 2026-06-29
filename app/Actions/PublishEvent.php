<?php

namespace App\Actions;

use App\Models\Event;
use App\Services\AuditService;
use App\Services\PublicationService;

/**
 * Publica un evento y registra la acción en auditoría.
 */
class PublishEvent
{
    public function __construct(private PublicationService $publication, private AuditService $audit) {}

    /**
     * Cambia el estado del evento a publicado y guarda valores auditables.
     */
    public function handle(Event $event, int $userId): Event
    {
        $old = $event->only(['status', 'published_at']);
        $this->publication->publishEvent($event, $userId);
        $this->audit->log('event.published', $event, $old, $event->only(['status', 'published_at']));
        return $event;
    }
}
