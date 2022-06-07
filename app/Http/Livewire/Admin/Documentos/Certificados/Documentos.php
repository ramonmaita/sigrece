<?php

namespace App\Http\Livewire\Admin\Documentos\Certificados;

use App\Models\Graduando;
use Livewire\Component;

class Documentos extends Component
{

	protected $listeners = ['setGraduandoId'];

	public $graduando_id, $graduando = [];

	public function mount(Graduando $graduando)
	{
		$this->titulos = Graduando::where('cedula',$graduando->cedula)->get();
		$this->graduando_id = $this->titulos->first()->id;
		$this->emit('setGraduandoId',$this->titulos->first()->id);
	}

    public function render()
    {
        return view('livewire.admin.documentos.certificados.documentos');
    }

	public function setGraduandoId($id)
	{
		$this->graduando_id = $id;
		$this->graduando = Graduando::find($id);
	}
}
