<?php

namespace App\Notifications\Concerns;

use Illuminate\Notifications\Messages\MailMessage;

/**
 * Centraliza redacción de correos con identidad institucional y liga de revisión.
 */
trait BuildsDashboardMail
{
    /**
     * Construye un correo operativo personalizado para el destinatario.
     */
    protected function dashboardMail(object $notifiable, string $subject, string $line, string $actionText, string $url): MailMessage
    {
        return (new MailMessage)
            ->subject($subject)
            ->greeting("Hola, {$this->recipientName($notifiable)}")
            ->line('Te compartimos una actualización del Sistema Municipal de Empleo Lerma.')
            ->line($line)
            ->action($actionText, $url)
            ->line('También puedes consultar este mensaje en tu panel de notificaciones.')
            ->salutation("Atentamente,\nEmpleo Lerma\nAyuntamiento de Lerma");
    }

    /**
     * Obtiene un nombre seguro para personalizar el saludo del correo.
     */
    private function recipientName(object $notifiable): string
    {
        return trim((string) ($notifiable->name ?? 'usuario de Empleo Lerma')) ?: 'usuario de Empleo Lerma';
    }
}
