<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; //paginacion
use App\Models\Pnf;
use App\Models\PnfNucleo;
use App\Models\Nucleo;
use DB;

class Nucleos extends Component
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
        'nucleo' => 'required|string|min:3|max:40',
        'locacion' => 'required|string|min:3|max:150',
        'estatus' => 'required',
    ];
    public $modo = 'crear';

    public $titulo, $nucleo_id, $nucleo, $locacion, $estatus;
    public $pnfsxnucleo = [];

    public function render()
    {
    	$pnfs = Pnf::all();
    	$nucleos = Nucleo::where('nucleo','like', "%$this->search%")
					    	->orWhere('locacion','like', "%$this->search%")
					    	->paginate($this->perPage);
        return view('livewire.admin.nucleos',['nucleos' => $nucleos,'pnfs' => $pnfs]);
    }

    public function resetSearch()
    {
        $this->search = '';
    }
    public function resetInputs()
    {
        $this->reset(['nucleo_id','estatus','locacion','nucleo','pnfsxnucleo']);
    }

    public function setTitulo($titulo,$modo)
    {
        $this->titulo = $titulo;
        $this->modo = $modo;
        if($modo == 'crear'){
            $this->resetInputs();
        }
    }

    public function store()
    {
    	$this->validate();
    	try {
    		DB::beginTransaction();
    		$nucleo = Nucleo::create([
    			'nucleo' => $this->nucleo ,
    			'locacion' => $this->locacion ,
    			'estatus' => $this->estatus ,
    		]);
    		if (!empty($this->pnfsxnucleo)) {
    			$nucleo->Pnfs()->sync($this->pnfsxnucleo);
    		}
    		DB::commit();
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'Nucleo creado correctamente.');
    	} catch (Exception $e) {
    		DB::rollBack();
    		 session()->flash('error',$e->getMessage());
    	}
    }

    public function edit($id)
    {
    	$this->resetInputs();
    	$this->modo = 'editar';
    	$nucleo = Nucleo::find($id);
    	$this->nucleo_id = $id;
    	$this->nucleo = $nucleo->nucleo;
    	$this->locacion = $nucleo->locacion;
    	$this->estatus = $nucleo->estatus;
    	// $this->pnfsxnucleo = $nucleo->Pnfs()->pluck('pnf_id');
    	foreach ($nucleo->Pnfs()->pluck('pnf_id') as $pnf_id) {
    		$this->pnfsxnucleo[$pnf_id] = $pnf_id;
    	}
    	
    }

    public function update()
    {
    	$this->validate();
    	try {
    		DB::beginTransaction();
    		
    		$nucleo = Nucleo::find($this->nucleo_id)->update([
    			'nucleo' => $this->nucleo ,
    			'locacion' => $this->locacion ,
    			'estatus' => $this->estatus ,
    		]);
    		$nucleo = Nucleo::find($this->nucleo_id);
    		// if (!empty($this->pnfsxnucleo)) {
    			$p = array_diff($this->pnfsxnucleo, array("",0,null));
				$nucleo->Pnfs()->sync($p);
			// }else{
    			// $nucleo->Pnfs()->detach($this->pnfsxnucleo);
			// }
    		DB::commit();
            $this->resetInputs();
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'Nucleo actualizado correctamente.');
    	} catch (Exception $e) {
    		DB::rollBack();
    		session()->flash('error',$e->getMessage());
    	}
    }
}
