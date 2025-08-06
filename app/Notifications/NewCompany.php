<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCompany extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('empleo.lerma@gmail.com','Empleo Lerma')
                    ->subject('Una nueva compañia se ha registrado!!')
                    ->greeting('Hola Administrador')
                    ->line('Una nueva compañia se ha registrado en la aplicación Empleo Lerma.')
                    ->line('Por favor, accede a la aplicación para dar visto bueno de la empresa, necesitas activar la compañia para que pueda publicar vacantes.')
                    ->action('Acceder a Empleo Lerma', url('/'))
                    ->line('Gracias por usar la aplicación!')
                    ->salutation('¡Saludos!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
