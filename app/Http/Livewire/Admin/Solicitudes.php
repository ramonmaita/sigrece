<?php

namespace App\Http\Livewire\Admin;

use App\Models\Alumno;
use App\Models\CargaNota;
use App\Models\HistoricoNota;
use App\Models\Periodo;
use App\Models\Solicitud;
use App\Models\SolicitudDetalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination; //paginacion

use function PHPUnit\Framework\arrayHasKey;

class Solicitudes extends Component
{
	use WithPagination; //paginacion

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $perPage = 10;
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];


	public $modo,$solicitud_id;
	public $fecha,$solicitante,$periodo,$uc,$tipo,$estatus,$admin,$motivo,$observacion,$seccion,$password;
	// public Solicitud $sol;
	protected $rules = [
        'sol.fecha' => 'required', //whatever rules you want
        'sol.solicitante.nombre' => 'required',
        'sol.tipo' => 'required',
    ];

	public $estudiantes = [];
	public $detalle_estatus = [];
	public $detalle_observacion = [];
	public $confirmingPass = false;

    public function render()
    {
		$solicitudes = Solicitud::where('tipo','!=','RETIRO DE UC')
							->where(function ($query)
							{
								$query->where('observacion','!=','CALIFICACION SUSTITUTIVA')
								->orWhere('fecha','like', "%$this->search%")
								->orWhere('estatus','like', "%$this->search%")
								->orWhere('tipo','like', "%$this->search%")
								->orWhere('seccion','like', "%$this->search%");
							})
							->paginate($this->perPage);
        return view('livewire.admin.solicitudes',['solicitudes' => $solicitudes]);
    }

	public function resetSearch()
    {
        $this->search = '';
    }

	public function setTitulo($titulo,$modo)
    {
        $this->titulo = $titulo;
        $this->modo = $modo;
        if($modo == 'crear'){

            // $this->resetInputs();
        }
    }

	public function edit(Solicitud $solicitud)
	{
		$this->reset();
		$this->modo = 'editar';
		if($solicitud->admin_id == 0 || $solicitud->estatus == 'EN ESPERA'){
			$solicitud_id = $solicitud->id;
			$solicitud = $solicitud->update(['admin_id' => Auth::user()->id,'estatus' => 'EN REVISION']);
			$solicitud = Solicitud::find($solicitud_id);
		}
		$this->solicitud_id  = $solicitud->id;
		$this->fecha = $solicitud->created_at ;
		$this->solicitante = $solicitud->Solicitante->nombre.' '.$solicitud->Solicitante->apellido ;
		$this->periodo = $solicitud->periodo ;
		$this->uc = $solicitud->DesAsignatura->nombre ;
		$this->tipo = $solicitud->tipo ;
		$this->estatus = $solicitud->estatus ;
		$this->admin = $solicitud->admin_id ;
		$this->seccion = $solicitud->seccion ;
		$this->motivo = $solicitud->motivo ;
		$this->observacion = $solicitud->observacion;

		// $estudiante
		foreach ($solicitud->Detalles as $key => $detalle) {
			if($solicitud->tipo == 'CORRECCION'){
				$erronea = $detalle->nota_e;
				// $erronea = $detalle->Alumno->NotaUc($solicitud->Solicitante->cedula,$solicitud->periodo,$solicitud->seccion, $solicitud->DesAsignatura->codigo)->nota;
			}else{
				$erronea = 0;
			}
			$estudiantes = [
				'cedula' => $detalle->Alumno->cedula,
				'nombres' => $detalle->Alumno->nombres,
				'apellidos' => $detalle->Alumno->apellidos,
				'nota' => $detalle->nota,
				'erronea' => $detalle->nota_e,
				'estatus' => $detalle->estatus,
				'observacion' => $detalle->observacion,
			];
			array_push($this->estudiantes,$estudiantes);
			$this->detalle_estatus[$detalle->Alumno->cedula]=$detalle->estatus;
		}
	}

	public function show(Solicitud $solicitud)
	{
		$this->reset();
		$this->modo = 'ver';
		if($solicitud->admin_id == 0){
			$solicitud_id = $solicitud->id;
			$solicitud = $solicitud->update(['admin_id' => Auth::user()->id]);
			$solicitud = Solicitud::find($solicitud_id);
		}
		$this->solicitud_id  = $solicitud->id;
		$this->fecha = $solicitud->created_at ;
		$this->solicitante = $solicitud->Solicitante->nombre.' '.$solicitud->Solicitante->apellido ;
		$this->periodo = $solicitud->periodo ;
		$this->uc = $solicitud->DesAsignatura->nombre ;
		$this->tipo = $solicitud->tipo ;
		$this->estatus = $solicitud->estatus ;
		$this->admin = $solicitud->admin_id ;
		$this->seccion = $solicitud->seccion ;
		$this->motivo = $solicitud->motivo ;
		$this->observacion = $solicitud->observacion;

		// $estudiante
		if($this->tipo != 'RESET'){
			foreach ($solicitud->Detalles as $key => $detalle) {
				if($solicitud->tipo == 'CORRECCION'){
					$erronea = $detalle->nota_e;
					// $erronea = $detalle->Alumno->NotaUc($solicitud->Solicitante->cedula,$solicitud->periodo,$solicitud->seccion, $solicitud->DesAsignatura->codigo)->nota;
				}else{
					$erronea = 0;
				}
				$estudiantes = [
					'cedula' => $detalle->Alumno->cedula,
					'nombres' => $detalle->Alumno->nombres,
					'apellidos' => $detalle->Alumno->apellidos,
					'nota' => $detalle->nota,
					'erronea' => $erronea,
					'estatus' => $detalle->estatus,
					'observacion' => $detalle->observacion,
				];
				array_push($this->estudiantes,$estudiantes);
				$this->detalle_estatus[$detalle->Alumno->cedula]=$detalle->estatus;
				$this->detalle_observacion[$detalle->Alumno->cedula]=$detalle->obdetalle_observacion;
			}
		}
	}

	public function update(Solicitud $solicitud)
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
			$this->emit('close_modal_confirm');
		}

		try {
			$periodo_a = Periodo::where('nombre',$solicitud->periodo)->first();
			DB::beginTransaction();
				if($this->tipo == 'RESET'){
					if($this->estatus == 'PROCESADO' || $this->estatus == 'PROCESADO CON OBSERVACIONES' || $this->estatus == 'RECHAZADO'){
						$historico = HistoricoNota::where('periodo',$periodo_a->nombre)
								->where('seccion',$solicitud->seccion)
								->where('cedula_docente',$solicitud->Solicitante->cedula)
								->where('cod_desasignatura',$solicitud->DesAsignatura->codigo)
								->where('estatus',0)->get();
								foreach ($historico as $key => $h) {
									$h->update([
										'nota' => 0,
										'observacion' => 'POR CERRAR',
										'estatus' => 1
									]);
								}
						CargaNota::where('periodo',$periodo_a->nombre)
								->where('seccion',$solicitud->seccion)
								->where('cedula_docente',$solicitud->Solicitante->cedula)
								->where('cod_desasignatura',$solicitud->DesAsignatura->codigo)->delete();

						$solicitud->update([
							'estatus' => $this->estatus,
							'observacion' => ($this->observacion == null) ? NULL : $this->observacion
						]);
					}
				}else{
					foreach ($this->detalle_estatus as $key => $estatus) {
						$alumno = Alumno::where('cedula',$key)->first();
						$detalle_solicitud = SolicitudDetalle::where('solicitud_id',$solicitud->id)->where('alumno_id',$alumno->id)->first();
						if($solicitud->tipo == 'INCORPORAR' && $estatus == 'PROCESADO' || $solicitud->tipo == 'INCORPORAR' && $estatus == 'PROCESADO CON OBSERVACIONES'){
							HistoricoNota::create([
								'periodo' => $periodo_a->nombre,
								'nro_periodo' => $periodo_a->nro,
								'cedula_estudiante' => $alumno->cedula,
								'cod_desasignatura' => $solicitud->DesAsignatura->codigo,
								'cod_asignatura' => $solicitud->DesAsignatura->Asignatura->codigo,
								'nombre_asignatura' => $solicitud->DesAsignatura->nombre,
								'nota' => 0,
								'observacion' => 'POR CERRAR',
								'seccion' => $solicitud->seccion,
								'especialidad' => $solicitud->DesAsignatura->Asignatura->Pnf->codigo,
								'cedula_docente' => $solicitud->Solicitante->cedula,
								'docente' => $solicitud->Solicitante->nombre.' '.$solicitud->Solicitante->apellido,
								'tipo' => ($solicitud->DesAsignatura->Asignatura->aprueba == 1) ? 'PROYECTO' : 'NORMAL',
								'estatus' => 1,
								]);
						}else{
							// $alumno->NotaUc($solicitud->Solicitante->cedula,$solicitud->periodo,$solicitud->seccion, $solicitud->DesAsignatura->codigo);

							$historico = HistoricoNota::where('cedula_estudiante',$alumno->cedula)
								->where('periodo',$periodo_a->nombre)
								->where('cedula_docente',$solicitud->Solicitante->cedula)
								->where('cod_desasignatura',$solicitud->DesAsignatura->codigo)
								->where('estatus',0)->get();
								foreach ($historico as $key => $h) {
									$h->update(['nota' => $detalle_solicitud->nota]);
								}

						}
						$detalle_solicitud->update([
							'estatus' => $estatus,
							'observacion' => array_key_exists($key, $this->detalle_observacion) ? $this->detalle_observacion[$key] : null
						]);

						$e_espera = 0;
						$e_revision = 0;
						$solicitud = Solicitud::find($this->solicitud_id);
						foreach ($solicitud->Detalles as $e) {
							if($e->estatus == 'EN ESPERA' || $e->estatus == 'EN REVISION'){
								$e_espera++;
							}else{
								$e_revision++;
							}
						}
						$estatus_actualizar = ($e_espera >= $e_revision) ? 'EN REVISION' : 'PROCESADO';

						$solicitud->update(['estatus' => $estatus_actualizar]);
					}
				}
				$this->emit('cerrar_modal'); // Close model to using to jquery
				session()->flash('mensaje', 'Solicitud actualizada correctamente.');
			DB::commit();
		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error',$th->getMessage());
		}
		// dd($solicitud);
	}

	public function confirmPass()
	{
		$this->password = '';
		$this->confirmingPass = true;
		$this->emit('open_modal_confirm'); // Close model to using to jquery
	}
}
