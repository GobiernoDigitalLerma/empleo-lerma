<?php

namespace App\Notifications;

use App\Models\Vacancy;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Avisa a la empresa que una vacante fue rechazada.
 */
class VacancyRejectedNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Vacancy $vacancy) {}

    /**
     * Canales requeridos para correo y centro de notificaciones.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo con motivo de rechazo cuando exista.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Vacante rechazada',
            "La vacante {$this->vacancy->title} fue rechazada. Motivo: {$this->vacancy->rejection_reason}",
            'Revisar vacantes',
            route('company.vacancies.index')
        );
    }

    /**
     * Payload para dashboard empresa.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vacancy_id' => $this->vacancy->id,
            'message' => "Vacante rechazada: {$this->vacancy->title}.",
            'url' => route('company.vacancies.index'),
        ];
    }
}
