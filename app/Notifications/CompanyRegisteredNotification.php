<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Concerns\BuildsDashboardMail;

/**
 * Confirma recepción del registro de empresa.
 */
class CompanyRegisteredNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    /**
     * Envía correo y guarda notificación interna.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Mensaje para la empresa recién registrada.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return $this->dashboardMail(
            $notifiable,
            'Registro de empresa recibido',
            'Tu empresa fue registrada y quedará pendiente de revisión por el equipo de Empleo Lerma.',
            'Revisar mi panel',
            route('company.dashboard')
        );
    }

    /**
     * Payload compacto para el centro de notificaciones.
     */
    public function toArray(object $notifiable): array
    {
        return ['message' => 'Registro de empresa recibido.', 'url' => route('company.dashboard')];
    }
}
