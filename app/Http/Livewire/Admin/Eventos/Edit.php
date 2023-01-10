<?php

namespace App\Http\Livewire\Admin\Eventos;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function PHPUnit\Framework\isEmpty;

class Edit extends Component
{
	protected $listeners = ['ShowModalEdit'];

	public $n_periodo,$nombre,$descripcion,$inicio,$fin,$tipo,$aplicar,$pnf,$evento,$id_periodo, $evento_id,$aplicable=[];

	public function mount()
	{
		$this->usuarios = User::all();
	}
    public function render()
    {
        return view('livewire.admin.eventos.edit');
    }

	public function ShowModalEdit($id_evento)
    {
        $this->evento_id = $id_evento;
        $evento = Evento::find($id_evento);
		$this->n_periodo = $evento->Periodo->nombre;
        $this->periodo_id = $evento->periodo_id;
        $this->nombre = $evento->nombre;
        $this->descripcion = $evento->descripcion;
		$this->inicio = strftime('%Y-%m-%dT%H:%M:%S', strtotime($evento->inicio));
		$this->fin = strftime('%Y-%m-%dT%H:%M:%S', strtotime($evento->fin));
		$this->tipo = $evento->tipo;
		$this->aplicar = $evento->aplicar;
		if(!empty($evento->aplicable)){
			$a = json_decode($evento->aplicable);
			// return dd($a[1]);
			$this->aplicable = $a[1];
		}else{
			$this->reset('aplicable');
		}
		$this->emit('cargar_select',$this->aplicable);
        $this->emit('abrir_modal','#modal-edit-evento');
    }

	public function store()
	{
		// return dd($this->aplicable);
		$this->validate(
			[
				'nombre' => 'required|string|min:5|max:255',
				'descripcion' => 'required|string|min:5|max:255',
				'inicio' => 'required',
				'fin' => 'required',
				'tipo' => 'required',
				'aplicar' => 'required',
			]
		);

		try {
			if($this->tipo == 'SOLICITUD DE CORRECCION' && $this->aplicar == 'ESPECIFICO' || $this->tipo == 'CARGA DE CALIFICACIONES' && $this->aplicar == 'ESPECIFICO' || $this->tipo == 'ASIGNAR DOCENTES' && $this->aplicar == 'ESPECIFICO'){
				$aplicable = json_encode(['USUARIO',$this->aplicable]);
			}else{
				$aplicable = null;
			}
			DB::beginTransaction();
				Evento::find($this->evento_id)->update([
					// 'periodo_id' => $this->id_periodo,
					'evento_padre' => isEmpty($this->evento) ? 0 : $this->evento,
					'nombre' => $this->nombre,
					'descripcion' => $this->descripcion,
					'inicio' => $this->inicio,
					'fin' => $this->fin,
					'tipo' => $this->tipo,
					'aplicar' => $this->aplicar,
					'aplicable' => (!empty($this->aplicable)) ? $aplicable : null
				]);
			DB::commit();
			Session()->flash('mensaje','Evento actualizando exitosamente.');
			$this->emit('mensajes','success','Evento actualizando exitosamente.');

			$this->emit('cerrar_modal','#modal-edit-evento');
			$this->emit('refreshLivewireDatatable');
			$this->reset(['evento','nombre','descripcion','inicio','fin','tipo','aplicar','pnf']);
		} catch (\Throwable $th) {
			DB::rollback();
			Session()->flash('error',$th->getMessage());
			$this->emit('mensajes','error',$th->getMessage());
		}
	}
}
