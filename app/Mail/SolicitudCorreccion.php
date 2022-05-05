<?php

namespace App\Mail;

use App\Models\Solicitud;
use App\Models\SolicitudCorreccion as ModelsSolicitudCorreccion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudCorreccion extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
	public $subject = "Solicitud de Corrección de Calificaciones";
	public $usuario, $solicitud;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $usuario, ModelsSolicitudCorreccion $solicitud)
    {
		$this->usuario = $usuario;
		$this->solicitud = $solicitud;
		$this->subject .= ' - '. $solicitud->Solicitante->nombre.' '. $solicitud->Solicitante->apellido .' - '.Carbon::now()->format('d-m-Y h:i:s A');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('correos.solicitud_correccion');
    }
}
