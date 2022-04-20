<?php

namespace App\Http\Livewire\Admin\Alumnos;

use App\Models\Alumno;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class Datos extends Component
{
	public $edit_alumno_id, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $sexo, $lugarn, $fechan, $nacionalidad;

	public function mount(Alumno $alumno)
	{
		$this->edit_alumno_id = $alumno->id;
		$this->cedula = $alumno->cedula;
		$this->p_nombre = $alumno->p_nombre;
		$this->s_nombre = $alumno->s_nombre;
		$this->p_apellido = $alumno->p_apellido;
		$this->s_apellido = $alumno->s_apellido;
		$this->sexo = $alumno->sexo;
		$this->lugarn = $alumno->lugarn;
		$this->fechan = $alumno->fechan;
		$this->nacionalidad = $alumno->nacionalidad;
		// $this->uc_historico = $alumno->Plan->Asignaturas;
	}

    public function render()
    {
        return view('livewire.admin.alumnos.datos');
    }

	public function updateDatos()
	{
		$this->validate([
			'p_nombre' => 'required|min:3|max:50|string',
			's_nombre' => 'min:3|max:50|string',
			'p_apellido' => 'required|min:3|max:50|string',
			's_apellido' => 'min:3|max:50|string',
			'sexo' => 'required',
			'nacionalidad' => 'required',
			'lugarn' => 'required|min:8|max:120',
			'fechan' => 'required|date'
		]);

		try {
			DB::beginTransaction();
			$alumno = Alumno::find($this->edit_alumno_id)->update([
				 'p_nombre'  => Str::upper($this->p_nombre),
				 's_nombre'  => Str::upper($this->s_nombre),
				 'p_apellido'  => Str::upper($this->p_apellido),
				 's_apellido'  => Str::upper($this->s_apellido),
				 'sexo'  => Str::upper($this->sexo),
				 'lugarn'  => Str::upper($this->lugarn),
				 'fechan'  => $this->fechan,
				 'nacionalidad'  => Str::upper($this->nacionalidad),
			]);
			DB::commit();
			$this->emit('mensajes','success','Datos actualizados');
		} catch (\Throwable $th) {
			DB::rollback();
			$this->emit('mensajes','error',$th->getMessage());
		}
	}
}
