<?php

namespace App\Http\Livewire\Admin\Estadisticas\AprobadosReprobados;

use App\Models\HistoricoNota;
use App\Models\Periodo;
use App\Models\Pnf;
use App\Models\Trayecto;
use Livewire\Component;

class Index extends Component
{
	public $periodo_id, $pnf_id, $tipo, $trayecto_id, $plan_id;
	public $periodos = [], $pnfs = [], $trayectos = [], $datos = [], $unidades_curriculares, $planes = [];
	public $pnf, $trayecto;
	public function mount()
	{
		$this->periodos = Periodo::all();
		$this->pnfs = Pnf::where('codigo','>=',40)->get();
		$this->trayectos = Trayecto::all();
	}

    public function render()
    {
		if(!empty($this->pnf_id)){
			$this->planes = Pnf::find($this->pnf_id)->Planes;
		}
        return view('livewire.admin.estadisticas.aprobados-reprobados.index');
    }

	public function estadisticas()
	{
		$this->reset(['datos','unidades_curriculares']);
		$periodo = Periodo::find($this->periodo_id);
		$this->pnf = Pnf::find($this->pnf_id);
		$this->trayecto = Trayecto::find($this->trayecto_id);
		$unidades_curriculares = $this->trayecto->Asignaturas->where('plan_id',$this->plan_id);
		$this->datos = HistoricoNota::where('periodo',$periodo->nombre)
		->whereIn('estatus',[0,1])
		->whereIn('cod_asignatura',$unidades_curriculares->pluck('codigo'))
		->where('especialidad',$this->pnf->codigo)
		->groupBy('cedula_estudiante','cod_asignatura')
		->selectRaw('*, sum(nota) as nota_sumada')
		->orderBy('cod_asignatura')
		->get();
		$this->unidades_curriculares = $unidades_curriculares;
	}
}
