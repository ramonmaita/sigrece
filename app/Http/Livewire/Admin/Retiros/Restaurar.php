<?php

namespace App\Http\Livewire\Admin\Retiros;

use App\Models\Alumno;
use App\Models\Inscripcion;
use App\Models\Inscrito;
use App\Models\Solicitud;
use App\Models\SolicitudDetalle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Restaurar extends Component
{
	protected $listeners = ['resetear','incrementar','disminuir'];
	public $estudiante,$uc_restaurar = [],$estudiante_actual, $contadorRestaurar,$retiros = [],$solicitud , $alumno;

	public function mount($alumno,$solicitud,$retiros)
	{
		$this->estudiante = $alumno->id;
		$this->alumno = $alumno;
		$this->retiros = $retiros;
		$this->solicitud = $solicitud;
	}
    public function render()
    {
        return view('livewire.admin.retiros.restaurar');
    }
	public function resetear()
	{
		$this->reset();
		$this->emit('reset-select');
	}

	public function incrementar()
	{
		$this->contadorRestaurar++;
	}
	public function disminuir()
	{
		$this->contadorRestaurar--;
	}

	public function restaurar()
	{
		$this->validate([
			'estudiante' => 'required|min:0|numeric',
			'uc_restaurar' => 'required|array|min:1',
			'contadorRestaurar' => 'min:1',
		]);

		try {
			DB::beginTransaction();
				$alumno = Alumno::find($this->estudiante);
				$inscrito_id = 0;
				foreach ($this->uc_restaurar as $key => $inscripcion_id) {
					if ($inscripcion_id == true) {
						// echo 'esta se va a retirar <br>';
						$inscripcion = Inscripcion::onlyTrashed()->find($inscripcion_id);
						$inscrito_id = $inscripcion->inscrito_id;
						$soliciutd = Solicitud::where('tipo','RETIRO DE UC')->where('observacion',$inscripcion->id)->first();
						$soliciutd->DetalleRetiro->delete();
						$soliciutd->delete();
						$inscripcion->restore();
					}
				}
				if (!$alumno->InscritoActual()  && $inscrito_id != 0) {
					$inscrito = Inscrito::onlyTrashed()->find($inscrito_id);
					$inscrito->restore();
				}
				DB::commit();
				// dd($this->uc_restaurar);
			session()->flash('mensaje', 'Unidades Curriculares restauradas exitosamente');
			return redirect()->route('panel.retiros.index');

		} catch (\Throwable $th) {
			DB::rollback();
			session()->flash('error', $th->getMessage());
		}
		// dd($this->uc_restaurar);
	}
}
