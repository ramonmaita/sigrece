<?php

namespace App\Http\Livewire\Admin\Eventos;

use App\Models\Evento;
use App\Models\Periodo;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Table extends LivewireDatatable
{
    public function builder()
    {
		$periodo = Periodo::where('estatus',0)->first();
        return Evento::query()->where('periodo_id',$periodo->id);
    }

    public function columns()
    {
		return [
			Column::name('periodo.nombre')
				->label('Periodo')
				->searchable(),

			Column::name('nombre')
				->label('Nombre')
				->searchable(),

			DateColumn::name('inicio')
				->label('inicio')
				->format('d/m/Y h:i A')
				->defaultSort('desc')
				->searchable(),

			DateColumn::name('fin')
				->label('fin')
				->format('d/m/Y h:i A')
				->defaultSort('desc')
				->searchable(),

			Column::name('tipo')
				->label('tipo')
				->searchable(),

			Column::name('aplicar')
				->label('Aplicar')
				->searchable(),

			Column::callback(['id'], function ($id) {
				return view('panel.admin.eventos.partials.table-botones', ['id' => $id]);
			})->unsortable()
		];

    }
}
