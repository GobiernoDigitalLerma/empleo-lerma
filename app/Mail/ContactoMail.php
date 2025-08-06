<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Una empresa te quiere contactar - Empleo Lerma";
    public $mensaje;
    public $datoscontacto;
    public $datosciudadano;
    public $datosvacante;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensaje, $datoscontacto, $datosciudadano, $datosvacante)
    {
        $this->mensaje = $mensaje;
        $this->datoscontacto = $datoscontacto;
        $this->datosciudadano = $datosciudadano;
        $this->datosvacante = $datosvacante;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('empleo.lerma@gmail.com', 'Empleo Lerma')
                    ->view('email/EmailContacto');
    }
}  
