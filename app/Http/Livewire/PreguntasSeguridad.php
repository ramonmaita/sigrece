<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\Docente;
use App\Models\PreguntaSeguridad;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class PreguntasSeguridad extends Component
{
	public $step;
	public User $user;

	public $cedula;
	public $correo;
	public $fecha_nacimiento;

	public $preguntas;

	public $password;
	public $password1;

	public $error = '';
	public function buscarUsuario()
	{

		$user = User::where('cedula', $this->cedula)
			->first();

		if (!$user) {
			$this->error = "Usuario no encontrado";
			return;
		}

		$fecha_nacimiento = optional($user->Alumno)->fechan ?? optional($user->Docente)->fechan;

		if (!$fecha_nacimiento ||
			$this->correo !== $user->email ||
			$this->fecha_nacimiento !== $fecha_nacimiento
		) {
			return;
		}

		$this->error = '';
		$this->user = $user;

		if($this->user->preguntasSeguridad->count() == 4) {
			$this->step = 3;
			$preguntas = $this->user->preguntasSeguridad->random(2);
			$this->preguntas = $preguntas->map(fn($pregunta) => [
				"pregunta" => $pregunta->pregunta,
				"respuesta" => ""
			])->toArray();
		} else {
			$this->step = 2;
		}

	}

	public function verificar()
	{
		foreach ($this->preguntas as $pregunta) {
			$preguntaCorrecta = $this->user->preguntasSeguridad()
				->where('pregunta', $pregunta["pregunta"])
				->first();

			if(!Hash::check(strtolower(trim($pregunta["respuesta"])), $preguntaCorrecta->respuesta)) {
				$this->error = "Error en {$pregunta['pregunta']}";
				return;
			}
		}
		$this->preguntas = [];
		$this->step = 4;
	}

	public function guardarPreguntas()
	{
		$this->validate([
			'preguntas.*.pregunta' => 'required|not_empty',
			'preguntas.*.respuesta' => 'required|not_empty',
		]);

		foreach ($this->preguntas as $pregunta) {
			$this->user->preguntasSeguridad()->save(new PreguntaSeguridad($pregunta));
		}

		redirect('login');
	}

	public function cambiarContrasena()
	{
		$this->validate([
			'password' => 'required|min:8',
			'password1' => 'required|same:password'
		]);

		$this->user->password = Hash::make($this->password);
		$this->user->save();

		$this->password = '';
		$this->password1 = '';
		$this->step = 5;
	}

	public function boot()
	{
		Validator::extend('not_empty', function ($attribute, $value, $parameters, $validator) {
			return !empty(trim($value));
		});
	}

	public function mount()
	{
		$this->step = 1;

		$this->preguntas = [
			["pregunta" => "", "respuesta" => ""],
			["pregunta" => "", "respuesta" => ""],
			["pregunta" => "", "respuesta" => ""],
			["pregunta" => "", "respuesta" => ""],
		];

	}

    public function render()
    {
        return view('livewire.preguntas-seguridad');
    }
}
