<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; //paginacion
use App\Models\Trayecto;

use DB;

class Trayectos extends Component
{
	use WithPagination; //paginacion

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $perPage = 10;
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

    protected $rules = [
        'nombre' => 'required|string|min:1|max:40',
        'observacion' => 'required|string|min:2|max:40',
    ];
    public $modo = 'crear';

    public $trayecto_id, $nombre, $observacion,$titulo;


    public function render()
    {
    	$trayectos = Trayecto::where('nombre','like', "%$this->search%")
					    	->orWhere('observacion','like', "%$this->search%")
					    	->paginate($this->perPage);
        return view('livewire.admin.trayectos',['trayectos' => $trayectos]);
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
            $this->reset(['trayecto_id','nombre','observacion']);
        }
    }

    public function store()
    {
    	$this->validate();
    	try {
    		DB::beginTransaction();
    		Trayecto::create([
    			'nombre' => $this->nombre ,
    			'observacion' => $this->observacion ,
    		]);
    		DB::commit();
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'Trayecto creado correctamente.');
    	} catch (Exception $e) {
    		DB::rollBack();
    		 session()->flash('error',$e->getMessage());
    	}
    }

    public function edit($id)
    {
    	$this->modo = 'editar';
    	$trayecto = Trayecto::find($id);
    	$this->trayecto_id = $id;
    	$this->nombre = $trayecto->nombre;
    	$this->observacion = $trayecto->observacion;
    	
    }

    public function update()
    {
    	$this->validate();
    	try {
    		DB::beginTransaction();
    		
    		Trayecto::find($this->trayecto_id)->update([
    			'nombre' => $this->nombre ,
    			'observacion' => $this->observacion ,
    		]);
    		DB::commit();
            $this->reset(['trayecto_id','nombre','observacion']);
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'Trayecto actualizado correctamente.');
    	} catch (Exception $e) {
    		DB::rollBack();
    		session()->flash('error',$e->getMessage());
    	}
    }


}
