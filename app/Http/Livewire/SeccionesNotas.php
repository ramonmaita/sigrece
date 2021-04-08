<?php

namespace App\Http\Livewire;

use App\Models\HistoricoNota;
use Livewire\Component;
use Livewire\WithPagination; //paginacion

class SeccionesNotas extends Component
{
	use WithPagination; //paginacion

	protected $paginationTheme = 'bootstrap';
    public $search;
    public $perPage = 10;
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];


    public function render()
    {
		$periodo = 2020;
		$secciones = HistoricoNota::join('pnfs', 'historico_notas.especialidad', '=','pnfs.codigo')
		// ->where('nombre','like', "%$this->search%")
		->where('seccion','like', "%$this->search%")
		->where('periodo',$periodo)
		->where('estatus','1')
		->groupBy('seccion')
		->paginate($this->perPage);
        return view('livewire.secciones-notas',['secciones' => $secciones]);
    }
}
