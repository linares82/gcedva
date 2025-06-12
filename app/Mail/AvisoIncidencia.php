<?php

namespace App\Mail;

use App\IncidenciasCalificacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AvisoIncidencia extends Mailable
{
    use Queueable, SerializesModels;

    public $incidenciaCalificacion;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(IncidenciasCalificacion $incidenciaCalificacion)
    {
        $this->incidenciaCalificacion = $incidenciaCalificacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.incidencia_calificacion');
    }
}
