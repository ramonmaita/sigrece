<?php

namespace App\Http\Livewire\Coordinador\Solicitudes;

use App\Mail\SolicitudCorreccion as MailSolicitudCorreccion;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\SolicitudCorreccion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Update extends Component
{
	public $relacion, $solicitud;
	public $estatus_jefe, $estatus_alumno = [], $observacion;
	public $password;
	public $confirmingPass = false;
	public function mount(SolicitudCorreccion $solicitud, DesAsignaturaDocenteSeccion $relacion)
	{
		$this->relacion = $relacion;
		$this->solicitud = $solicitud;
		$this->estatus_jefe = ($solicitud->estatus_jefe == 'PROCESADO') ? 'PROCESADO POR EL JEFE DE PNF' : $solicitud->estatus_jefe;
	}
    public function render()
    {
        return view('livewire..coordinador.solicitudes.update');
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

		try {
			DB::beginTransaction();

			$solicitud = SolicitudCorreccion::find($this->solicitud->id);
			if($this->estatus_jefe == 'APROBADO' || $this->estatus_jefe == 'RECHAZADO'){
				$solicitud->Detalles()->update([
					'estatus_jefe' => ($this->estatus_jefe == 'APROBADO') ? 'PROCESADO' : 'RECHAZADO',
					'estatus_admin' => ($this->estatus_jefe == 'RECHAZADO') ? 'RECHAZADO' : $solicitud->estatus_admin
				]);
				$solicitud->update([
					'estatus_jefe' => ($this->estatus_jefe == 'APROBADO') ? 'PROCESADO' : 'RECHAZADO',
					'estatus_admin' => ($this->estatus_jefe == 'RECHAZADO') ? 'RECHAZADO' : $solicitud->estatus_admin
				]);
			}elseif ($this->estatus_jefe == 'PROCESADO') {
				$solicitud->Detalles()->update([
					'estatus_jefe' => ($this->estatus_alumno == 'APROBADO') ? 'PROCESADO' : 'RECHAZADO'
				]);
				$solicitud->update([
					'estatus_jefe' => 'PROCESADO'
				]);
			}

			DB::commit();
			$this->emit('mensajes','success','Solicitud procesada exitosamente');
			$usuario = User::find(1);
			// $usuario->roles()->sync([3]);
			if($this->estatus_jefe != 'RECHAZADO'){
				Mail::to('uptebolivarcontrole20@gmail.com')->cc('ramonmaita06@gmail.com')->send(new MailSolicitudCorreccion($usuario,$solicitud));
			}
			// $this->reset(['actividad','descripcion','porcentaje']);
			return redirect()->route('panel.coordinador.solicitudes.index')->with('jet_mensaje','Solicitud procesada exitosamente');
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
