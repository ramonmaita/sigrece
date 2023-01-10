<?php

namespace App\Http\Livewire\Web\Estudiantes;

use App\Mail\RegistroUsuario;
use App\Models\ActualizacionDato;
use App\Models\Alumno;
use App\Models\Estado;
use App\Models\InformacionComplementaria;
use App\Models\InformacionContacto;
use App\Models\InformacionLaboral;
use App\Models\InformacionMedica;
use App\Models\Ingreso;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Periodo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;

class Datos extends Component
{
	// TODO: PNF Y NUCLEO
	public $pnf, $nucleo,$nucleos = [];
	// TODO: INFORMACION PERSONAL
	public $alumno_id,$cedula,$nacionalidad,$p_nombre,$s_nombre,$p_apellido,$s_apellido,$escivil,$sexo,$fechan,$lugarn;
	// TODO: INFORMACION CONTACTO
	public $estado,$municipio,$parroquia,$direccion,$telefono,$facebook,$instagram,$twitter,$correo,$correo_alternativo;
	// TODO: INFORMACION MEDICA
	public $posee_discapacidad = 'NO',$discapacidad,$posee_enfermedad = 'NO',$enfermedad,$llamar_emergencia;
	// TODO: INFORMACION LABORAL
	public $trabaja = 'NO',$direccion_trabajo,$telefono_trabajo;
	// TODO: INFORMACION COMPLEMENTARIA
	public $pertenece_etnia = 'NO',$etnia,$madre,$tlf_madre,$padre,$tlf_padre,$ingreso='',$carnet_patria;
	public $equipos = [],$internet = [];
	public $periodo_id;

	public function mount($alumno)
	{
		$periodo = Periodo::where('estatus',0)->first();
		$this->periodo_id = $periodo->id;

		// TODO: INFORMACION PERSONAL
		$this->alumno_id = $alumno->id;
		$this->cedula = $alumno->cedula;
		$this->nacionalidad = $alumno->nacionalidad;
		$this->p_nombre = $alumno->p_nombre;
		$this->s_nombre = $alumno->s_nombre;
		$this->p_apellido = $alumno->p_apellido;
		$this->s_apellido = $alumno->s_apellido;
		$this->escivil = $alumno->escivil;
		$this->sexo = $alumno->sexo;
		$this->fechan = $alumno->fechan;
		$this->lugarn = $alumno->lugarn;

		// TODO: PNF Y NUCLEO
		$this->pnf = $alumno->Pnf->nombre;
		foreach ($alumno->Pnf->Nucleos as $key => $nucleo) {
			$this->nucleos[$nucleo->id] = $nucleo->nucleo;
		}
		$this->nucleo = ($alumno->nucleo_id == 1) ? 4 : $alumno->nucleo_id;

		// TODO: INFORMACION DEL ESTUDIANTE (DATA VALDEZ)
		$inf_estudiante = DB::table('inf_estudiante')->where('cedula',$alumno->cedula)->first();
		// TODO: INFORMACION DE CONTACTO
		$inf_contacto = DB::table('inf_contacto')->where('cedula_estudiante',$alumno->cedula)->first();
		if($alumno->InfoContacto){
			$inf_contacto = $alumno->InfoContacto;
			$this->estado = $inf_contacto->estado;
			$this->municipio = $inf_contacto->municipio;
			$this->parroquia = $inf_contacto->parroquia;
			$this->direccion = $inf_contacto->direccion;
			$this->telefono = $inf_contacto->telefono;
			$this->facebook = $inf_contacto->facebook;
			$this->instagram = $inf_contacto->instagram;
			$this->twitter = $inf_contacto->twitter;
			$this->correo = $inf_contacto->correo;
			$this->correo_alternativo = $inf_contacto->correo_alternativo;
			$this->estado = $inf_contacto->estado_id;
			$this->municipio = $inf_contacto->municipio_id;
			$this->parroquia = $inf_contacto->parroquia_id;
		}elseif($inf_contacto){
			$this->estado = $inf_contacto->estado;
			$this->municipio = $inf_contacto->municipio;
			$this->parroquia = $inf_contacto->parroquia;
			$this->direccion = $inf_contacto->direccion;
			$this->telefono = $inf_contacto->telefono;
			$this->facebook = $inf_contacto->facebook;
			$this->instagram = $inf_contacto->instagram;
			$this->twitter = $inf_contacto->twitter;
			$this->correo = $inf_contacto->correo;
			$this->correo_alternativo = $inf_contacto->correo_alternativo;
		}elseif($inf_estudiante){
			$this->telefono = $inf_estudiante->telefono;
			$this->direccion = $inf_estudiante->direccion;
		}

		// TODO: INFORMACION MEDICA
		$inf_medica = DB::table('inf_medica')->where('cedula_estudiante',$alumno->cedula)->first();
		if($alumno->InfoMedica){
			$inf_medica = $alumno->InfoMedica;
			$this->posee_discapacidad = $inf_medica->posee_discapacidad;
			$this->discapacidad = $inf_medica->discapacidad;
			$this->posee_enfermedad = $inf_medica->posee_enfermedad;
			$this->enfermedad = $inf_medica->enfermedad;
			$this->llamar_emergencia = $inf_medica->llamar_emergencia;
		}elseif ($inf_medica) {
			$this->posee_discapacidad = $inf_medica->posee_discapacidad;
			$this->discapacidad = $inf_medica->discapacidad;
			$this->posee_enfermedad = $inf_medica->posee_enfermedad;
			$this->enfermedad = $inf_medica->enfermedad;
			$this->llamar_emergencia = $inf_medica->llamar_emergencia;
		}elseif($inf_estudiante){
			$this->posee_discapacidad = ($inf_estudiante->discapacidad == '' || $inf_estudiante->discapacidad == NULL) ? 'NO' : $inf_estudiante->discapacidad;
			$this->discapacidad = ($this->posee_discapacidad != 'NO') ? $inf_estudiante->tipo_discapacidad : NULL;

		}

		// TODO: INFORMACION LABORAL
		$inf_laboral = DB::table('inf_laboral')->where('cedula_estudiante',$alumno->cedula)->first();
		if($alumno->InfoLaboral){
			$inf_laboral = $alumno->InfoLaboral;
			$this->trabaja = $inf_laboral->trabaja;
			$this->direccion_trabajo = $inf_laboral->direccion;
			$this->telefono_trabajo = $inf_laboral->telefono;
		}elseif ($inf_laboral) {
			$this->trabaja = $inf_laboral->trabaja;
			$this->direccion_trabajo = $inf_laboral->direccion;
			$this->telefono_trabajo = $inf_laboral->telefono;
		}

		// TODO: INFORMACION COMPLEMENTARIA
		$inf_complementaria = DB::table('inf_complementaria')->where('cedula_estudiante',$alumno->cedula)->first();
		if($alumno->InfoComplementaria){
			$inf_complementaria = $alumno->InfoComplementaria;
			$this->carnet_patria = $inf_complementaria->carnet_patria;
			$this->pertenece_etnia = $inf_complementaria->pertenece_etnia;
			$this->etnia = $inf_complementaria->etnia;
			$this->madre = $inf_complementaria->madre;
			$this->tlf_madre = $inf_complementaria->tlf_madre;
			$this->padre = $inf_complementaria->padre;
			$this->tlf_padre = $inf_complementaria->tlf_padre;
			$this->ingreso = $inf_complementaria->ingreso;
			if ($inf_complementaria->equipos != null) {
				$equipos = explode(',',$inf_complementaria->equipos);
				foreach ($equipos as $key => $item) {
					$this->equipos[$item] = $item;
				}
			}
			if ($inf_complementaria->internet != null) {
				$internet = explode(',',$inf_complementaria->internet);
				foreach ($internet as $key => $item) {
					$this->internet[$item] = $item;
				}
			}
		}elseif ($inf_complementaria) {
			$this->carnet_patria = $inf_complementaria->carnet_patria;
			$this->pertenece_etnia = $inf_complementaria->pertenece_etnia;
			$this->etnia = $inf_complementaria->etnia;
			$this->madre = $inf_complementaria->madre;
			$this->tlf_madre = $inf_complementaria->tlf_madre;
			$this->padre = $inf_complementaria->padre;
			$this->tlf_padre = $inf_complementaria->tlf_padre;
			$this->ingreso = $inf_complementaria->ingreso;
			// $this->equipos = $inf_complementaria->equipos;
			// $this->internet = $inf_complementaria->internet;
			if ($inf_complementaria->equipos != null) {
				$equipos = explode(',',$inf_complementaria->equipos);
				foreach ($equipos as $key => $item) {
					$this->equipos[$item] = $item;
				}
			}
			if ($inf_complementaria->internet != null) {
				$internet = explode(',',$inf_complementaria->internet);
				foreach ($internet as $key => $item) {
					$this->internet[$item] = $item;
				}
			}
		}elseif($inf_estudiante){
			$this->pertenece_etnia = (Str::upper($inf_estudiante->indigena) == 'SI' ) ? $inf_estudiante->indigena : 'NO';
			$this->etnia = ($this->pertenece_etnia == 'SI') ? $inf_estudiante->etnia : NULL;
			$this->ingreso = $inf_estudiante->ingreso;
		}

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
        return view('livewire.web.estudiantes.datos',['estados' => $estados,'municipios' => $municipios,'parroquias' => $parroquias]);
    }

