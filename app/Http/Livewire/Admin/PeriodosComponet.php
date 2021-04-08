<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; //paginacion
use App\Models\Periodo;
use DB;

class PeriodosComponet extends Component
{
    use WithPagination; //paginacion

    protected $paginationTheme = 'bootstrap';
    public $search,$nombre,$observacion,$periodo_id;
    public $estatus = 0;
    public $modo = 'crear';
    protected $queryString = [
        'search' => ['except' => ''],
    ];
    protected $rules = [
        'nombre' => 'required|string|min:4|max:25',
        'observacion' => 'required|string|min:2|max:180',
        'estatus' => 'required'
    ];

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $periodos = Periodo::where('nombre','like', "%$this->search%")
        ->orWhere('observacion','like', "%$this->search%")
        ->paginate(15);
        return view('livewire.admin.periodos-componet',['periodos' => $periodos]);
    }

    public function store()
    {
        $this->validate();
        if ($this->estatus == 0 ) {
            $periodos_activos = Periodo::where('estatus',0)->update(['estatus' => 1]);
        }
		$nro = Periodo::max('nro')+1;
        $periodo = Periodo::create([
			'nro' => $nro,
            'nombre' => $this->nombre,
            'observacion' => $this->observacion,
            'estatus' => $this->estatus
        ]);
        $this->emit('cerrar_modal'); // Close model to using to jquery
        session()->flash('mensaje', 'Periodo creado correctamente.');
    }

    public function edit($id)
    {
        $this->modo = 'editar';
        $periodo = Periodo::find($id);
        $this->periodo_id = $id;
        $this->nombre = $periodo->nombre;
        $this->observacion = $periodo->observacion;
        $this->estatus = $periodo->estatus;

    }

    public function setModo($modo)
    {
        $this->modo = $modo;
        if($modo == 'crear'){
            $this->reset(['periodo_id','nombre','observacion','estatus']);
        }
    }

    public function cancelar()
    {
        $this->modo = 'crear';
        $this->reset(['periodo_id','nombre','observacion','estatus']);
    }

    public function update()
    {
        if ($this->estatus == 0 ) {
            $periodos_activos = Periodo::where('estatus',0)->update(['estatus' => 1]);
        }
        Periodo::find($this->periodo_id)->update([
            'nombre' => $this->nombre,
            'observacion' => $this->observacion,
            'estatus' => $this->estatus
        ]);

        $this->cancelar();
        $this->emit('cerrar_modal'); // Close model to using to jquery
        session()->flash('mensaje', 'Periodo actualizado correctamente.');
    }
}
