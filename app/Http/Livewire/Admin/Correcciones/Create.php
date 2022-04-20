<?php

namespace App\Http\Livewire\Admin\Correcciones;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\DesAsignatura;
use App\Models\Docente;
use App\Models\HistoricoNota;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component
{
	public $estudiante,$tipo_solicitud,$periodos,$periodo_id,$ucs,$cod_anual,$asignatura,$cohortes,$unidades,$cohortes_actualizar = [], $nota_cohorte = [];
	public $estudiante_actual,$tipo_solicitud_actual,$periodo_id_actual,$cod_anual_actual,$cohortes_actual;
	public $docente_id = [], $seccion = [];

    public function render()
    {
		$docentes = Docente::all();
		if (!empty($this->tipo_solicitud)) {
			if($this->tipo_solicitud_actual != $this->tipo_solicitud){
				$this->reset(['estudiante','periodos','periodo_id','ucs','cod_anual','asignatura','cohortes','unidades','estudiante_actual']);
				$this->emit('reset-select');
			}
			$this->tipo_solicitud_actual = $this->tipo_solicitud;
			if (!empty($this->estudiante)) {
				if($this->estudiante_actual != $this->estudiante){
					$this->reset(['periodos','periodo_id','ucs','cod_anual','asignatura','cohortes','unidades','estudiante_actual']);
				}
				$this->estudiante_actual = $this->estudiante;
				// TODO: CORRECCION DE NOTAS
				if ($this->tipo_solicitud ==  'CORRECCION DE CALIFICACION') {
					$alumno = Alumno::find($this->estudiante);
					$this->periodos = $alumno->Periodos;
					if (!empty($this->periodo_id)) {
						if($this->periodo_id_actual != $this->periodo_id){
							$this->reset(['ucs','cod_anual','asignatura','cohortes','unidades']);
						}
						$this->periodo_id_actual = $this->periodo_id;
						$p = HistoricoNota::find($this->periodo_id);
						$this->ucs = HistoricoNota::where('cedula_estudiante',$p->cedula_estudiante)
										->where('periodo',$p->periodo)
										->where('nro_periodo',$p->nro_periodo)
										->where('estatus',0)
										->groupBy('cod_asignatura')
										->orderBy('cod_desasignatura')
										->get();

						if (!empty($this->cod_anual)) {
							if($this->cod_anual_actual != $this->cod_anual){
								$this->reset(['asignatura','cohortes','unidades']);
							}
							$this->cod_anual_actual = $this->cod_anual;

							$this->asignatura = Asignatura::with('desasignaturas')->where('codigo',$this->cod_anual)->first();
							if (!empty($this->cohortes)) {
								$this->unidades = HistoricoNota::where('cedula_estudiante',$p->cedula_estudiante)
										->where('periodo',$p->periodo)
										->where('nro_periodo',$p->nro_periodo)
										->whereIn('cod_desasignatura',$this->cohortes)
										->where('estatus',0)
										->orderBy('cod_desasignatura')
										->get();

								if (empty($this->cohortes_actualizar)) {
									$this->reset('nota_cohorte');
								}
							}
						}
					}else{
						$this->ucs = [];
					}
				}

				// TODO: AGREGAR UC
				if ($this->tipo_solicitud ==  'ADICIONAR UC') {
					$alumno = Alumno::find($this->estudiante);
					$this->periodos = HistoricoNota::where('especialidad',$alumno->Pnf->codigo)->groupBy('periodo')->orderBy('nro_periodo')->get();
					if (!empty($this->periodo_id)) {
						if($this->periodo_id_actual != $this->periodo_id){
							$this->reset(['ucs','cod_anual','asignatura','cohortes','unidades']);
						}
						$this->periodo_id_actual = $this->periodo_id;
						if (!empty($this->cod_anual)) {
							if($this->cod_anual_actual != $this->cod_anual){
								$this->reset(['asignatura','cohortes','unidades','nota_cohorte','docente_id','seccion']);
							}
							$this->cod_anual_actual = $this->cod_anual;
							$this->asignatura = Asignatura::find($this->cod_anual);
							if (!empty($this->cohortes)) {
								if($this->cohortes_actual != $this->cohortes){
									$this->reset(['nota_cohorte','docente_id','seccion']);
								}
								$this->cohortes_actual = $this->cohortes;

								$this->unidades = $this->asignatura->DesAsignaturas->whereIn('id',$this->cohortes);

							// 	if (empty($this->cohortes_actualizar)) {
							// 		$this->reset('nota_cohorte');
							// 	}
							}
						}
					}
				}
			}else{
				$alumno = [];
			}
		}else{
			$alumno = [];
		}

        return view('livewire.admin.correcciones.create',['alumno' => $alumno,'docentes' => $docentes]);
    }

	public function store()
	{
		// dd($this->nota_cohorte);
		$this->validate([
			'periodo_id' => 'required',
			'cod_anual' => 'required',
			'cohortes' => 'required|array|min:1',
			'seccion' => 'required|array|min:'.count($this->cohortes),
			'seccion.*' => 'required|min:4|max:20',
			'docente_id' => 'required|array|min:'.count($this->cohortes),
			'docente_id.*' => 'required',
			'nota_cohorte' => 'required|array|min:'.count($this->cohortes),
			'nota_cohorte.*' => 'required|numeric|min:1|max:20'
		],[],[
			'nota_cohorte.*' => 'nota',
			'nota_cohorte' => 'nota cohorte',
			'periodo_id' => 'periodo',
			'docente_id' => 'docente',
			'cod_anual' => 'unidad curricular',
			'seccion.*' => 'seccion',
			'docente_id.*' => 'docente',
			]);

		try {
			DB::beginTransaction();
			$p = HistoricoNota::find($this->periodo_id);
			$alumno = Alumno::find($this->estudiante);
			$asignatura = Asignatura::find($this->cod_anual);
			foreach ($this->nota_cohorte as $key => $cohorte) {
					$docente = Docente::find($this->docente_id[$key]);
					$desasignatura = DesAsignatura::find($key);
					HistoricoNota::create([
						'periodo' => $p->periodo,
						'nro_periodo' =>  $p->nro_periodo,
						'cedula_estudiante' => $alumno->cedula,
						'cod_desasignatura' => $desasignatura->codigo,
						'cod_asignatura' => $asignatura->codigo,
						'nombre_asignatura' => $desasignatura->nombre,
						'nota' => $cohorte,
						'observacion' => 'AGREGADO POR CORRECCION',
						'seccion' => Str::upper($this->seccion[$key]),
						'especialidad' => $alumno->Pnf->codigo,
						'cedula_docente' => $docente->cedula,
						'docente' => $docente->nombres.' '.$docente->apellidos,
						'tipo' => ($asignatura->aprueba == 1) ? 'PROYECTO' : 'NORMAL',
						'estatus' => 0
					]);
				}
			DB::commit();
			$this->reset();
			$this->emit('reset-select');
			session()->flash('mensaje','Unidad Curricular agregada con exito');
		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error',$th->getMessage());
		}
	}

	public function update()
	{
		// dd($this->nota_cohorte);
		$this->validate([
			'cohortes_actualizar' => 'array|min:1',
			'nota_cohorte' => 'array|min:1',
			'nota_cohorte.*' => 'required|numeric|min:1|max:20'
		],[],[
			'nota_cohorte.*' => 'nota',
			'nota_cohorte' => 'nota cohorte'
		]);

		try {
			DB::beginTransaction();
				foreach ($this->cohortes_actualizar as $key => $id_historico) {
					$historico = HistoricoNota::find($id_historico);
					$historico->update([
						'nota' => $this->nota_cohorte[$id_historico]
					]);
				}
			DB::commit();
			$this->reset();
			$this->emit('reset-select');
			session()->flash('mensaje','Corrección realizada con exito');
		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error',$th->getMessage());
		}
	}
}
