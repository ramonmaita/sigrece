<?php

namespace App\Http\Livewire\Docente\Secciones\Gestionar\Actividades;

use App\Models\Actividad;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
	public $actividad, $descripcion, $porcentaje, $id_seccion, $id_relacion, $id_desasignatura,$fecha;

	public function mount($relacion_id, $desasignatura_id, $seccion_id)
	{
		$this->id_relacion = $relacion_id;
		$this->id_desasignatura = $desasignatura_id;
		$this->id_seccion = $seccion_id;

	}

    public function render()
    {
        return view('livewire.docente.secciones.gestionar.actividades.create');
    }

	public function store()
	{
		$porcentaje = Actividad::where('desasignatura_docente_seccion_id',$this->id_relacion)
		->where('seccion_id' , $this->id_seccion)
		->where('desasignatura_id' , $this->id_desasignatura)->sum('porcentaje');
		$max_porcentaje = 100 - $porcentaje;
		// return dd($porcentaje);
		$max_porcentaje = ($max_porcentaje > 25) ? 25 : $max_porcentaje;

		$this->validate([
			'actividad' => 'required|min:3',
			'fecha' => 'required|date',
			'porcentaje' => 'required|numeric|min:1|max:'.$max_porcentaje
		]);

		try {
			DB::beginTransaction();

			Actividad::create([
				'desasignatura_docente_seccion_id' => $this->id_relacion,
				'desasignatura_id' => $this->id_desasignatura,
				'seccion_id' => $this->id_seccion,
				'actividad' => $this->actividad,
				'descripcion' => $this->descripcion,
				'porcentaje' => $this->porcentaje,
				'fecha' => $this->fecha,
			]);
			// Actividad::updateOrCreate(
			// 	[
			// 		'desasignatura_docente_seccion_id' => $this->id_relacion,
			// 		'desasignatura_id' => $this->id_desasignatura,
			// 		'seccion_id' => $this->id_seccion,

			// 	], //TODO: EL VALOR QUE NO SE ACTUALIZA
			// 	[
			// 		'actividad' => $this->actividad,
			// 		'descripcion' => $this->descripcion,
			// 		'porcentaje' => $this->porcentaje,

			// 	] //TODO: EL VALOR QUE SE ACTUALIZA
			// );

			DB::commit();
			$this->emit('mensajes','success','Actividad agregada con exito.	');
			$this->emit('recargar_tabla');
			$this->emit('recargar_actividades');
			$this->reset(['actividad','descripcion','porcentaje','fecha']);
			$this->emit('datatables');
			// return redirect()->back();
		} catch (\Throwable $th) {
			DB::rollback();

			session('error',$th->getMessage());
			// return vbak()
		}
	}
}
