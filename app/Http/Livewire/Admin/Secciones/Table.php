<?php

namespace App\Http\Livewire\Admin\Secciones;

use App\Models\Nucleo;
use App\Models\Periodo;
use App\Models\Pnf;
use App\Models\Seccion;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Table extends LivewireDatatable
{
	public $hideable = 'select';
    public $exportable = true;
    // public $complex = true;
    public function builder()
    {
		$periodo = Periodo::where('estatus',0)->first();
        return Seccion::query()->where('periodo_id',$periodo->id);
    }

    public function columns()
    {
        return [
			Column::name('nombre')
			->label('Sección')
			->searchable(),

			Column::name('turno')
			->label('Turno')
			->filterable(['MAÑANA','TARDE','NOCHE'])
			->searchable(),

			NumberColumn::name('cupos')
			->label('Cupos')
			->searchable(),

			Column::name('pnf.nombre')
			->label('PNF')
			->filterable($this->pnfs->pluck('nombre'))
			->searchable(),

			Column::name('nucleo.nucleo')
			->label('Nucleo')
			->filterable($this->nucleos->pluck('nucleo'))
			->searchable(),

			Column::name('estatus')
			->label('Estatus')
			->filterable(['ACTIVA','INACTIVA'])
			->searchable(),


			Column::callback(['id'], function ($id) {
				return view('panel.admin.secciones.partials.table-botones', ['id' => $id]);
			})->unsortable()
			->label('Acciones')
		];
    }

	public function getNucleosProperty()
    {
        return Nucleo::where('estatus','ACTIVO')->get();
    }
	public function getPnfsProperty()
    {
        return Pnf::where('codigo','>=',40)->get();
    }
}
