<?php

namespace App\Notifications;

use App\Models\Vacancy;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifica a la empresa que una vacante fue aprobada.
 */
class VacancyApprovedNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Vacancy $vacancy) {}

    /**
     * Envía correo y guarda notificación interna.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Mensaje de correo con el título de la vacante aprobada.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return $this->dashboardMail(
            $notifiable,
            'Vacante aprobada',
            "La vacante {$this->vacancy->title} fue aprobada y publicada.",
            'Ver vacante pública',
            route('vacancies.show', $this->vacancy)
        );
    }

    /**
     * Payload de base de datos para mostrar en dashboard.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vacancy_id' => $this->vacancy->id,
            'message' => "Vacante aprobada: {$this->vacancy->title}.",
            'url' => route('vacancies.show', $this->vacancy),
        ];
    }
}
