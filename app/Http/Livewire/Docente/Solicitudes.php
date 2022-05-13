<?php

namespace App\Http\Livewire\Docente;

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Coordinador;
use App\Models\DesAsignatura;
use App\Models\Asignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Solicitud;
use App\Models\HistoricoNota;
use App\Models\Periodo;
use App\Models\Seccion;
use App\Models\SolicitudCorreccion;
use App\Models\SolicitudCorreccionDetalle;
use App\Models\SolicitudDetalle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Laravel\Jetstream\ConfirmsPasswords;
use Illuminate\Validation\ValidationException;
use App\Mail\SolicitudCorreccion as MailSolicitudCorreccion;

class Solicitudes extends Component
{
	public $tipo_solicitud,$periodo,$uc,$seccion,$estudiante,$motivo,$password;
	public $periodos = [];
	public $ucs = [];
	public $secciones = [];
	public $estudiantes = [];
	public $estudiantes_add = [];
	public $ts;
	public $correcciones = [], $nota = [];
	public $confirmingPass = false;
	public $relacion;

	public function mount()
	{
		// $this->docentes  = Docente::where('estatus', 'ACTIVO')->get();
		// $this->estudiantes = Alumno::where('plan_id',14)->take(5)->get();
	}

    public function render()
    {
		$estudiantes = [];
		if(!empty($this->tipo_solicitud)){
			if($this->tipo_solicitud != $this->ts){
				$this->reset(['periodo','uc','seccion','estudiante','periodos','ucs','secciones','estudiantes','estudiantes_add']);
			}

			// $estatus = ($this->tipo_solicitud == 'CORRECCION') ? ['0'] : ['1'] ;
			switch ($this->tipo_solicitud) {
				case 'CORRECCION':
					$estatus = [0,1];
					$this->periodos = HistoricoNota::whereIn('estatus',$estatus)->where('cedula_docente',Auth::user()->cedula)->groupBy('periodo')->orderBy('nro_periodo','asc')->get();
				break;
				case 'RESET':
					$estatus = 0;
					$p = Periodo::where('estatus',$estatus)->first()->nombre;
					$this->periodos = HistoricoNota::where('periodo',$p)->where('estatus',$estatus)->where('cedula_docente',Auth::user()->cedula)->groupBy('periodo')->orderBy('nro_periodo','asc')->get();

					// $this->periodos = $p;
				break;
				default:
					$estatus = 1;
					$this->periodos = HistoricoNota::where('estatus',$estatus)->where('cedula_docente',Auth::user()->cedula)->groupBy('periodo')->orderBy('nro_periodo','asc')->get();
				break;
			}
			// $estatus = ($this->tipo_solicitud == 'CORRECCION') ? 0 : 1 ;
			if(!empty($this->periodo)){
				$this->ucs = HistoricoNota::where('cedula_docente',Auth::user()->cedula)->where('periodo',$this->periodo)->groupBy('cod_desasignatura')->orderBy('cod_desasignatura','asc')->get();
				if(!empty($this->uc)){
					$this->secciones = HistoricoNota::where('cedula_docente',Auth::user()->cedula)->where('periodo',$this->periodo)->where('cod_desasignatura',$this->uc)->groupBy('seccion')->orderBy('seccion','asc')->get();
					if(!empty($this->seccion)){
						if($this->tipo_solicitud == 'CORRECCION'){
				// 			$estudiantes = HistoricoNota::where('cedula_docente',Auth::user()->cedula)->where('periodo',$this->periodo)->where('cod_desasignatura',$this->uc)->where('seccion',$this->seccion)->groupBy('cedula_estudiante')->orderBy('cedula_estudiante','asc')->get();
							if(!empty($this->estudiante)){
								// $desasignatura = DesAsignatura::where('codigo',$this->uc)->first();
								// $periodo = Periodo::where('nombre',$this->periodo)->first();
								// $seccion = Seccion::where('nombre',$this->seccion)->where('periodo_id',$periodo->id)->first();
								// $this->relacion = DesAsignaturaDocenteSeccion::where('docente_id',Auth::user()->Docente->id)->where('seccion_id',$seccion->id)->where('des_asignatura_id',$desasignatura->id)->first();
								$this->estudiantes_add = HistoricoNota::whereIn('cedula_estudiante',$this->estudiante)->where('cedula_docente',Auth::user()->cedula)->where('periodo',$this->periodo)->where('cod_desasignatura',$this->uc)->where('seccion',$this->seccion)->groupBy('cedula_estudiante')->orderBy('cedula_estudiante','asc')->get();
								// $actividades = Actividad::with('notas')->where('seccion_id',$seccion->id)->where('desasignatura_id',$desasignatura->id)->get();
								// $alumnos = Alumno::whereIn('cedula',$this->estudiante)->pluck('id');
								// foreach ($actividades as $key => $actividad) {
								// 	foreach ($actividad->Notas->whereIn('alumno_id',$alumnos) as $key => $notas) {
								// 		$this->nota[$notas->alumno_id][$notas->actividad_id]  = $notas->nota ;
								// 	}
								// }


							}else{
								$cis = HistoricoNota::where('cedula_docente',Auth::user()->cedula)
																->where('periodo',$this->periodo)
																->where('cod_desasignatura',$this->uc)
																->where('seccion',$this->seccion)
																->groupBy('cedula_estudiante')
																->orderBy('cedula_estudiante','asc')->pluck('cedula_estudiante');

                                 $periodo = Periodo::where('nombre',$this->periodo)->first();
							$seccion = Seccion::where('nombre',$this->seccion)->where('periodo_id',$periodo->id)->first();
				// 			$plan = DesAsignatura::where('codigo',$this->uc)->first()->Asignatura->Plan;
							$plan_id = $seccion->plan_id;

								$plan = DesAsignatura::where('codigo',$this->uc)->first()->Asignatura->Plan;
								$this->estudiantes  = Alumno::whereIn('cedula',$cis)->where('plan_id',$plan_id)->get();
								$this->reset(['estudiantes_add','nota']);

							}
						}elseif($this->tipo_solicitud == 'RESET'){

						}else{
						    $periodo = Periodo::where('nombre',$this->periodo)->first();
							$seccion = Seccion::where('nombre',$this->seccion)->where('periodo_id',$periodo->id)->first();
				// 			$plan = DesAsignatura::where('codigo',$this->uc)->first()->Asignatura->Plan;
							$plan = $seccion->plan_id;
							// $estudiantes = Alumno::where('plan_id',$plan->id)->take(5)->get();
							$this->estudiantes = Alumno::where('plan_id',$plan)->get();
							if(!empty($this->estudiante)){
								$this->estudiantes_add = Alumno::whereIn('cedula',$this->estudiante)->where('plan_id',$plan)->get();
							}else{
								$this->reset(['estudiantes_add','nota']);
							}
						}
					}
				}
			}
			$this->ts = $this->tipo_solicitud;
		}
		$this->emit('select2');

        return view('livewire.docente.solicitudes',[
			'estudiantes' => $estudiantes
		]);
    }

