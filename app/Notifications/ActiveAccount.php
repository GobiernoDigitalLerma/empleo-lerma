<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActiveAccount extends Notification
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
            ->from('empleo.lerma@gmail.com', 'Empleo Lerma')
            ->subject('Tu cuenta se ha activado!!')
            ->greeting('Hola ' . $notifiable->nombre)
            ->line('Tus datos han sido verificados por Empleo Lerma, ahora puedes publicar vacantes.')
            ->line('Por favor, accede a la aplicación y en la seccion de vacantes podras realizar publicaciones que desees.')
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
