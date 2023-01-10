<?php

namespace App\Http\Livewire\Admin\Cambios;

use App\Models\Alumno;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Inscripcion;
use App\Models\Plan;
use App\Models\Pnf;
use App\Models\Seccion;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
	protected $listeners = [
		'resetear',
	];
	public $estudiante,$estudiante_actual,$seccion_id=[],$seccion=[],$trayecto_id = [], $cambio, $pnfs =[], $plans =[], $pnf_d, $nucleos = [], $nucleo_d,$plan_id;

    public function render()
    {
		if (empty($this->estudiante) || $this->estudiante == '0') {
			$alumno = [];
		}else{
			// $this->uc_retirar = [];
			if($this->estudiante_actual != $this->estudiante){
				$this->reset(['seccion_id','seccion','trayecto_id']);
			}
			$this->estudiante_actual = $this->estudiante;
			$alumno = Alumno::find($this->estudiante);

			if ($this->cambio == 'CAMBIO DE SECCION') {
				if (!empty($this->trayecto_id)) {
					if (($clave = array_search("0", $this->seccion_id)) !== false) {
						unset($this->seccion_id[$clave]);
					}
					if (!empty($this->seccion_id)) {
						foreach(Seccion::whereIn('id',$this->seccion_id)->get() as $seccion){
							$this->seccion[$seccion->trayecto_id] = $seccion->nombre;
						}
					}else{
						$this->reset(['seccion','seccion_id']);
					}
				}else{
					$this->reset(['seccion','seccion_id']);
				}
			}elseif ($this->cambio == 'CAMBIO DE PNF') {
				$this->pnfs = Pnf::where('codigo','>=',40)->get();
				if (!empty($this->pnf_d)) {
					$pnf = Pnf::find($this->pnf_d);
					$this->plans = Plan::where('pnf_id',$this->pnf_d)->get();
					// $this->plan_id = Plan::where('pnf_id',$this->pnf_d)->orderBy('id','desc')->first()->id;
					$this->nucleos = $pnf->Nucleos;
				}
			}elseif ($this->cambio == 'CAMBIO DE PLAN') {
				// if (!empty($this->pnf_d)) {
					$this->plans = Plan::where('pnf_id',$alumno->pnf_id)->get();
				// }
			}

		}

        return view('livewire.admin.cambios.create',['alumno' => $alumno]);
    }

	public function resetear()
	{
		$this->reset();
		$this->emit('reset-select');
	}

	public function cambiar_pnf()
	{
		$this->validate([
			'pnf_d' => 'required',
			'nucleo_d' => 'required',
		],[],[
			'pnf_d' => 'pnf destino',
			'nucleo_d' => 'nucleo destino',
		]);
		$alumno = Alumno::find($this->estudiante);
		try {
			DB::beginTransaction();
			$alumno->update([
				'pnf_id' => $this->pnf_d,
				'nucleo_id' => $this->nucleo_d,
				'plan_id' => $this->plan_id
			]);
			DB::commit();
			$this->reset();
			$this->resetear();
			session()->flash('mensaje', 'Cambio realizado exitosamente');
		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error', $th->getMessage());
		}

	}
	public function cambiar_plan()
	{
		$this->validate([
			'plan_id' => 'required',
		],[],[
			'plan_id' => 'plan de estudio',
		]);
		$alumno = Alumno::find($this->estudiante);
		try {
			DB::beginTransaction();
			$alumno->update([
				'plan_id' => $this->plan_id
			]);
			DB::commit();
			$this->reset();
			$this->resetear();
			session()->flash('mensaje', 'Cambio realizado exitosamente');
		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error', $th->getMessage());
		}

	}
	public function cambiar()
	{
		$this->validate([
			'trayecto_id' => 'required|array|min:1',
			'seccion_id' => 'required|array|min:1',
		],[],[
			'trayecto_id' => 'trayecto',
			'seccion_id' => 'nueva seccion',
		]);
		$alumno = Alumno::find($this->estudiante);
		try {
			DB::beginTransaction();
			foreach ($alumno->InscritoActual()->Inscripcion as $key => $uc_inscrita){

				$desasignatura_id = $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->id;
				$trayecto_id = $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->id;
				if (array_key_exists($trayecto_id, $this->seccion_id) != false){
					$nueva_seccion = DesAsignaturaDocenteSeccion::where('seccion_id',$this->seccion_id[$trayecto_id])->where('des_asignatura_id',$desasignatura_id)->first();
					$inscripcion = Inscripcion::find($uc_inscrita->id);
					$inscripcion->update([
						'desasignatura_docente_seccion_id' => $nueva_seccion->id
					]);
				}
				// $seccion_id
			}
			DB::commit();
			$this->reset(['seccion_id','seccion','trayecto_id']);
			session()->flash('mensaje', 'Cambio realizado exitosamente');
		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error', $th->getMessage());
		}

	}
}
