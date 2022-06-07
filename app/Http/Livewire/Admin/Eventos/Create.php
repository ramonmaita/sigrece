<?php

namespace App\Http\Livewire\Admin\Eventos;

use App\Models\Evento;
use App\Models\Periodo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function PHPUnit\Framework\isEmpty;

class Create extends Component
{
	public $n_periodo,$nombre,$descripcion,$inicio,$fin,$tipo,$aplicar,$pnf,$evento,$id_periodo,$aplicable,$usuarios=[];

	public function mount()
	{
		$p = Periodo::where('estatus',0)->orderBy('id','ASC')->first();
		$this->n_periodo = $p->nombre;
		$this->id_periodo = $p->id;
		$this->usuarios = User::all();
	}
    public function render()
    {
		// if($this->tipo == 'SOLICITUD DE CORRECCION' && $this->aplicar == 'ESPECIFICO'){
		// 	$this->emit('select2');
		// }
        return view('livewire.admin.eventos.create');
    }

	public function store()
	{
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
			if($this->tipo == 'SOLICITUD DE CORRECCION' && $this->aplicar == 'ESPECIFICO' || $this->tipo == 'CARGA DE CALIFICACIONES' && $this->aplicar == 'ESPECIFICO'){
				$aplicable = json_encode(['USUARIO',$this->aplicable]);
			}else{
				$aplicable = null;
			}
			DB::beginTransaction();
				Evento::create([
					'periodo_id' => $this->id_periodo,
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
			Session()->flash('mensaje','Evento registrado exitosamente.');
			$this->emit('mensajes','success','Evento registrado exitosamente.');

			$this->emit('cerrar_modal','#exampleModal');
			$this->emit('refreshLivewireDatatable');
			$this->reset(['evento','nombre','descripcion','inicio','fin','tipo','aplicar','pnf']);
		} catch (\Throwable $th) {
			DB::rollback();
			Session()->flash('error',$th->getMessage());
			$this->emit('mensajes','error',$th->getMessage());
		}
	}
}
