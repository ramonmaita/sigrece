<?php

namespace App\Http\Livewire\Web\Ingreso;

use App\Mail\RegistroUsuario;
use App\Models\ActualizacionDato;
use App\Models\Alumno;
use App\Models\Asignado;
use App\Models\Estado;
use App\Models\InformacionComplementaria;
use App\Models\InformacionContacto;
use App\Models\InformacionLaboral;
use App\Models\InformacionMedica;
use App\Models\Ingreso;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Periodo;
use App\Models\Plan;
use App\Models\Pnf;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;

class Form extends Component
{
	// TODO: PNF Y NUCLEO
	public $pnf, $nucleo,$nucleos,$pnf_id;
	// TODO: INFORMACION PERSONAL
	public $alumno_id,$cedula,$nacionalidad = 'V',$p_nombre,$s_nombre,$p_apellido,$s_apellido,$escivil = 'SOLTERO',$sexo,$fechan,$lugarn;
	// TODO: INFORMACION CONTACTO
	public $estado,$municipio,$parroquia,$direccion,$telefono,$facebook,$instagram,$twitter,$correo,$correo_alternativo;
	// TODO: INFORMACION MEDICA
	public $posee_discapacidad = 'NO',$discapacidad,$posee_enfermedad = 'NO',$enfermedad,$llamar_emergencia;
	// TODO: INFORMACION LABORAL
	public $trabaja = 'NO',$direccion_trabajo,$telefono_trabajo;
	// TODO: INFORMACION COMPLEMENTARIA
	public $pertenece_etnia = 'NO',$etnia,$madre,$tlf_madre,$padre,$tlf_padre,$ingreso='',$carnet_patria;
	public $equipos = [],$internet = [];

	public $pnf_actual,$asignado = false, $periodo_id;

	function mount($nuevo = null){

		$periodo = Periodo::where('estatus',0)->first();
		$this->periodo_id = $periodo->id;
		$this->ingreso = $periodo->nombre;

		if ($nuevo != null) {
			$this->asignado = true;
			$asignado = $nuevo;
			$this->cedula = $asignado->cedula;
			$this->sexo = $asignado->sexo;
			$this->fechan = $asignado->fecha_nacimiento;
			$this->sexo = $asignado->sexo;

			$nombres = explode(' ',$asignado->nombres,2);
			$this->p_nombre = $nombres[0];
			if (count($nombres) > 1) {
				$this->s_nombre = $nombres[1];
			}

			$apellidos = explode(' ',$asignado->apellidos,2);
			$this->p_apellido = $apellidos[0];
			if (count($apellidos) > 1) {
				$this->s_apellido = $apellidos[1];
			}

			$this->pnf_id = $nuevo->Pnf->id;
			$this->pnf = $nuevo->Pnf->nombre;
			foreach ($nuevo->Pnf->Nucleos as $key => $nucleo) {
				if($nucleo->Secciones->where('periodo_id',$this->periodo_id)->where('cupos','>',0)->count() > 0){
					$n[] = $nucleo->id;
				}
			}
			$this->nucleos = $nuevo->Pnf->Nucleos->whereIn('id',$n);
			// return dd($this->nucleos);

			// $this->telefono =
		}
// 		else{
// 		    	$this->pnf_id = Pnf::find($this->pnf)->id;
//     			$this->pnf = Pnf::find($this->pnf)->nombre;
//     			foreach (Pnf::find($this->pnf)->Pnf->Nucleos as $key => $nucleo) {
//     				if($nucleo->Secciones->where('periodo_id',$this->periodo_id)->where('cupos','>',0)->count() > 0){
//     					$n[] = $nucleo->id;
//     				}
//     			}
//     			$this->nucleos = $nuevo->Pnf->Nucleos->whereIn('id',$n);
// 		}

	}
    public function render()
    {
		$estados = Estado::whereNotIn('id',[26])->get();
		if (!empty($this->estado)) {
			$municipios = Municipio::where('estado_id',$this->estado)->get();
			if (!empty($this->municipio)) {
				$parroquias = Parroquia::where('municipio_id',$this->municipio)->get();
			}else{
				$parroquias = [];
			}
		}else{
			$municipios = [];
			$parroquias = [];
		}
		// $pnfs = Pnf::where('codigo','>=',40)->get();
		$pnf_search = 0;
		switch(Carbon::now()->format('d-m-Y')){
			case '17-10-2022':
				$pnf_search = [3];
				break;
			case '18-10-2022':
				$pnf_search = [1,13];
				break;
			case '19-10-2022':
				$pnf_search = [2,16];
				break;
			case '20-10-2022':
				$pnf_search = [5,6];
				break;
			case '21-10-2022':
				$pnf_search = [7,12,14,15];
				break;

			default:
				$pnf_search = [0];
			break;

		}

		if(Auth::user()->hasRole('Admin')){
			$pnf_search = [1,2,3,5,6,7,12,13,16,14,15];
		}

		$pnfs = Pnf::whereIn('id',$pnf_search)->get();
		if (!empty($this->pnf)) {
			$pnf = Pnf::find($this->pnf);
			if ($this->pnf_actual != $this->pnf) {
				$this->reset('nucleo');
			}
			if($this->asignado == false){
				// $this->nucleos = $pnf->Nucleos;
				foreach ($pnf->Nucleos as $key => $nucleo) {
				// 	if($nucleo->Secciones->where('periodo_id',$this->periodo_id)->where('cupos','>',0)->count() > 0){
				// 		if($nucleo->id == 8 || $nucleo->id == 7){
							$n[] = $nucleo->id;
				// 		}
				// 	}
				}
				$this->nucleos = $pnf->Nucleos->whereIn('id',$n);
			}
			// foreach ($pnf->Nucleos as $key => $nucleo) {
			// 	$this->nucleos[] = $nucleo->nucleo;
			// }
			$this->pnf_actual = $this->pnf;
		}else{
			$this->nucleos = [];
			$this->nucleo = '';
		}
        return view('livewire.web.ingreso.form',['estados' => $estados,'municipios' => $municipios,'parroquias' => $parroquias,'pnfs' => $pnfs]);
    }

