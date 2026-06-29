<?php

namespace App\Notifications;

use App\Models\User;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Avisa a empresa o ciudadano que su credencial está por vencer.
 */
class CredentialExpiringNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private User $user) {}

    /**
     * Correo y dashboard.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo con liga al dashboard del rol correspondiente.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Credencial por vencer',
            'Tu acceso a Empleo Lerma está por vencer. Revisa tu panel o contacta a administración para renovarlo.',
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
            'message' => 'Tu credencial está por vencer.',
            'url' => $this->dashboardUrl(),
        ];
    }

    /**
     * Resuelve el dashboard según rol del usuario.
     */
    private function dashboardUrl(): string
    {
        return $this->user->isCompany() ? route('company.dashboard') : route('citizen.dashboard');
    }
}
