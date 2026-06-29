<?php

namespace App\Notifications;

use App\Models\Application;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Avisa al ciudadano que una vacante postulada venció.
 */
class CitizenVacancyExpiredNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Application $application) {}

    /**
     * Envío por correo y registro interno.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo con liga al historial de postulaciones.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Vacante vencida',
            "La vacante {$this->application->vacancy?->title} a la que te postulaste ya venció.",
            'Revisar mis postulaciones',
            route('citizen.applications.index')
        );
    }

    /**
     * Payload para dashboard ciudadano.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'vacancy_id' => $this->application->vacancy_id,
            'message' => "La vacante {$this->application->vacancy?->title} ya venció.",
            'url' => route('citizen.applications.index'),
        ];
    }
}
