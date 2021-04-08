<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroUsuario extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

	public $subject = "Registro de Usuario";
	public $usuario, $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $usuario, $password)
    {
        $this->usuario = $usuario;
		$this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('correos.registro_usuario');
    }
}
