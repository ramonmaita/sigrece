<?php

namespace App\Http\Livewire\Admin;

use App\Mail\ActualizarUsuario;
use App\Mail\RegistroUsuario;
use App\Models\Alumno;
use Livewire\Component;
use Livewire\WithPagination; //paginacion
use App\Models\Docente;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Usuarios extends Component
{
	use WithPagination; //paginacion

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $perPage = 10;
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10, 25 , 50]
    ];

	public $modo = 'crear';
    public $titulo,$docente_id,$cedula,$nombre,$apellido,$correo,$tipo,$user_id;
	public $cedula_usuario, $nombres, $apellidos, $clave;
	// public $apellido1 ='asda';

	public $docentes = [];
	// public User $user;
    // protected $rules = [
    //     'cedula' => 'required|numeric|digits_between:6,8',
    //     'nombres' => 'required|string|min:2|max:40',
    //     'apellidos' => 'required|string|min:2|max:40',
    //     'fechan' => 'required|date',
    //     'nacionalidad' => 'required',
    //     'sexo' => 'required',
    //     'estatus' => 'required'
    // ];

	public function hydrate()
    {
        // $this->resetErrorBag();
        // $this->resetValidation();
		// $this->emit('select2');
    }

	public function resetSearch()
    {
        $this->search = '';
    }

	public function mount()
	{
		$this->docentes  = Docente::where('estatus', 'ACTIVO')->get();
	}

    public function render()
    {
		// $this->docentes  = Docente::where('estatus', 'ACTIVO')->get();
		$docentes = Docente::where('estatus', 'ACTIVO')->get();
		$alumnos = Alumno::all();
		$usuarios = User::where('cedula','like', "%$this->search%")
					    	->orWhere('nombre','like', "%$this->search%")
					    	->orWhere('apellido','like', "%$this->search%")
					    	->orWhere('email','like', "%$this->search%")
					    	->paginate($this->perPage);
		$this->emit('select2');
        return view('livewire.admin.usuarios',[
			'usuarios' => $usuarios,
			// 'docentes' => $docentes,
			'alumnos' => $alumnos
		]);
    }

	public function setTitulo($titulo,$modo)
    {
        $this->titulo = $titulo;
        $this->modo = $modo;
        if($modo == 'crear'){
            // $this->reset(['docente_id','cedula','nombre','apellido', 'nacionalidad','sexo','fechan', 'estatus']);
        }
    }
	public function store()
	{
		$password = (empty($this->clave)) ? Str::random(8) : $this->clave;

		// return dd($password);
		// TODO: roles: 1 => ADMIN , 2 => USUARIO , 3 => DOCENTE , 4 => ESTUDIANTE
		try {
			DB::beginTransaction();
			if($this->tipo == 'DOCENTE'){

				$user = Docente::find($this->user_id);
				if(!$user){
					session()->flash('error', 'Docente no encontrado.'. $this->user_id);
				}else{
					$usuario = User::create([
						'cedula' => $user->cedula,
						'nombre' => $user->nombres,
						'apellido' => $user->apellidos,
						'email' => $this->correo,
						'password' => bcrypt($password)
					]);

					$usuario->roles()->sync([3]);
					Mail::to($usuario->email)->send(new RegistroUsuario($usuario,$password));
					session()->flash('mensaje', 'Usuario Creado con exito.');
				}
			}elseif ($this->tipo == 'USUARIO') {
				$usuario = User::create([
					'cedula' => $this->cedula_usuario,
					'nombre' => $this->nombres,
					'apellido' => $this->apellidos,
					'email' => $this->correo,
					'password' => bcrypt($password)
				]);

				$usuario->roles()->sync([2]);
				Mail::to($usuario->email)->send(new RegistroUsuario($usuario,$password));
				session()->flash('mensaje', 'Usuario Creado con exito.');
			}
			$this->emit('cerrar_modal'); // Close model to using to jquery
			$this->reset(['user_id','correo']);
			DB::commit();
		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error', $th->getMessage());
		}
	}

	public function edit($id)
    {
    	$this->modo = 'editar';
		$this->titulo = 'EDITAR USUARIO';
		$usuario  = User::find($id);
		// $this->user = $usuario;
		$this->user_id = $usuario->id;
		$this->nombre = $usuario->nombre;
		$this->apellido = $usuario->apellido;
		// $this->apellido1 = 'maita';
		$this->correo = $usuario->email;
    	// $docente = Docente::find($id);
    	// $this->docente_id = $id;
    	// $this->cedula = $docente->cedula;
    	// $this->nombres = $docente->nombres;
    	// $this->apellidos = $docente->apellidos;
    	// $this->sexo = $docente->sexo;
    	// $this->fechan = $docente->fechan;
    	// $this->nacionalidad = $docente->nacionalidad;
    	// $this->estatus = $docente->estatus;
    }

	public function update()
	{
		$password = Str::random(8);
		// TODO: roles: 1 => ADMIN , 2 => USUARIO , 3 => DOCENTE , 4 => ESTUDIANTE
		try {
			DB::beginTransaction();
			// if($this->tipo == 'DOCENTE'){

				$user = User::find($this->user_id);
				if(!$user){
					session()->flash('error', 'Usuario no encontrado.'. $this->user_id);
				}else{

					$user->update([
						// 'cedula' => $this->cedula,
						'nombre' => $this->nombre,
						'apellido' => $this->apellido,
						'email' => $this->correo,
						'password' => bcrypt($password)
					]);

					$usuario = User::find($this->user_id);
					// $usuario->roles()->sync([3]);
					Mail::to($usuario->email)->send(new ActualizarUsuario($usuario,$password));
					session()->flash('mensaje', 'Usuario Actualizado con exito.');
				}
			// }
			$this->emit('cerrar_modal'); // Close model to using to jquery

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error', $th->getMessage());
		}
	}
}
