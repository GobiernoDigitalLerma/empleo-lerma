<?php

namespace App\Notifications;

use App\Models\Vacancy;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Pregunta a la empresa si una vacante vencida debe marcarse como cubierta.
 */
class CompanyVacancyExpiredNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Vacancy $vacancy) {}

    /**
     * Notificación por correo y dashboard.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo con liga al listado de vacantes de empresa.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Vacante vencida',
            "La vacante {$this->vacancy->title} venció y no está marcada como cubierta. Revisa si debes cerrarla.",
            'Revisar vacantes',
            route('company.vacancies.index', ['status' => 'expired'])
        );
    }

    /**
     * Datos para dashboard empresa.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vacancy_id' => $this->vacancy->id,
            'message' => "La vacante {$this->vacancy->title} venció. ¿Fue cubierta?",
            'url' => route('company.vacancies.index', ['status' => 'expired']),
        ];
    }
}
