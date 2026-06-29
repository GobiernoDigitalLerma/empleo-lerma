<?php

namespace App\Notifications;

use App\Models\Vacancy;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Avisa a la empresa cuando administración marca una vacante como cubierta.
 */
class CompanyVacancyCoveredNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Vacancy $vacancy) {}

    /**
     * Envía correo y guarda registro legible en el dashboard de empresa.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo con liga al listado de vacantes de la empresa.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Vacante marcada como cubierta',
            "La vacante {$this->vacancy->title} fue marcada como cubierta y dejó de mostrarse en el sitio público.",
            'Revisar vacantes',
            route('company.vacancies.index', ['status' => 'covered'])
        );
    }

    /**
     * Payload para la bandeja de notificaciones de empresa.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vacancy_id' => $this->vacancy->id,
            'message' => "La vacante {$this->vacancy->title} fue marcada como cubierta.",
            'url' => route('company.vacancies.index', ['status' => 'covered']),
        ];
    }
}
