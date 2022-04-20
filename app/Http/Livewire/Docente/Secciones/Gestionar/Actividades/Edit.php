<?php

namespace App\Http\Livewire\Docente\Secciones\Gestionar\Actividades;

use App\Models\Actividad;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{

	protected $listeners = ['recargar_actividades' => '$refresh'];

	public $actividad, $descripcion, $porcentaje, $id_seccion, $id_relacion, $id_desasignatura, $actividad_id;

	public function mount($relacion_id, $desasignatura_id, $seccion_id)
	{
		$this->id_relacion = $relacion_id;
		$this->id_desasignatura = $desasignatura_id;
		$this->id_seccion = $seccion_id;
	}

	public function render()
	{
		$actividades = Actividad::where('desasignatura_docente_seccion_id', $this->id_relacion)->get();
		return view('livewire.docente.secciones.gestionar.actividades.edit', ['actividades' => $actividades]);
	}

	public function updated($nombre)
	{
		if ($nombre == 'actividad_id') {
			$actividads = Actividad::find($this->actividad_id);
			$this->actividad = $actividads->actividad;
			$this->descripcion = $actividads->descripcion;
			$this->porcentaje = $actividads->porcentaje;
		}
	}

	public function update()
	{
		$actividad = Actividad::find($this->actividad_id);
		$porcentaje_old = $actividad->porcentaje;

		$porcentaje = Actividad::where('desasignatura_docente_seccion_id', $this->id_relacion)
			->where('seccion_id', $this->id_seccion)
			->where('desasignatura_id', $this->id_desasignatura)->sum('porcentaje');
		$max_porcentaje = 100 - ($porcentaje - $porcentaje_old);
		// return dd($porcentaje_old);
		$max_porcentaje = ($max_porcentaje > 25) ? 25 : $max_porcentaje;

		$this->validate([
			'actividad' => 'required|min:3',
			'porcentaje' => 'required|numeric|min:1|max:' . $max_porcentaje
		]);

		try {
			DB::beginTransaction();

			foreach ($actividad->Notas as $nota) {
				$porcentaje_nota = ($nota->nota * 100) / $porcentaje_old;

				$nota_nueva = ($this->porcentaje * $porcentaje_nota) / 100;

				$nota->update([
					'nota' => $nota_nueva
				]);
			}

			$actividad->update([
				'actividad' => $this->actividad,
				'descripcion' => $this->descripcion,
				'porcentaje' => $this->porcentaje
			]);
			DB::commit();
			$this->emitTo('recargar_tabla','recargar_tabla');
			$this->emit('recargar_tabla');
			$this->emit('mensajes', 'success', 'Actividad actualizada con exito.');
			$this->reset(['actividad', 'descripcion', 'porcentaje', 'actividad_id']);
			$this->emit('datatables');
			// return redirect()->back();
		} catch (\Throwable $th) {
			DB::rollback();

			session('error', $th->getMessage());
			// return vbak()
		}
	}
}
