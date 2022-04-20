<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Alertas extends Component
{
	protected $listeners = ['mensajes' => 'men','recargar_alertas' => '$refresh'];

    public function render()
    {
        return view('livewire.admin.alertas');
    }

	public function men($tipo,$mensaje)
    {
        session()->flash($tipo, $mensaje);
    }
}
