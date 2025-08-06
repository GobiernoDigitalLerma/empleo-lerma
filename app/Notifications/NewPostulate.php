<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPostulate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vacancy)
    {
        $this->vacancy = $vacancy;
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
        if ($notifiable->tipo_user == "company") {
            $title = 'Se ha postulado una persona!!';
            $msj = 'Se postulo una persona';
        } else {
            $title = 'Te haz postulado a una vacante!!';
            $msj = 'Se registro tu postulación';
        }
        return (new MailMessage)
            ->from('empleo.lerma@gmail.com', 'Empleo Lerma')
            ->subject($title)
            ->greeting('Hola ' . $notifiable->nombre)
            ->line($msj . ' a la vacante ' . $this->vacancy->titulo_puesto . ' de Empleo Lerma.')
            ->line('Para revisar los datos accede a la aplicación, da clic en el siguiente enlace.')
            ->action('Ver vacante', url(route('vacante', ['slug' => $this->vacancy->slug])))
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
