<?php

namespace App\Http\Livewire\Docente\Secciones\Gestionar;

use App\Models\Actividad;
use App\Models\ActividadNota;
use App\Models\Alumno;
use App\Models\CargaNota;
use App\Models\DesAsignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\HistoricoNota;
use App\Models\Seccion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ListadoEstudiante extends Component
{
	protected $listeners = ['recargar_tabla' => '$refresh'];
	public $relacion = [], $nota = [], $actividad_id, $alumno_id, $desasignatura_id, $seccion_id;
	public $password;
	public $confirmingPass = false;
	public function mount($desasignatura_id, $seccion_id)
	{
		$this->relacion = DesAsignaturaDocenteSeccion::with('inscritos')
		->where('des_asignatura_id', $desasignatura_id)
		->where('seccion_id',$seccion_id)->first();

		// $actividades = Actividad::with('notas')->where('seccion_id',$seccion_id)->where('desasignatura_id',$desasignatura_id)->get();

		// foreach ($actividades as $key => $actividad) {
		// 	foreach ($actividad->Notas as $key => $notas) {
		// 		// $data = [
		// 		// 	$notas->actividad_id => $notas->nota
		// 		// ];
		// 		// array_push($this->nota,$data);
		// 		// array_push()
		// 		// $data  = array($notas->actividad_id => $notas->nota);
		// 		// array_push($this->nota[$notas->alumno_id][],$data);
		// 		$this->nota[$notas->alumno_id][$notas->actividad_id]  = $notas->nota ;
		// 	}
		// }

		$this->seccion_id = $seccion_id;
		$this->desasignatura_id = $desasignatura_id;
	}

    public function render()
    {

		$actividades = Actividad::with('notas')->where('seccion_id',$this->seccion_id)->where('desasignatura_id',$this->desasignatura_id)->get();

		foreach ($actividades as $key => $actividad) {
			foreach ($actividad->Notas as $key => $notas) {
				// $data = [
				// 	$notas->actividad_id => $notas->nota
				// ];
				// array_push($this->nota,$data);
				// array_push()
				// $data  = array($notas->actividad_id => $notas->nota);
				// array_push($this->nota[$notas->alumno_id][],$data);
				$this->nota[$notas->alumno_id][$notas->actividad_id]  = $notas->nota ;
			}
		}
		return view('livewire.docente.secciones.gestionar.listado-estudiante');
    }



	public function store()
	{
		ini_set('max_execution_time', 360);
		// return dd($this->nota);

		$this->validate([
			'nota.*.*' => 'required'
		]);

		try {
			DB::beginTransaction();
			foreach($this->nota as $alumno_id => $nota){
				foreach ($nota as $actividad_id => $nota_actividad) {
					$actividad = Actividad::find($actividad_id);
					$this->validate([
						'nota.'.$alumno_id.'.'.$actividad_id.'' => 'min:1|max:'.$actividad->porcentaje
					]);
					ActividadNota::updateOrCreate(
						[
							'actividad_id' => $actividad_id,
							'alumno_id' => $alumno_id,

						], //TODO: EL VALOR QUE NO SE ACTUALIZA
						[
							'nota' => $nota_actividad,
							'estatus' => 'CARGADO',

						] //TODO: EL VALOR QUE SE ACTUALIZA
					);


				}
			}

			DB::commit();
			$this->emit('mensajes','success','Calificaciones agregadas con exito.	');
			$this->emit('recargar_tabla');
			// $this->reset(['actividad','descripcion','porcentaje']);
			$this->emit('datatables');
			// return redirect()->back();
		} catch (\Throwable $th) {
			DB::rollback();
			$this->emit('mensajes','error',$th->getMessage());
			session('error',$th->getMessage());
			// return vbak()
		}
	}

	public function cerrar()
	{
		$this->resetErrorBag();

		$validator = $this->validate([
			'password' => 'required'
		],
		[
			'password.required' => 'El campo :attribute es obligatorio.'
		],
		[
			'password' => 'contraseña'
		]
		);
		if (! Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('Esta contraseña no coincide con nuestros registros.')],
            ]);
        }else{
			$this->confirmingPass = false;
		}

		try {
			DB::beginTransaction();
			$relacion = DesAsignaturaDocenteSeccion::with('inscritos')
			->where('des_asignatura_id', $this->desasignatura_id)
			->where('seccion_id',$this->seccion_id)->first();

			// $desasignatura = DesAsignatura::find($this->desasignatura_id);
			// $seccion = Seccion::find($this->seccion_id);
			// return dd($relacion->Actividades);

			foreach($relacion->Inscritos as $inscritos){
				$nota = $inscritos->Alumno->Escala($inscritos->Alumno->NotasActividades($relacion->Actividades->pluck('id')));


				HistoricoNota::updateOrCreate(
					[
						'periodo' => $relacion->Seccion->Periodo->nombre,
						'nro_periodo' =>  $relacion->Seccion->Periodo->nro,
						'cedula_estudiante' => $inscritos->Alumno->cedula,
						'cod_desasignatura' => $relacion->DesAsignatura->codigo,
						'cod_asignatura' => $relacion->DesAsignatura->Asignatura->codigo,
						'nombre_asignatura' => $relacion->DesAsignatura->nombre,
						'observacion' => 'POR CERRAR',
						'seccion' => $relacion->Seccion->nombre,
						'especialidad' => $relacion->Seccion->Pnf->codigo,
						'tipo' => ($relacion->DesAsignatura->Asignatura->aprueba == 1) ? 'PROYECTO' : 'NORMAL',
						'estatus' => 1
					],
					[
						'nota' => $nota,
						'cedula_docente' => $relacion->Docente->cedula,
						'docente' => $relacion->Docente->nombres.' '.$relacion->Docente->apellidos,
					]
				);
			}

			foreach ($relacion->Actividades as  $actividad) {
				$actividad->Notas()->update([
					'estatus' => 'CERRADO'
				]);
			}

			CargaNota::updateOrCreate(
				// ['departure' => 'Oakland', 'destination' => 'San Diego'],
				[
					'periodo' => $relacion->Seccion->Periodo->nombre,
					'seccion' => $relacion->Seccion->nombre,
					'cedula_docente' => $relacion->Docente->cedula,
					'docente' => $relacion->Docente->nombre_completo,
					'cod_desasignatura' => $relacion->DesAsignatura->codigo,
					'user_id' => Auth::user()->id],
				['fecha' => Carbon::now()],
			);



			DB::commit();
			$this->emit('mensajes','success','cerrado con exito.');
			$this->emit('recargar_tabla');
			$this->emit('recargar_pagina');
			// $this->reset(['actividad','descripcion','porcentaje']);
			$this->emit('datatables');
			// return redirect()->back();
		} catch (\Throwable $th) {
			DB::rollback();
			$this->emit('mensajes','error',$th->getMessage());
			session('error',$th->getMessage());
			// return vbak()
		}
	}

	public function confirmPass()
	{
		$this->password = '';
		$this->confirmingPass = true;
	}
}
