<?php

namespace App\Http\Livewire\Admin\Solicitudes;

use App\Mail\RechazoSolicitudCorreccion;
use App\Mail\SolicitudCorreccion as MailSolicitudCorreccion;
use App\Mail\SolicitudProcesada;
use App\Models\ActividadNota;
use App\Models\Alumno;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\HistoricoNota;
use App\Models\SolicitudCorreccion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Show extends Component
{
	public $relacion, $solicitud;
	public $estatus_admin, $estatus_alumno = [], $observacion, $observacion_admin;
	public $password;
	public $confirmingPass = false;
	public function mount(SolicitudCorreccion $solicitud, DesAsignaturaDocenteSeccion $relacion)
	{
		$this->relacion = $relacion;
		$this->solicitud = $solicitud;
		$this->estatus_admin = ($solicitud->estatus_admin == 'PROCESADO') ? 'PROCESADO POR DRCAA' : $solicitud->estatus_admin;
	}

    public function render()
    {
        return view('livewire.admin.solicitudes.show');
    }

	public function store()
	{
		$this->resetErrorBag();

		// $validator = $this->validate([
		// 	'password' => 'required'
		// ],
		// [
		// 	'password.required' => 'El campo :attribute es obligatorio.'
		// ],
		// [
		// 	'password' => 'contraseña'
		// ]
		// );
		// if (! Hash::check($this->password, Auth::user()->password)) {
        //     throw ValidationException::withMessages([
        //         'password' => [__('Esta contraseña no coincide con nuestros registros.')],
        //     ]);
        // }else{
		// 	$this->confirmingPass = false;
		// }

		try {
			DB::beginTransaction();

			$solicitud = SolicitudCorreccion::find($this->solicitud->id);
			if($this->estatus_admin == 'APROBADO' || $this->estatus_admin == 'RECHAZADO'){
				$solicitud->Detalles()->update([
					'estatus_admin' => ($this->estatus_admin == 'APROBADO') ? 'PROCESADO' : 'RECHAZADO',
					// 'estatus_admin' => ($this->estatus_jefe == 'RECHAZADO') ? 'RECHAZADO' : $solicitud->estatus_admin
				]);
				$solicitud->update([
					'estatus_admin' => ($this->estatus_admin == 'APROBADO') ? 'PROCESADO' : 'RECHAZADO',
					'observacion_admin' => ($this->observacion_admin == null) ? null : $this->observacion_admin,
					'admin_id' => Auth::user()->id
					// 'estatus_admin' => ($this->estatus_jefe == 'RECHAZADO') ? 'RECHAZADO' : $solicitud->estatus_admin
				]);
				if($this->estatus_admin == 'APROBADO'){
					// return dd($solicitud->Detalles);
					foreach ($solicitud->Detalles as $key => $detalle_solicitud) {
						$alumno = Alumno::find($detalle_solicitud->alumno_id);
						// ActividadNota::updateOrCreate(
						// 	[
						// 		'actividad_id' => $detalle_solicitud->actividad_id,
						// 		'alumno_id' => $detalle_solicitud->alumno_id,
						// 		'estatus' => 'CERRADO',
						// 	], //TODO: EL VALOR QUE NO SE ACTUALIZA
						// 	[
						// 		'nota' => $detalle_solicitud->nota_nueva,
						// 	] //TODO: EL VALOR QUE SE ACTUALIZA
						// );
						$nota_actividad = ActividadNota::where('actividad_id',$detalle_solicitud->actividad_id)
						->where('alumno_id', $detalle_solicitud->alumno_id)->first();
						// return dd($nota_actividad);
						if($nota_actividad){
							$nota_actividad->update([
								'nota' => $detalle_solicitud->nota_nueva
							]);
						}else{
							ActividadNota::create([
								'actividad_id' => $detalle_solicitud->actividad_id,
								'alumno_id' => $detalle_solicitud->alumno_id,
								'nota' => $detalle_solicitud->nota_nueva,
								'estatus' => 'CERRADO',
							]);
						}
						// return dd($alumno->NotasActividades($this->relacion->Actividades->pluck('id')));
						$nota = $alumno->Escala($alumno->NotasActividades($this->relacion->Actividades->pluck('id')));
						$historico = HistoricoNota::where('periodo',$solicitud->periodo)->where('seccion',$solicitud->seccion)
						->where('cedula_estudiante',$alumno->cedula)->where('cod_desasignatura',$solicitud->DesAsignatura->codigo)->first();
						$historico->update([
							'nota' => $nota
						]);

						// return dd($historico);
					}
				}
			}elseif ($this->estatus_admin == 'PROCESADO') {
				// return dd($this->estatus_alumno);
				foreach ($this->estatus_alumno as $alumno_id => $estatus_a) {
					$alumno = Alumno::find($alumno_id);
					foreach ($solicitud->Detalles->where('alumno_id',$alumno_id) as  $solicitud_detalle) {
						// ActividadNota::updateOrCreate(
						// 	[
						// 		'actividad_id' => $solicitud_detalle->actividad_id,
						// 		'alumno_id' => $solicitud_detalle->alumno_id,
						// 		'estatus' => 'CERRADO',
						// 	], //TODO: EL VALOR QUE NO SE ACTUALIZA
						// 	[
						// 		'nota' => $solicitud_detalle->nota_nueva,
						// 	] //TODO: EL VALOR QUE SE ACTUALIZA
						// );
						$nota_actividad = ActividadNota::where('actividad_id',$solicitud_detalle->actividad_id)
						->where('alumno_id', $solicitud_detalle->alumno_id)->first();
						if($estatus_a == 'APROBADO'){
							if($nota_actividad){
								$nota_actividad->update([
									'nota' => $solicitud_detalle->nota_nueva
								]);
							}else{
								ActividadNota::create([
									'actividad_id' => $solicitud_detalle->actividad_id,
									'alumno_id' => $solicitud_detalle->alumno_id,
									'nota' => $solicitud_detalle->nota_nueva,
									'estatus' => 'CERRADO',
								]);
							}
						}

						$solicitud_detalle->update([
							'estatus_admin' => ($estatus_a == 'APROBADO') ? 'PROCESADO' : 'RECHAZADO'
						]);
					}
					if($estatus_a == 'APROBADO'){
						$nota = $alumno->Escala($alumno->NotasActividades($this->relacion->Actividades->pluck('id')));
						// return dd($nota);
						$historico = HistoricoNota::where('periodo',$solicitud->periodo)->where('seccion',$solicitud->seccion)
						->where('cedula_estudiante',$alumno->cedula)->where('cod_desasignatura',$solicitud->DesAsignatura->codigo)->first();
						$historico->update([
							'nota' => $nota
						]);
					}
				}

				$solicitud->update([
					'estatus_admin' => 'PROCESADO',
					'observacion_admin' => ($this->observacion_admin == null) ? null : $this->observacion_admin,
					'admin_id' => Auth::user()->id
				]);
			}

			DB::commit();
			$this->emit('mensajes','success','Solicitud procesada exitosamente');
			$jefe = User::find($solicitud->Jefe->id);
			$usuario = User::find($solicitud->solicitante_id);
			// $usuario->roles()->sync([3]);
			if($this->estatus_admin != 'RECHAZADO'){
				Mail::to($usuario->email)->cc($jefe->email)->send(new SolicitudProcesada($usuario,$solicitud));
			}else{
				Mail::to($usuario->email)->cc($jefe->email)->send(new RechazoSolicitudCorreccion($usuario,$solicitud));
			}
			// $this->reset(['actividad','descripcion','porcentaje']);
			return redirect()->route('panel.solicitudes.index')->with('mensaje','Solicitud procesada exitosamente');
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
