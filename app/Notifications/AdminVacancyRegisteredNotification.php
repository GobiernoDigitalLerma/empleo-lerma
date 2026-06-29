<?php

namespace App\Notifications;

use App\Models\Vacancy;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Avisa a administradores que una vacante nueva requiere revisión.
 */
class AdminVacancyRegisteredNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Vacancy $vacancy) {}

    /**
     * Envía correo y persiste notificación interna.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo con acceso directo al detalle interno de la vacante.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Nueva vacante registrada',
            "La vacante {$this->vacancy->title} fue enviada a revisión.",
            'Revisar vacante',
            route('admin.vacancies.show', $this->vacancy)
        );
    }

    /**
     * Payload usado por el dashboard de notificaciones admin.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vacancy_id' => $this->vacancy->id,
            'company_id' => $this->vacancy->company_id,
            'message' => "Nueva vacante registrada: {$this->vacancy->title}.",
            'url' => route('admin.vacancies.show', $this->vacancy),
        ];
    }
}
