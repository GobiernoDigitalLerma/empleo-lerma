<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\vacante;
use App\RequisitosVacante;
use App\InformacionContacto;

class NewVacancy extends Notification
{
    use Queueable;

    protected $vacancy;

    /**
     * Create a new notification instance.
     */
    public function __construct($vacancy)
    {
        $this->vacancy = $vacancy;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $informacion = $this->vacancy->informacionContacto;

if (!$informacion) {
    $contactoInfo = [
        'Nombre' => 'No disponible',
        'Cargo' => 'No disponible',
        'Teléfono' => 'No disponible',
        'Correo electrónico' => 'No disponible',
        'Días de entrevista' => 'No disponible',
        'Horario de entrevista' => 'No disponible',
        'Medio preferente de contacto' => 'No disponible',
    ];
} else {
    $contactoInfo = [
        'Nombre' => $informacion->nombre_contacto ?? 'No disponible',
        'Cargo' => $informacion->cargo ?? 'No disponible',
        'Teléfono' => $informacion->telefono ?? 'No disponible',
        'Correo electrónico' => $informacion->email ?? 'No disponible',
        'Días de entrevista' => $informacion->dias_entrevista ?? 'No disponible',
        'Horario de entrevista' => isset($informacion->horario_entrevista_inicial, $informacion->horario_entrevista_final)
            ? $informacion->horario_entrevista_inicial . ' a ' . $informacion->horario_entrevista_final
            : 'No disponible',
        'Medio preferente de contacto' => $informacion->medio_preferente_contacto ?? 'No disponible',
    ];
}

return (new MailMessage)
->from('empleo.lerma@gmail.com', 'Empleo Lerma')
->subject('¡Una nueva vacante se ha registrado!')
->greeting('Hola Administrador')
->line('La vacante **' . $this->vacancy->titulo_puesto . '** se ha registrado en la aplicación *Empleo Lerma*.')
->line('**Información de contacto:**')
->line('Nombre: ' . $contactoInfo['Nombre'])
->line('Cargo: ' . $contactoInfo['Cargo'])
->line('Teléfono: ' . $contactoInfo['Teléfono'])
->line('Correo electrónico: ' . $contactoInfo['Correo electrónico'])
->line('Para revisar los datos accede a la aplicación dando click en el siguiente botón.')
->action('Ver vacante', url(route('vacante', ['slug' => $this->vacancy->slug])))
->line('Gracias por usar la aplicación!')
->salutation('¡Saludos!');

    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
          
        ];
    }
}
