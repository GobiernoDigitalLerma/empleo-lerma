<?php

namespace App\Notifications;

use App\Models\Application;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifica a empresa/usuario que una postulación fue creada.
 */
class ApplicationCreatedNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Application $application) {}

    /**
     * Envía correo y guarda copia en la tabla notifications.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Contenido del correo enviado por queue.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return $this->dashboardMail(
            $notifiable,
            'Nueva postulación',
            "Se registró una nueva postulación para {$this->application->vacancy?->title}.",
            'Revisar postulantes',
            route('company.applicants.index', ['vacancy_id' => $this->application->vacancy_id])
        );
    }

    /**
     * Payload mínimo para mostrar notificación dentro del dashboard.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'vacancy_id' => $this->application->vacancy_id,
            'message' => "Nueva postulación para {$this->application->vacancy?->title}.",
            'url' => route('company.applicants.index', ['vacancy_id' => $this->application->vacancy_id]),
        ];
    }
}
