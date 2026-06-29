<?php

namespace App\Notifications;

use App\Models\Application;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Confirma al ciudadano que su postulación fue enviada.
 */
class CitizenApplicationCreatedNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Application $application) {}

    /**
     * Notifica por correo y dashboard.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo con liga al historial ciudadano.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Postulación enviada',
            "Tu postulación a {$this->application->vacancy?->title} fue registrada.",
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
            'message' => "Postulación enviada a {$this->application->vacancy?->title}.",
            'url' => route('citizen.applications.index'),
        ];
    }
}