    public function updated($name){
        if($name == 'estudiante'){
            if(!empty($this->estudiante)){

			$periodo = Periodo::where('nombre',$this->periodo)->first();
			$seccion = Seccion::where('nombre',$this->seccion)->where('periodo_id',$periodo->id)->first();

			$desasignatura = DesAsignatura::where('codigo',$this->uc)->first();
			$asigp = Asignatura::find($desasignatura->asignatura_id);
			$asignatura = Asignatura::where('codigo',$asigp->codigo)->where('plan_id',$seccion->plan_id)->first();
			$desasignatura = $asignatura->DesAsignaturas->where('codigo',$this->uc)->first();
			$this->relacion = DesAsignaturaDocenteSeccion::where('docente_id',Auth::user()->Docente->id)->where('seccion_id',$seccion->id)->where('des_asignatura_id',$desasignatura->id)->first();
			$this->estudiantes_add = HistoricoNota::whereIn('cedula_estudiante',$this->estudiante)->where('cedula_docente',Auth::user()->cedula)->where('periodo',$this->periodo)->where('cod_desasignatura',$this->uc)->where('seccion',$this->seccion)->groupBy('cedula_estudiante')->orderBy('cedula_estudiante','asc')->get();
			$actividades = Actividad::with('notas')->where('seccion_id',$seccion->id)->where('desasignatura_id',$desasignatura->id)->get();
			$alumnos = Alumno::whereIn('cedula',$this->estudiante)->pluck('id');
			foreach ($actividades as $key => $actividad) {
				foreach ($actividad->Notas->whereIn('alumno_id',$alumnos) as $key => $notas) {
					$this->nota[$notas->alumno_id][$notas->actividad_id]  = $notas->nota ;
				}
			}
        }
        }
    }

	public function store()
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

