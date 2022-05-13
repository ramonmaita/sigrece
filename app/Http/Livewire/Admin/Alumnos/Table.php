<?php

namespace App\Http\Livewire\Admin\Alumnos;

use App\Models\Alumno;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Table extends LivewireDatatable
{
    public function builder()
    {
        return Alumno::query();
    }

    public function columns()
    {
        return [
			Column::name('cedula')
				->label('Cedula')
				->defaultSort('asc')
				->searchable(),

			Column::name('p_nombre')
				->label('P. Nombre')
				->defaultSort('desc')
				->searchable(),

			Column::name('s_nombre')
				->label('S. nombre')
				->defaultSort('desc')
				->searchable(),

			Column::name('p_apellido')
				->label('P. Apellido')
				->defaultSort('desc')
				->searchable(),

			Column::name('s_apellido')
				->label('S. Apellido')
				->defaultSort('desc')
				->searchable(),

			Column::name('pnf.nombre')
				->label('PNF')
				->defaultSort('desc')
				->searchable(),

			Column::callback(['id'], function ($id) {
				return view('panel.admin.estudiantes.partials.table-botones', ['id' => $id]);
			})->unsortable()
		];
    }
}
