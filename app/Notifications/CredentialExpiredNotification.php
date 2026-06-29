<?php

namespace App\Notifications;

use App\Models\User;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Avisa a empresa o ciudadano que su credencial ya venció.
 */
class CredentialExpiredNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private User $user) {}

    /**
     * Correo y registro interno.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo con llamada a revisar renovación.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Credencial vencida',
            'Tu acceso a Empleo Lerma venció. Contacta a administración para recuperar acceso completo.',
            'Revisar mi panel',
            $this->dashboardUrl()
        );
    }

    /**
     * Payload para bandeja del usuario.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'access_expires_at' => optional($this->user->access_expires_at)->toDateString(),
            'message' => 'Tu credencial venció.',
            'url' => $this->dashboardUrl(),
        ];
    }

    /**
     * Resuelve el dashboard del usuario notificado.
     */
    private function dashboardUrl(): string
    {
        return $this->user->isCompany() ? route('company.dashboard') : route('citizen.dashboard');
    }
}