		if($this->tipo_solicitud == 'CORRECCION'){
			$this->validate([
				'periodo' => 'required',
				'seccion' => 'required',
				'tipo_solicitud' => 'required',
				'tipo_solicitud' => 'required',
				'motivo' => 'required',
				'uc' => 'required',
				'estudiante' => 'required|array|min:1',
				// 'correcciones' => 'required|array|min:1',
				// 'correcciones.*' => 'required|numeric|min:1|max:20|digits_between:1,2',
			],
				[
					'uc.required' => 'El campo :attribute es obligatorio.'
				],
				[
					'uc' => 'unidad curricular',
					'tipo_solicitud' => 'tipo de solicitud',
					// 'correcciones.*' => 'correccion'
				]
			);
		}elseif($this->tipo_solicitud == 'RESET'){
			$this->validate([
				'periodo' => 'required',
				'seccion' => 'required',
				'tipo_solicitud' => 'required',
				'motivo' => 'required',
				'uc' => 'required',
			],
			[
				'uc.required' => 'El campo :attribute es obligatorio.'
			],
			[
				'uc' => 'unidad curricular',
				'tipo_solicitud' => 'tipo de solicitud',
				]
			);
		}else{
			$this->validate([
				'periodo' => 'required',
				'seccion' => 'required',
				'tipo_solicitud' => 'required',
				'motivo' => 'required',
				'uc' => 'required',
				'estudiante' => 'required|array|min:1',
			],
				[
					'uc.required' => 'El campo :attribute es obligatorio.'
				],
				[
					'uc' => 'unidad curricular',
					'tipo_solicitud' => 'tipo de solicitud',
				]
			);

		}
		try {
			DB::beginTransaction();
			$periodo = Periodo::where('nombre',$this->periodo)->first();
			$seccion = Seccion::where('nombre',$this->seccion)->where('periodo_id',$periodo->id)->first();

			$desasignatura = DesAsignatura::where('codigo',$this->uc)->first();
			$asigp = Asignatura::find($desasignatura->asignatura_id);
			$asignatura = Asignatura::where('codigo',$asigp->codigo)->where('plan_id',$seccion->plan_id)->first();
			$desasignatura = $asignatura->DesAsignaturas->where('codigo',$this->uc)->first();
// 			$desasignatura = DesAsignatura::where('codigo',$this->uc)->first();
			$jefe = Coordinador::where('pnf_id',$desasignatura->Asignatura->pnf_id)->first();
			if($this->tipo_solicitud == 'CORRECCION'){
				$solicitud = SolicitudCorreccion::create([
					'solicitante_id' => Auth::user()->id,
					'admin_id' => 0,
					'jefe_id' => $jefe->user_id,
					'desasignatura_id' => $desasignatura->id,
					'periodo' => $this->periodo,
					'seccion' => $this->seccion,
					'estatus_jefe' => 'EN ESPERA',
					'estatus_admin' => 'EN ESPERA',
					'motivo' => $this->motivo,
					'observacion' => null,
					'fecha' => Carbon::now(),
				]);
			}else{
				$solicitud = Solicitud::create([
					'solicitante_id' => Auth::user()->id,
					'admin_id' => 0,
					'desasignatura_id' => $desasignatura->id,
					'periodo' => $this->periodo,
					'seccion' => $this->seccion,
					'tipo' => $this->tipo_solicitud,
					'estatus' => 'EN ESPERA',
					'motivo' => $this->motivo,
					'observacion' => null,
					'fecha' => Carbon::now(),
				]);
			}

			if($this->tipo_solicitud != 'RESET'){
				foreach ($this->estudiante as $key => $estudiante) {
					if($this->tipo_solicitud == 'CORRECCION'){
						$alumno = Alumno::where('cedula',$estudiante)->first();
						// $detalleSolicitud = SolicitudDetalle::create([
						// 	'solicitud_id' => $solicitud->id,
						// 	'alumno_id' => $alumno->id,
						// 	'admin_id' => 0,
						// 	'nota_e' =>  $alumno->NotaUc(Auth::user()->cedula, $this->periodo, $this->seccion, $this->uc)->nota,
						// 	'nota' => $this->correcciones[$alumno->cedula],
						// 	'estatus' => 'EN ESPERA',
						// 	'observacion' => null
						// ]);
						foreach($this->relacion->Actividades as $unidad){
							// return dd($alumno->id);
							// return dd($unidad->Nota($alumno->id));
							if(array_key_exists($unidad->id,$this->nota[$alumno->id])){

								SolicitudCorreccionDetalle::create([
									'solicitud_correccion_id' => $solicitud->id,
									'alumno_id' => $alumno->id,
									'actividad_id' => $unidad->id,
									'nota_anterior' => ($unidad->Nota($alumno->id)) ? $unidad->Nota($alumno->id)->nota : 0,
									'nota_nueva' => $this->nota[$alumno->id][$unidad->id],
									'estatus_jefe' => 'EN ESPERA',
									'estatus_admin' => 'EN ESPERA',
								]);
							}
						}
					}else{
						$alumno = Alumno::where('cedula',$estudiante)->first();
						$detalleSolicitud = SolicitudDetalle::create([
							'solicitud_id' => $solicitud->id,
							'alumno_id' => $alumno->id,
							'admin_id' => 0,
							'nota_e' => 0,
							'nota' => 0,
							'estatus' => 'EN ESPERA',
							'observacion' => null
						]);
					}
				}
			}

			DB::commit();

			if($this->tipo_solicitud == 'CORRECCION'){
				$usuario = User::find($solicitud->Jefe->id);
				// $usuario->roles()->sync([3]);
				// return dd($solicitud->Jefe);
				Mail::to($usuario->email)->cc('uptebolivarcontrole20@gmail.com')->send(new MailSolicitudCorreccion($usuario,$solicitud));
			}
			session()->flash('jet_mensaje', 'Solicitud genrada con exito.');
			return redirect()->route('panel.docente.solicitudes.index');
		} catch (\Throwable $th) {
			DB::rollback();

			session()->flash('jet_error', $th->getMessage());
		}
	}


	public function confirmPass()
	{
		$this->password = '';
		$this->confirmingPass = true;
	}
}
