<?php

namespace App\Http\Livewire\Admin\Alumnos\Periodos;

use App\Models\Alumno;
use App\Models\HistoricoNota;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Corregir extends Component
{
	public $alumno,$ucAnual,$ucs = [],$uc_historico = [], $periodo_uc=[], $ucPeriodoNuevo = [],$ucActual;

	public function mount(Alumno $alumno)
	{
		$this->alumno = $alumno;
		$this->uc_historico = $alumno->Plan->Asignaturas;
	}
    public function render()
    {
		if (!empty($this->ucAnual)) {
			if ($this->ucActual != $this->ucAnual) {
				$this->reset(['ucPeriodoNuevo','periodo_uc']);
			}
			$this->ucs = HistoricoNota::where('cedula_estudiante',$this->alumno->cedula)
									->where('cod_asignatura',$this->ucAnual)->get();
			$this->periodo_uc = HistoricoNota::where('cedula_estudiante',$this->alumno->cedula)
									->where('cod_asignatura',$this->ucAnual)->groupByRaw('nro_periodo, periodo')->get();
			$this->ucActual = $this->ucAnual;
		}
		// else{
		// 	$this->reset(['ucs','ucAnual']);
		// }
        return view('livewire.admin.alumnos.periodos.corregir');
    }

	public function update()
	{
		$this->validate([
			'alumno' => 'required',
			'ucAnual' => 'required',
			'ucPeriodoNuevo' => 'array|min:1',
			// 'ucPeriodoNuevo.*' => 'required'
		],[

		],[
			'ucPeriodoNuevo' => 'nuevo periodo'
		]);

		try {
			DB::beginTransaction();

				foreach($this->ucPeriodoNuevo as $aModificar => $valorNuevo){
					if ($valorNuevo != '') {
						$periodo_nuevo = HistoricoNota::find($valorNuevo);
						HistoricoNota::find($aModificar)->update([
							'nro_periodo' => $periodo_nuevo->nro_periodo,
							'periodo' => $periodo_nuevo->periodo,
						]);
					}
				}
			DB::commit();
			session()->flash('mensaje','Opereación relaizada exitosamente.');
		} catch (\Throwable $th) {
			session()->flash('error',$th->getMessage());
		}
		// dd($this->ucPeriodoNuevo);
	}

	public function borrar($id_borrar)
	{

		try {
			DB::beginTransaction();

			$periodo_nuevo = HistoricoNota::find($id_borrar)->delete();
			DB::commit();
			session()->flash('mensaje','Opereación relaizada exitosamente.');
		} catch (\Throwable $th) {
			session()->flash('error',$th->getMessage());
		}
		// dd($this->ucPeriodoNuevo);
	}
}
