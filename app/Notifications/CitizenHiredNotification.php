<?php

namespace App\Notifications;

use App\Models\Application;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Avisa al ciudadano cuando la empresa marca su postulación como contratado.
 */
class CitizenHiredNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Application $application) {}

    /**
     * Correo y notificación interna.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo de resultado positivo.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Actualización de postulación',
            "La empresa marcó tu postulación a {$this->application->vacancy?->title} como contratado.",
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
            'message' => "¿Fuiste contratado? La postulación a {$this->application->vacancy?->title} fue marcada como contratada.",
            'url' => route('citizen.applications.index'),
        ];
    }
}
