<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; //paginacion
use App\Models\Alumno;
use DB;

class Alumnos extends Component
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
    	$alumnos = Alumno::where('cedula','like', "%$this->search%")
					    	->orWhere('p_nombre','like', "%$this->search%")
					    	->orWhere('s_nombre','like', "%$this->search%")
					    	->orWhere('p_apellido','like', "%$this->search%")
					    	->orWhere('s_apellido','like', "%$this->search%")
					    	->paginate($this->perPage);
        return view('livewire.admin.alumnos',['alumnos' => $alumnos]);
    }
    public function resetSearch()
    {
        $this->search = '';
    }
}
