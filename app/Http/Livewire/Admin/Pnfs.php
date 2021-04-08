<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; //paginacion
use App\Models\Pnf;

use DB;

class Pnfs extends Component
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
        'codigo' => 'required|numeric|digits_between:2,4',
        'nombre' => 'required|string|min:2|max:40',
        'acronimo' => 'required|string|min:3|max:40',
        'observacion' => 'required|string|min:10|max:150',
    ];
    public $modo = 'crear';

    public $titulo, $pnf_id, $acronimo, $nombre, $codigo, $observacion;

    public function render()
    {
    	$pnfs = Pnf::where('nombre','like', "%$this->search%")
					    	->orWhere('acronimo','like', "%$this->search%")
					    	->orWhere('codigo','like', "%$this->search%")
					    	->orWhere('observacion','like', "%$this->search%")
					    	->paginate($this->perPage);
        return view('livewire.admin.pnfs',['pnfs' => $pnfs]);
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
            $this->reset(['pnf_id','codigo','nombre','acronimo','observacion']);
        }
    }

    public function store()
    {
    	$this->validate();
    	try {
    		DB::beginTransaction();
    		Pnf::create([
    			'codigo' => $this->codigo ,
    			'nombre' => $this->nombre ,
    			'acronimo' => $this->acronimo ,
    			'observacion' => $this->observacion ,
    		]);
    		DB::commit();
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'PNF creado correctamente.');
    	} catch (Exception $e) {
    		DB::rollBack();
    		 session()->flash('error',$e->getMessage());
    	}
    }

    public function edit($id)
    {
    	$this->modo = 'editar';
    	$pnf = Pnf::find($id);
    	$this->pnf_id = $id;
    	$this->codigo = $pnf->codigo;
    	$this->nombre = $pnf->nombre;
    	$this->acronimo = $pnf->acronimo;
    	$this->observacion = $pnf->observacion;
    	
    }

    public function update()
    {
    	$this->validate();
    	try {
    		DB::beginTransaction();
    		
    		Pnf::find($this->pnf_id)->update([
    			'codigo' => $this->codigo ,
    			'nombre' => $this->nombre ,
    			'acronimo' => $this->acronimo ,
    			'observacion' => $this->observacion ,
    		]);
    		DB::commit();
            $this->reset(['pnf_id','codigo','nombre','acronimo','observacion']);
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'PNF actualizado correctamente.');
    	} catch (Exception $e) {
    		DB::rollBack();
    		session()->flash('error',$e->getMessage());
    	}
    }
}
