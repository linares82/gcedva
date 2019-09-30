<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailingEmpresas extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $datos;
    public function __construct($datos)
    {
        $this->datos=$datos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        // return $this->view('view.name');
       // dd($this->datos);
        

        return $this->subject($this->datos->asunto)
            ->view('emails.empresaEmailing')
            ->Attach(asset('storage/imagenes/plantillas_correos_empresas/') .'/'. $this->datos->img1);
    }

    
}
