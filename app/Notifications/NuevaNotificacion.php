<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NuevaNotificacion extends Notification
{
    use Queueable;

    protected $empresa;
    protected $correoDestino; 
    
    public function __construct($empresa, $correoDestino)
    {
        $this->empresa = $empresa;
        $this->correoDestino = $correoDestino; 
    }

   
    public function via($notifiable)
    {
        return ['mail'];
    }

  
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('empleo.lerma@gmail.com', 'Empleo Lerma')
                    ->subject('Una empresa ha registrado sus datos: ' . $this->empresa->nombre_RS)
                    ->greeting('Hola Empleo Lerma!!!')
                    ->line('Se ha registrado una nueva empresa en la aplicación Empleo Lerma.')
                    ->line('**Nombre o Razón Social:** ' . $this->empresa->nombre_RS)
                    ->line('**RFC:** ' . $this->empresa->RFC)
                    ->line('**Teléfono:** ' . $this->empresa->tel1)
                    ->line('**Email:** ' . $this->empresa->email)
                    ->line('**Actividad Económica:** ' . $this->empresa->actividad_economica)
                    ->action('Ver detalles en Empleo Lerma', url('/'))
                    ->line('Por favor, revisa y activa la empresa si es necesario.')
                    ->salutation('Saludos');
    }
}
