<?php

namespace App\Http\Livewire\Admin\Alumnos;

use Livewire\Component;

class ShowAlumno extends Component
{
	public $alumno,$trayectos=[];

	public function mount($alumno,$trayectos)
	{
		$this->alumno = $alumno;
		$this->trayectos = $trayectos;
	}
    public function render()
    {
        return view('livewire.admin.alumnos.show-alumno');
    }
}
