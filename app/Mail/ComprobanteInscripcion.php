<?php

namespace App\Mail;

use App\Models\Alumno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComprobanteInscripcion extends Mailable
{
    use Queueable, SerializesModels;

	public $subject = "Comprobante de Inscripción";
	public $alumno, $comprobante, $datos_estudiante;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Alumno $alumno, $comprobante)
    {
        $this->alumno = $alumno;
		$this->datos_estudiante = $alumno->cedula.' '.$alumno->nombres.' '.$alumno->apellidos;
		$this->comprobante = $comprobante;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('correos.comprobante')
        ->attachData($this->comprobante, "COMPROBANTE DE INSCRIPCION DE $this->datos_estudiante.pdf", ['mime' =>
  		 'application/pdf']);
    }
}
