<?php

namespace App\Http\Livewire\Admin;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\DesAsignatura;
use App\Models\HistoricoNota;
use App\Models\Plan;
use App\Models\Pnf;
use App\Models\Solicitud;
use App\Models\SolicitudDetalle;
use App\Models\Trayecto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class Per extends Component
{
	use WithPagination; //paginacion

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $perPage = 10;
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

	public $modo = 'crear';
	public $pnf,$trayecto,$uc,$estudiantea,$cohorte,$password,$planes = [];
	public $ucs = [];
	public $plan = [];
	public $plan_id;
	public $desucs = [];
	public $estudiantes = [];
	public $estudiantes_ad = [];
	public $estudiante_uc_nota = [];

	public $confirmingPass = false;

	public $p,$t,$u,$plan_actual;
	public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'pnf' => 'required|min:1|required_with_all:trayecto,uc,cohorte',
            'trayecto' => 'required|required_with_all:pnf,uc,cohorte',
            'uc' => 'required|required_with_all:trayecto,pnf,cohorte',
            'cohorte' => 'required|required_with_all:trayecto,pnf,uc',
            'estudiantea' => 'required|required_with_all:trayecto,pnf,uc,cohorte',
			'estudiante_uc_nota' => 'required|array|min:1',
			'estudiante_uc_nota.*' => 'required|numeric|min:1|max:20|digits_between:1,2',
        ]);
    }

    public function render()
    {
		// $pnfs = Pnf::all();
		$pnfs = Pnf::whereIn('id',[1,2,3,4,5,6,7,12,13])->get();
		$trayectos = Trayecto::orderBy('index')->get();
		if(!empty($this->pnf)){
			$pnf = Pnf::find($this->pnf);
			$this->planes = $pnf->Planes;
			if (!empty($this->plan_id)) {
				if(!empty($this->trayecto)){
					$plan = Plan::find($this->plan_id);
					if($this->pnf != $this->p){
						$this->reset(['trayecto','uc','estudiantea','cohorte','estudiante_uc_nota','estudiantes_ad','desucs','ucs','plan']);
					}

					if($this->trayecto != $this->t){
						$this->reset(['uc','estudiantea','cohorte','estudiante_uc_nota','estudiantes_ad','desucs','ucs']);
					}

					if($this->plan_actual != $this->plan_id){
						$this->reset(['uc','estudiantea','cohorte','estudiante_uc_nota','estudiantes_ad','desucs','ucs']);
					}
					$this->ucs = $plan->Asignaturas->where('trayecto_id',$this->trayecto);
					$this->plan = $plan;

					if(!empty($this->uc) && !is_null($this->uc)){
						if($this->uc != $this->u){
							$this->reset(['estudiantea','cohorte','estudiante_uc_nota','estudiantes_ad','desucs']);
						}
						$uc = Asignatura::where('codigo',$this->uc)->first();
						$this->desucs = $uc->DesAsignaturas;

						// $this->estudiantes = HistoricoNota::where('periodo','2020')->where('cod_asignatura',$uc->codigo)->where('estatus',0)->groupBy('cedula_estudiante')->get();
						$this->estudiantes = HistoricoNota::where('cod_asignatura',$uc->codigo)->where('estatus',0)->groupBy('cedula_estudiante')->get();
						if(!empty($this->estudiantea) && !empty($this->cohorte)){
							$this->estudiantes_ad =  HistoricoNota::whereIn('cedula_estudiante',$this->estudiantea)->where('cod_asignatura',$uc->codigo)->whereIn('cod_desasignatura',$this->cohorte)->groupBy('cedula_estudiante')->where('estatus',0)->get();
							// $this->estudiantes_ad =  HistoricoNota::whereIn('cedula_estudiante',$this->estudiantea)->where('periodo','2020')->where('cod_asignatura',$uc->codigo)->whereIn('cod_desasignatura',$this->cohorte)->groupBy('cedula_estudiante')->where('estatus',0)->get();
						}else{
							$this->addError('cohorte', 'El campo cohorte es requerido.');
							$this->reset(['estudiantes_ad']);
						}
						// $this->uc = $uc;
						$this->u = $this->uc;
					}
					$this->t = $this->trayecto;
				}
				$this->plan_actual = $this->plan_id;
			}
			$this->p = $this->pnf;
		}
		$this->emit('select2');

		$solicitudes = Solicitud::where('tipo','CORRECCION')->where('seccion','CIU-2020')->paginate($this->perPage);
        return view('livewire.admin.per',['pnfs' => $pnfs,'trayectos' => $trayectos,'solicitudes' => $solicitudes]);
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
		if (!Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('Esta contraseña no coincide con nuestros registros.')],
            ]);
        }else{
			$this->emit('close_modal_confirm');
		}

		$this->validate([
            'pnf' => 'required|min:1|required_with_all:trayecto,uc,cohorte',
			'plan' => 'required',
            'trayecto' => 'required|required_with_all:pnf,uc,cohorte',
            'uc' => 'required|required_with_all:trayecto,pnf,cohorte',
            'cohorte' => 'required|required_with_all:trayecto,pnf,uc',
            'estudiantea' => 'required|required_with_all:trayecto,pnf,uc,cohorte',
			'estudiante_uc_nota' => 'required|array|min:1',
			'estudiante_uc_nota.*' => 'required|numeric|min:1|max:20|digits_between:1,2',
        ],[

		],[
			'estudiantea' => 'estudiantes',
			'estudiante_uc_nota' => 'nota'
		]);

		$a = HistoricoNota::whereIn('cedula_estudiante',$this->estudiantea)->whereIn('cod_desasignatura',$this->cohorte)->where('estatus',0)->get();
		// $a = HistoricoNota::whereIn('cedula_estudiante',$this->estudiantea)->where('periodo','2020')->whereIn('cod_desasignatura',$this->cohorte)->where('estatus',0)->get();

		try {
			DB::beginTransaction();

			foreach ($this->cohorte as $key => $cohorte) {
				$desasignatura = DesAsignatura::where('codigo',$cohorte)->first();
				$solicitud = Solicitud::create([
					'solicitante_id' => 1,
					'admin_id' => Auth::user()->id,
					'desasignatura_id' => $desasignatura->id,
					'periodo' => '2020',
					'seccion' => 'CIU-2020',
					'tipo' => 'CORRECCION',
					'estatus' => 'PROCESADO',
					'motivo' => 'CIU-2020',
					'observacion' => 'CALIFICACION SUSTITUTIVA',
					'fecha' => Carbon::now(),
				]);
				foreach ($this->estudiantea as $key => $estudiante) {
					$alumno = Alumno::where('cedula',$estudiante)->first();
					$nro_periodo = $alumno->ultimo_periodo($desasignatura->Asignatura->codigo)->nro_periodo;
					$detalleSolicitud = SolicitudDetalle::create([
						'solicitud_id' => $solicitud->id,
						'alumno_id' => $alumno->id,
						'admin_id' => Auth::user()->id,
						'nota_e' =>  $alumno->Notas($desasignatura->Asignatura->codigo,$nro_periodo)->whereIn('cod_desasignatura',$cohorte)->first()->nota,
						'nota' => $this->estudiante_uc_nota[$alumno->cedula],
						'estatus' => 'PROCESADO',
						'observacion' => 'CALIFICACION SUSTITUTIVA'
					]);

					$historico = HistoricoNota::where('cedula_estudiante',$alumno->cedula)
					->where('nro_periodo',$nro_periodo)
					// ->where('periodo',$solicitud->periodo)
					->where('cod_desasignatura',$solicitud->DesAsignatura->codigo)
					->where('estatus',0)->get();
					foreach ($historico as $key => $h) {
						$h->update(['nota' => $detalleSolicitud->nota]);
					}
				}
			}
			DB::commit();

			$this->emit('cerrar_modal'); // Close model to using to jquery
			session()->flash('mensaje', 'Carga realizada correctamente.');
			$this->reset(['pnf','trayecto','uc','estudiantea','cohorte','estudiante_uc_nota','estudiantes_ad','desucs','ucs','plan']);

		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error',$th->getMessage());
		}
	}

	public function confirmPass()
	{
		$this->password = '';
		$this->confirmingPass = true;
		$this->emit('open_modal_confirm'); // Close model to using to jquery
	}
}
