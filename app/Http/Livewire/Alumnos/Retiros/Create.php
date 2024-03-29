<?php

namespace App\Http\Livewire\Alumnos\Retiros;

use App\Models\Alumno;
use App\Models\Inscripcion;
use App\Models\Inscrito;
use App\Models\Solicitud;
use App\Models\SolicitudDetalle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
	protected $listeners = [
		'resetear',
		'incrementar',
		'disminuir',
		'refresh' => '$refresh'
	];
	public $estudiante,$uc_retirar = [],$estudiante_actual, $contadorRetirar,$showAlumno = false,$indicador = 0;

	public function mount($alumno = null)
	{
		if ($alumno != null ) {
			$this->estudiante = $alumno->id;
			$this->showAlumno = true;
		}else{
			$this->showAlumno = false;
		}

	}

    public function render()
    {
		if (empty($this->estudiante) || $this->estudiante == '0') {
			$alumno = [];
		}else{
			// $this->uc_retirar = [];
			if($this->estudiante_actual != $this->estudiante){
				$this->reset('uc_retirar');
			}
			$this->estudiante_actual = $this->estudiante;
			$alumno = Alumno::find($this->estudiante);
		}
		$valor=false;
		if (($key = array_search($valor, $this->uc_retirar)) !== false) {
			unset($this->uc_retirar[$key]);
		}

        return view('livewire.alumnos.retiros.create',['alumno' => $alumno]);
    }

	public function resetear()
	{
		$this->reset();
		$this->emit('reset-select');
	}

	public function incrementar()
	{
		$this->contadorRetirar++;
	}
	public function disminuir()
	{
		$this->contadorRetirar--;
	}


	public function retirar()
	{
		$this->validate([
			'estudiante' => 'required|min:0|numeric',
			'uc_retirar' => 'required|array|min:1',
			// 'contadorRetirar' => 'min:1',
		]);

		try {
			DB::beginTransaction();
				$alumno = Alumno::find($this->estudiante);
				$estaInscrito = true;
				foreach ($this->uc_retirar as $key => $inscripcion_id) {
					if ($inscripcion_id == true) {
						// echo 'esta se va a retirar <br>';
						$inscripcion = Inscripcion::find($inscripcion_id);
						$soliciutd = Solicitud::create([
							'solicitante_id' => ($alumno->Usuario) ? $alumno->Usuario->id : Auth::user()->id,
							'admin_id' => Auth::user()->id ,
							'desasignatura_id' => $inscripcion->RelacionDocenteSeccion->DesAsignatura->id ,
							'periodo' => $inscripcion->RelacionDocenteSeccion->Seccion->Periodo->nombre ,
							'seccion' => $inscripcion->RelacionDocenteSeccion->Seccion->nombre ,
							'tipo' => 'RETIRO DE UC' ,
							'estatus' =>'EN ESPERA' ,
							'motivo' => 'RETIRO DE UC',
							'observacion' =>  $inscripcion->id,
							'fecha' => Carbon::now()
						]);

						SolicitudDetalle::create([
							'solicitud_id' => $soliciutd->id,
							'alumno_id' => 	$alumno->id,
							'admin_id' => Auth::user()->id,
							'nota' => 0,
							'nota_e' => 0,
							'esatus' => 'EN ESPERA',
							'observacion' => NULL
						]);
						$inscripcion->delete();
					}
				}
				if (count($alumno->InscritoActual()->Inscripcion) <= 0) {
					$inscrito = Inscrito::find($alumno->InscritoActual()->id);
					$estaInscrito = false;
					$inscrito->delete();
				}
			DB::commit();
			session()->flash('jet_mensaje', 'Unidades Curriculares retiradas exitosamente');
			return redirect()->route('panel.estudiante.retiros.show-pdf');
				// dd($this->uc_retirar);
			// if ($this->showAlumno == false) {
			// }else{
			// 	$this->reset();
			// 	$this->showAlumno = true;
			// 	$this->estudiante = $alumno->id;
			// 	$this->emit('refresh');
			// 	session()->flash('mensaje', 'Unidades Curriculares retiradas exitosamente');
			// 	$this->emit('recargar_iframes',$estaInscrito);
			// }

		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('jet_error', $th->getMessage());
		}
		// dd($this->uc_retirar);
	}
}
