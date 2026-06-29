<?php

namespace App\Notifications;

use App\Models\Company;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Avisa a administradores que una empresa nueva requiere revisión.
 */
class AdminCompanyRegisteredNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Company $company) {}

    /**
     * Guarda notificación interna y envía correo con liga al módulo empresas.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo para que el administrador revise la empresa pendiente.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Nueva empresa registrada',
            "La empresa {$this->company->business_name} se registró y está pendiente de aprobación.",
            'Revisar empresas',
            route('admin.companies.index', ['status' => 'pending'])
        );
    }

    /**
     * Datos mínimos para mostrar en el centro de notificaciones admin.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'company_id' => $this->company->id,
            'message' => "Nueva empresa registrada: {$this->company->business_name}.",
            'url' => route('admin.companies.index', ['status' => 'pending']),
        ];
    }
}
