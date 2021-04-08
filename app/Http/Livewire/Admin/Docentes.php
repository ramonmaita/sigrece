<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; //paginacion
use App\Models\Docente;
use Illuminate\Support\Facades\DB;

class Docentes extends Component
{
	use WithPagination; //paginacion

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $perPage = 25;
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 25]
    ];

    protected $rules = [
        'cedula' => 'required|numeric|digits_between:6,8',
        'nombres' => 'required|string|min:2|max:40',
        'apellidos' => 'required|string|min:2|max:40',
        'fechan' => 'required|date',
        'nacionalidad' => 'required',
        'sexo' => 'required',
        'estatus' => 'required'
    ];

    public $modo = 'crear';
    public $titulo,$docente_id,$cedula,$nombres,$apellidos,$nacionalidad,$sexo,$fechan,$estatus;

    public function mount()
    {
		$this->nacionalidad = 'V';
		$this->sexo = 'FEMENINO';
		$this->estatus = 'ACTIVO';
    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
    	$docentes = Docente::where('cedula','like', "%$this->search%")
					    	->orWhere('nombres','like', "%$this->search%")
					    	->orWhere('apellidos','like', "%$this->search%")
					    	->orWhere('nacionalidad','like', "%$this->search%")
					    	->orWhere('fechan','like', "%$this->search%")
					    	->orWhere('sexo','like', "%$this->search%")
					    	->paginate($this->perPage);
        return view('livewire.admin.docentes',['docentes' => $docentes]);
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function setTitulo($titulo,$modo)
    {
        $this->titulo = $titulo;
        $this->modo = $modo;
        if($modo == 'crear'){
            $this->reset(['docente_id','cedula','nombres','apellidos', 'nacionalidad','sexo','fechan', 'estatus']);
        }
    }

    public function store()
    {
    	$this->validate();
    	try {
    		DB::beginTransaction();
    		Docente::create([
    			'cedula' => $this->cedula ,
    			'nombres' => $this->nombres ,
    			'apellidos' => $this->apellidos ,
    			'nacionalidad' => $this->nacionalidad ,
    			'sexo' => $this->sexo ,
    			'fechan' => $this->fechan ,
    			'estatus' => $this->estatus
    		]);
    		DB::commit();
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'Docente creado correctamente.');
    	} catch (\Exception $e) {
    		DB::rollBack();
    		 session()->flash('error',$e->getMessage());
    	}
    }

    public function edit($id)
    {
    	$this->modo = 'editar';
    	$docente = Docente::find($id);
    	$this->docente_id = $id;
    	$this->cedula = $docente->cedula;
    	$this->nombres = $docente->nombres;
    	$this->apellidos = $docente->apellidos;
    	$this->sexo = $docente->sexo;
    	$this->fechan = $docente->fechan;
    	$this->nacionalidad = $docente->nacionalidad;
    	$this->estatus = $docente->estatus;
    }

    public function update()
    {
    	$this->validate();
    	try {
    		DB::beginTransaction();
    		Docente::find($this->docente_id)->update([
    			'cedula' => $this->cedula ,
    			'nombres' => $this->nombres ,
    			'apellidos' => $this->apellidos ,
    			'nacionalidad' => $this->nacionalidad ,
    			'sexo' => $this->sexo ,
    			'fechan' => $this->fechan ,
    			'estatus' => $this->estatus
    		]);
    		DB::commit();
            $this->reset(['docente_id','cedula','nombres','apellidos', 'nacionalidad','sexo','fechan', 'estatus']);
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'Docente actualizado correctamente.');
    	} catch (\Exception $e) {
    		DB::rollBack();
    		 session()->flash('error',$e->getMessage());
    	}
    }
}
