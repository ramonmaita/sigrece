<?php

namespace App\Http\Livewire\Docente;

use Livewire\Component;

class Alertas extends Component
{
	protected $listeners = ['mensajes' => 'men','recargar_alertas' => '$refresh'];

    public function render()
    {
        return view('livewire.docente.alertas');
    }
	public function men($tipo,$mensaje)
    {
        session()->flash($tipo, $mensaje);
    }
}