	public function store()
	{
		// $alumno = Alumno::find($this->alumno_id);
		$usuario = User::where('cedula',$this->cedula)->first();
		$inf_contacto = DB::table('inf_contacto')->where('cedula_estudiante',$this->cedula)->first();
		$id_usuario = ($usuario) ? $usuario->id : 0;
		$id_contacto = ($inf_contacto) ? $inf_contacto->id : 0;
		$this->validate(
			[
				// TODO: INFORMACION PERSONAL
				'cedula' => 'required|numeric|unique:alumnos,cedula',
				'nacionalidad' => 'required|in:V,E',
				'p_nombre' => 'required|string|min:2|max:60',
				's_nombre' => 'nullable|string|min:2|max:60',
				'p_apellido' => 'required|string|min:2|max:60',
				's_apellido' => 'nullable|string|min:2|max:60',
				'escivil' => 'required',
				'sexo' => 'required',
				'fechan' => 'date',
				'pnf' => 'required',
				// TODO: INFORMACION DE CONTACTO
				'lugarn' => 'required|min:15|max:100',
				'estado' => 'required',
				'municipio' => 'required',
				'parroquia' => 'required',
				'direccion' => 'required|min:10|max:120',
				'twitter' => 'nullable|min:2|max:40',
				'facebook' => 'nullable|min:2|max:40',
				'instagram' => 'nullable|min:2|max:40',
				'telefono' => 'required|min:11|max:30',
				'correo' => 'required|email|min:8|max:80|unique:users,email,'.$id_usuario.'|unique:inf_contacto,correo,'.$id_contacto.'',
				'correo_alternativo' => 'nullable|email|min:8|max:80',
				// TODO: INFORMACION MEDICA
				'posee_discapacidad' => 'required',
				'discapacidad' => 'required_if:posee_discapacidad,SI|nullable|min:5|max:120',
				'posee_enfermedad' => 'required',
				'enfermedad' => 'required_if:posee_enfermedad,SI|nullable|min:5|max:120',
				'llamar_emergencia' => 'required|min:20|max:120',
				// TODO: INFORMACION LABORAL
				'trabaja' => 'required',
				'direccion_trabajo' => 'required_if:trabaja,SI|nullable|min:10|max:120',
				'telefono_trabajo' => 'required_if:trabaja,SI|nullable|min:11|max:30',
				// TODO: INFORMACION COMPLEMENTARIA
				'carnet_patria' => 'required|min:2|max:80',
				'pertenece_etnia' => 'required',
				'etnia' => 'required_if:pertenece_etnia,SI|nullable|min:4|max:120',
				'madre' => 'required|min:8|max:120|string',
				'tlf_madre' => 'nullable|min:11|max:30',
				'padre' => 'required|min:8|max:120|string',
				'tlf_padre' => 'nullable|min:11|max:30',
				'ingreso' => 'required|min:4|max:10',
				'nucleo' => 'required'
			],
			[

			],
			[
				'p_nombre' => 'primer nombre',
				's_nombre' => 'segundo nombre',
				'p_apellido' => 'primer apellido',
				's_apellido' => 'segundo apellido',
				'escivil' => 'estado civil',
				'fechan' => 'fecha de nacimiento',
				'lugarn' => 'lugar de nacimiento',
				'posee_discapacidad' => 'posee alguna discapacidad',
				'posee_enfermedad' => 'posee alguna enfermedad crónica',
				'enfermedad' => 'enfermedad crónica',
				'llamar_emergencia' => 'a quien llamar en caso de emergencia',
				'direccion_trabajo' => 'direccion de trabajo',
				'telefono_trabajo' => 'télefono de trabajo',
				'carnet_patria' => 'carnet de la patria',
				'pertenece_etnia' => 'pertenece a una etnia indigenea',
				'madre' => 'nombre y apellido de la madre',
				'tlf_madre' => 'télefono de la madre',
				'padre' => 'nombre y apellido del padre',
				'tlf_padre' => 'télefono del padre',
			]
		);

		try {
			DB::beginTransaction();

			$pnfid = ($this->asignado == true) ? $this->pnf_id : $this->pnf;
			$ti_hologoado = array([27,28,29,30,31,32,33,34,35,36]);
			$plan = Plan::where('pnf_id',$pnfid)->whereNotIn('id',$ti_hologoado)->orderBy('id','desc')->first();

			$alumno = Alumno::create([
				'cedula' => $this->cedula,
				'p_nombre' => Str::upper($this->p_nombre) ,
				's_nombre' => Str::upper($this->s_nombre) ,
				'p_apellido' => Str::upper($this->p_apellido) ,
				's_apellido' => Str::upper($this->s_apellido) ,
				'sexo' => $this->sexo ,
				'escivil' => $this->escivil ,
				'nacionalidad' => $this->nacionalidad ,
				'fechan' => $this->fechan ,
				'lugarn' => Str::upper($this->lugarn),
				'nucleo_id' => $this->nucleo, //TODO: INCLUIR CAMPO DE NUCLEO EN LA TABLA
				'pnf_id' => ($this->asignado == true) ? $this->pnf_id : $this->pnf,
				'plan_id' => $plan->id,
				'tipo' => 12
			]);

			ActualizacionDato::updateOrCreate(
				['alumno_id' => $alumno->id], //TODO: EL VALOR QUE NO SE ACTUALIZA
				['estatus' => 'ACTUALIZADO'] //TODO: EL VALOR QUE SE ACTUALIZA
			);
			InformacionContacto::updateOrCreate(
				['alumno_id' => $alumno->id], //TODO: EL VALOR QUE NO SE ACTUALIZA
				[
					'estado_id' => $this->estado ,
					'municipio_id' => $this->municipio ,
					'parroquia_id' => $this->parroquia ,
					'direccion' => Str::upper($this->direccion) ,
					'telefono' => $this->telefono,
					'facebook' => (is_null($this->facebook)) ? NULL :  $this->facebook ,
					'instagram' =>(is_null( $this->instagram)) ? NULL :  $this->instagram ,
					'twitter' => (is_null($this->twitter)) ? NULL :  $this->twitter ,
					'correo' => $this->correo ,
					'correo_alternativo' =>  (is_null($this->correo_alternativo)) ? NULL :  $this->correo_alternativo
				]
			);

			InformacionMedica::updateOrCreate(
				['alumno_id' => $alumno->id], //TODO: EL VALOR QUE NO SE ACTUALIZA
				[
					'posee_discapacidad' => $this->posee_discapacidad ,
					'discapacidad' => Str::upper($this->discapacidad) ,
					'posee_enfermedad' => $this->posee_enfermedad ,
					'enfermedad' => Str::upper($this->enfermedad) ,
					'llamar_emergencia' => Str::upper($this->llamar_emergencia)
				]
			);

			InformacionLaboral::updateOrCreate(
				['alumno_id' => $alumno->id], //TODO: EL VALOR QUE NO SE ACTUALIZA
				[
					'trabaja' => $this->trabaja ,
					'direccion' => Str::upper($this->direccion_trabajo) ,
					'telefono' => $this->telefono_trabajo
				]
			);

			InformacionComplementaria::updateOrCreate(
				['alumno_id' => $alumno->id], //TODO: EL VALOR QUE NO SE ACTUALIZA
				[
					'carnet_patria' => Str::upper($this->carnet_patria) ,
					'pertenece_etnia' => $this->pertenece_etnia ,
					'etnia' => Str::upper($this->etnia) ,
					'madre' => Str::upper($this->madre) ,
					'tlf_madre' => $this->tlf_madre ,
					'padre' => Str::upper($this->padre) ,
					'tlf_padre' => $this->tlf_padre ,
					'equipos' => (is_null($this->equipos)) ? NULL : implode(",",$this->equipos) ,
					'internet' => (is_null($this->internet)) ? NULL : implode(",",$this->internet) ,
					'ingreso' => $this->ingreso
				]
			);

			Ingreso::updateOrCreate(
				[
					'alumno_id' => $alumno->id,
					'periodo_id' => $this->periodo_id
				], //TODO: EL VALOR QUE NO SE ACTUALIZA
				[
					'estatus' => ($this->asignado == true) ? 'ACTUALIZADO' : 'REGISTRADO' ,
					'tipo' => ($this->asignado == true) ? 'ASIGNADO' : 'OTRAS OPRTUNIDADES',
				]
			);

			if($usuario){
				// $usuario->roles()->attach([4]);
				$usuario->update([
					'nombre' => $alumno->nombres,
					'apellido' => $alumno->apellidos,
					'email' => $alumno->InfoContacto->correo,
					]);
				$usuario->assignRole('Estudiante');

			}else{
				$usuario = User::create([
					'cedula' => $alumno->cedula,
					'nombre' => $alumno->nombres,
					'apellido' => $alumno->apellidos,
					'email' => $alumno->InfoContacto->correo,
					'password' => bcrypt($alumno->cedula)
				]);
				// $usuario->roles()->attach([4]);
				$usuario->assignRole('Estudiante');
			}
			DB::commit();
			Mail::to($usuario->email)->send(new RegistroUsuario($usuario,$alumno->cedula));

			if(Auth::user()->hasRole('Auxiliar')){
				$id_encriptado = encrypt($alumno->id);
				session()->flash('jet_mensaje','Registro realizado con exito.');
				return redirect()->route('panel.auxiliar.inscripciones.nuevo-ingreso.uc_a_inscribir',['id_encriptado' => $id_encriptado]);
			}else{
				session()->flash('jet_mensaje','Información actualizada con exito. revise su correo electronico para consultar su informacion de acceso');
				return redirect()->to('/');
			}
		} catch (\Throwable $th) {
			// dd($th);
			DB::rollback();
			return back()->with('jet_error',$th->getMessage());
		}
		// return back();
	}
}