	public function store()
	{
		$alumno = Alumno::find($this->alumno_id);
		$usuario = User::where('cedula',$this->cedula)->first();
		$inf_contacto = DB::table('inf_contacto')->where('cedula_estudiante',$this->cedula)->first();
		$id_usuario = ($usuario) ? $usuario->id : 0;
		$id_contacto = ($inf_contacto) ? $inf_contacto->id : 0;
		$this->validate(
			[
				// TODO: INFORMACION PERSONAL
				'nacionalidad' => 'required|in:V,E',
				'p_nombre' => 'required|string|min:2|max:60',
				's_nombre' => 'nullable|string|min:2|max:60',
				'p_apellido' => 'required|string|min:2|max:60',
				's_apellido' => 'nullable|string|min:2|max:60',
				'escivil' => 'required',
				'sexo' => 'required',
				'fechan' => 'date',
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

			ActualizacionDato::updateOrCreate(
				['alumno_id' => $alumno->id], //TODO: EL VALOR QUE NO SE ACTUALIZA
				['estatus' => 'ACTUALIZADO'] //TODO: EL VALOR QUE SE ACTUALIZA
			);

			Alumno::find($this->alumno_id)->update([
				'p_nombre' => Str::upper($this->p_nombre) ,
				's_nombre' => Str::upper($this->s_nombre) ,
				'p_apellido' => Str::upper($this->p_apellido) ,
				's_apellido' => Str::upper($this->s_apellido) ,
				'sexo' => $this->sexo ,
				'escivil' => $this->escivil ,
				'nacionalidad' => $this->nacionalidad ,
				'fechan' => $this->fechan ,
				'lugarn' => Str::upper($this->lugarn),
				'nucleo_id' => $this->nucleo //TODO: INCLUIR CAMPO DE NUCLEO EN LA TABLA
			]);

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
					'estatus' => 'ACTUALIZADO' ,
					'tipo' => 'REINGRESO',
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
			DB::rollback();
			return back()->with('jet_error',$th->getMessage());
		}
		// return back();
	}
}
