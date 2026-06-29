<?php

namespace App\Notifications;

use App\Models\Vacancy;
use App\Notifications\Concerns\BuildsDashboardMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Confirma a la empresa que su vacante fue registrada.
 */
class CompanyVacancyCreatedNotification extends Notification implements ShouldQueue
{
    use BuildsDashboardMail;
    use Queueable;

    public function __construct(private Vacancy $vacancy) {}

    /**
     * Envía correo y guarda copia en base de datos.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Correo de confirmación para la empresa.
     */
    public function toMail(object $notifiable)
    {
        return $this->dashboardMail(
            $notifiable,
            'Vacante creada',
            "Registramos la vacante {$this->vacancy->title}. Si fue enviada a revisión, administración la validará antes de publicarla.",
            'Ver mis vacantes',
            route('company.vacancies.index')
        );
    }

    /**
     * Datos de la notificación en dashboard empresa.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vacancy_id' => $this->vacancy->id,
            'message' => "Vacante creada: {$this->vacancy->title}.",
            'url' => route('company.vacancies.index'),
        ];
    }
}
