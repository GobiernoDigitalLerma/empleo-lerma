<?php

namespace App\Notifications;

use App\Models\Application;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Avisa al ciudadano que una vacante postulada fue marcada como cubierta.
 */
class CitizenVacancyCoveredNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Application $application) {}

    /**
     * Notifica por correo y guarda copia en el dashboard ciudadano.
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
            'Vacante cubierta',
            "La vacante {$this->application->vacancy?->title} a la que te postulaste fue marcada como cubierta.",
            'Revisar mis postulaciones',
            route('citizen.applications.index')
        );
    }

    /**
     * Payload para que el dashboard muestre un mensaje comprensible.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'vacancy_id' => $this->application->vacancy_id,
            'message' => "La vacante {$this->application->vacancy?->title} fue marcada como cubierta.",
            'url' => route('citizen.applications.index'),
        ];
    }
}
