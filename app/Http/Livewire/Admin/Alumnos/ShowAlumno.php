<?php

namespace App\Http\Livewire\Admin\Alumnos;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowAlumno extends Component
{
	protected $listeners = ['recargar_iframes' => 'recargar_iframes'];
	public $alumno,$trayectos=[],$titulos = [];

	public function mount($alumno,$trayectos)
	{
		$this->alumno = $alumno;
		$this->trayectos = $trayectos;
		$this->titulos = DB::table('graduandos')->where('cedula',$alumno->cedula)
						->join('pnfs' ,'graduandos.pnf','=','pnfs.codigo')
						->select('graduandos.*','pnfs.*')
						->orderBy('graduandos.pnf')
						->orderBy('graduandos.titulo')
						->get();
	}
    public function render()
    {
        return view('livewire.admin.alumnos.show-alumno');
    }

	public function recargar_iframes()
	{
		$this->emit('recarg_if');
	}
}
