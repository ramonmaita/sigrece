<?php

namespace App\Http\Livewire\Admin\Graduaciones;

use App\Models\Graduando;
use Livewire\Component;

class Show extends Component
{
	public $titulos = [], $datos_graduando = [],$select_titulo;

	public function mount(Graduando $graduando)
	{
		$this->titulos = Graduando::where('cedula',$graduando->cedula)->get();
		$this->datos_graduando = $this->titulos->first();
		// $this->emit('setGraduandoId',$this->titulos->first()->id);
	}

	public function updated($atributo)
	{
		if($atributo == 'select_titulo'){
			$this->datos_graduando = Graduando::find($this->select_titulo);
			$this->emit('setGraduandoId',$this->select_titulo);
		}
	}

    public function render()
    {
        return view('livewire.admin.graduaciones.show');
    }
}
