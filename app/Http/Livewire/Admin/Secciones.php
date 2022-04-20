<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; //paginacion
use App\Models\Seccion;
use App\Models\Pnf;
use App\Models\Nucleo;
use App\Models\Trayecto;
use App\Models\Periodo;
use Illuminate\Support\Facades\DB;

class Secciones extends Component
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
    	'nucleo_id' => 'required',
    	'pnf_id' => 'required',
    	'plan_id' => 'required',
    	'periodo_id' => 'required',
    	'trayecto_id' => 'required',
        'nombre' => 'required|string|min:8|max:40',
        'cupos' => 'required|numeric|digits_between:2,3|min:15|max:100',
        'turno' => 'required',
        'observacion' => 'required|string|min:2|max:150',
    ];
    public $modo = 'crear';

    public $titulo, $nucleo_id, $pnf_id, $seccion_id, $trayecto_id, $periodo_id, $plan_id, $nombre, $turno, $cupos, $observacion, $estatus;

    public $pnfs = [];
    public $planes = [];

    // public function mount()
    // {
    // 	$this->trayecto_id = 1;
    // 	$this->turno = 'MAÑANA';
    // 	$this->turno = 'MAÑANA';
    // }

    public function render()
    {
    	if(!empty($this->nucleo_id) && $this->nucleo_id != ''&& $this->nucleo_id != null) {
    		$p = Nucleo::find($this->nucleo_id);

			if(empty($this->pnf_id)){$this->pnf_id = $p->Pnfs->first()->id;}
			// if(empty($this->pnf_id)){$this->pnf_id = $p->id;}

    		if ($p) {
    			$p = $p->Pnfs;
    			$fp = $p->first();
    			$pl = $fp->Planes;
    			$this->planes = $pl;
    		}else{
    			$p = [];
    		}

            $this->pnfs = $p;
            if(!empty($this->pnf_id) && $this->pnf_id != ''&& $this->pnf_id != null) {
	    		$pl = Pnf::find($this->pnf_id);
	    		if ($pl) {
	    			$pl = $pl->Planes;
	    		}else{
	    			$pl = [];
	    		}
	    		$this->planes = $pl;
                if(empty($this->plan_id)){$this->plan_id = $pl->first()->id;}
	    	}

        }else{
        	$this->pnfs = [];
        	$this->planes = [];
        }

        $periodo_activo = Periodo::where('estatus',0)->first();
        if ($periodo_activo) {
            $this->periodo_id = $periodo_activo->id;
        }
        if (empty($this->periodo_id)) {
        	session()->flash('error', 'No hay periodo activo.');
        }
    	$nucleos = Nucleo::where('estatus','ACTIVO')->get();
    	// $pnfs = Pnf::all();
    	$trayectos = Trayecto::all();
    	$secciones = Seccion::where('nombre','like', "%$this->search%")
					    	->orWhere('turno','like', "%$this->search%")
					    	->orWhere('cupos','like', "%$this->search%")
					    	->orWhere('observacion','like', "%$this->search%")
					    	->paginate($this->perPage);
        return view('livewire.admin.secciones',['secciones' => $secciones,'nucleos' => $nucleos, 'trayectos' => $trayectos]);
        // return view('livewire.admin.secciones',['secciones' => $secciones,'nucleos' => $nucleos, 'pnfs' => $pnfs, 'trayectos' => $trayectos]);
    }

    // public function updatedSelectedState($nucleo_id)
    // {
    //     if (!is_null($nucleo_id)) {
    //     	$nucleo = Nucleo::find($nucleo_id);
    //     	foreach ($nucleo->Pnfs()->pluck('pnf_id') as $pnf_id) {
	   //  		$this->citie[$pnf_id] = $pnf_id;
	   //  	}
    //         // $this->cities = Nucleo::find($nucleo_id)->Pnfs()->toArray();
    //     }
    // }

    public function resetSearch()
    {
        $this->search = '';
    }
    public function resetInputs()
    {
        $this->reset([ 'nucleo_id', 'pnf_id', 'seccion_id', 'trayecto_id', 'periodo_id', 'plan_id', 'nombre', 'turno', 'cupos', 'observacion', 'estatus']);
    }

    public function setTitulo($titulo,$modo)
    {
        $this->titulo = $titulo;
        $this->modo = $modo;
        if($modo == 'crear'){

            $this->resetInputs();
    		$this->turno = 'MAÑANA';
    		$this->estatus = 'ACTIVA';
    		$this->trayecto_id = Trayecto::first()->id;
        }
    }

    public function store()
    {
    	$this->validate();
    	try {
    		DB::beginTransaction();
    		Seccion::create([
    			'nucleo_id' => $this->nucleo_id ,
    			'pnf_id' => $this->pnf_id ,
    			'trayecto_id' => $this->trayecto_id ,
    			'periodo_id' => $this->periodo_id ,
    			'plan_id' => $this->plan_id ,
    			'nombre' => $this->nombre ,
    			'cupos' => $this->cupos ,
    			'turno' => $this->turno ,
    			'observacion' => $this->observacion ,
    			'estatus' => $this->estatus ,
    		]);
    		DB::commit();
    		$this->resetInputs();
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'Seccion creada correctamente.');
    	} catch (\Exception $e) {
    		DB::rollBack();
    		 session()->flash('error',$e->getMessage());
    	}
    }

    public function edit($id)
    {
    	$this->modo = 'editar';
    	$seccion = Seccion::find($id);
        $this->seccion_id = $id;
        $this->pnf_id =  $seccion->pnf_id;
    	$this->nucleo_id = $seccion->nucleo_id;
        $this->trayecto_id = $seccion->trayecto_id;
        $this->periodo_id = $seccion->periodo_id;
    	$this->plan_id = $seccion->plan_id;
    	$this->nombre = $seccion->nombre;
        $this->cupos = $seccion->cupos;
    	$this->turno = $seccion->turno;
    	$this->observacion = $seccion->observacion;
		$this->estatus = $seccion->estatus;

    }

    public function update()
    {
    	$this->validate(
			[
				'nucleo_id' => 'required',
				'pnf_id' => 'required',
				'plan_id' => 'required',
				'periodo_id' => 'required',
				'trayecto_id' => 'required',
				'nombre' => 'required|string|min:8|max:40',
				'cupos' => 'required|numeric|digits_between:1,3|min:0|max:100',
				'turno' => 'required',
				'observacion' => 'required|string|min:2|max:150',
			]
		);
    	try {
    		DB::beginTransaction();

    		Seccion::find($this->seccion_id)->update([
    			'nucleo_id' => $this->nucleo_id ,
    			'pnf_id' => $this->pnf_id ,
    			'trayecto_id' => $this->trayecto_id ,
    			'periodo_id' => $this->periodo_id ,
    			'plan_id' => $this->plan_id ,
    			'nombre' => $this->nombre ,
    			'cupos' => $this->cupos ,
    			// 'cupos' => $this->cupos ,
    			'turno' => $this->turno ,
    			'observacion' => $this->observacion ,
				'estatus' => $this->estatus ,
    		]);
    		DB::commit();
            $this->resetInputs();
    		$this->emit('cerrar_modal'); // Close model to using to jquery
    		session()->flash('mensaje', 'Seccion actualizada correctamente.');
    	} catch (\Exception $e) {
    		DB::rollBack();
    		session()->flash('error',$e->getMessage());
    	}
    }
}
