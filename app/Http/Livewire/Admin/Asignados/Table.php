<?php

namespace App\Http\Livewire\Admin\Asignados;

use App\Models\Asignado;
use App\Models\Periodo;
use App\Models\Pnf;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Table extends LivewireDatatable
{
	public $hideable = 'select';

    public function builder()
    {
		$periodo_id = Periodo::where('estatus',0)->first();
		// $periodo_id = Periodo::find(6);
        // return Asignado::query()->where('periodo_id',$periodo_id->id);

		return Asignado::query()
        ->leftJoin('alumnos', 'alumnos.cedula', 'asignados.cedula')
        ->leftJoin('inscritos', 'inscritos.alumno_id', 'alumnos.id')
        ->leftJoin('pnfs', 'pnfs.id', 'alumnos.pnf_id')
		->where('asignados.periodo_id',$periodo_id->id);
        // ->groupBy('users.id');
    }

    public function columns()
    {
        return [
			Column::name('cedula')
				->label('Cedula')
				->defaultSort('asc')
				->searchable(),

			Column::name('nombres')
				->label('Nombres')
				->defaultSort('desc')
				->searchable(),

			Column::name('apellidos')
				->label('Apellidos')
				->defaultSort('desc')
				->searchable(),

			Column::name('sexo')
				->label('Sexo')
				->defaultSort('desc')
				->searchable(),

			Column::name('pnf.nombre')
				->label('PNF Asignado')
				->defaultSort('desc')
				->filterable($this->pnfs->pluck('nombre'))
				->searchable(),

			DateColumn::name('alumnos.created_at')
				->label('Registrado')
				->defaultSort('desc')
				->searchable(),

			DateColumn::name('inscritos.fecha')
				->label('Inscrito')
				->defaultSort('desc')
				->searchable(),

			Column::name('pnfs.nombre')
				->label('PNF Actual')
				->defaultSort('desc')
				->filterable($this->pnfs->pluck('nombre'))
				->searchable()

			// Column::callback(['id'], function ($id) {
			// 	return view('panel.admin.estudiantes.partials.table-botones', ['id' => $id]);
			// })->unsortable()
		];
    }

	public function getPnfsProperty()
    {
        return Pnf::where('codigo','>=',40)->get();
    }
}
