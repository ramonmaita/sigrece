<?php

namespace App\Http\Livewire\Admin\Becas;

use App\Models\Beca;
use App\Models\Alumno;
use App\Models\Periodo;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Table extends LivewireDatatable
{
	public $exportable = true;

    public function builder()
    {

		$periodo = Periodo::where('estatus', 0)->first();
        $data = Beca::query()->join('alumnos',  'becas.alumno_id', 'alumnos.id')
			->leftJoin('inscritos', 'inscritos.alumno_id', 'alumnos.id')
			->leftJoin('periodos', function ($join) use ($periodo) {
				$join->on('periodos.id', 'inscritos.periodo_id')
					->where('inscritos.periodo_id', $periodo->id);
			});

		return $data;
    }

    public function columns()
    {

        return [
			Column::name('alumno.cedula')
				->label('Cedula')
				->defaultSort('asc')
				->searchable(),

			Column::name('alumno.p_nombre')
				->label('P. Nombre')
				->defaultSort('desc')
				->searchable(),

			Column::name('alumno.s_nombre')
				->label('S. nombre')
				->defaultSort('desc')
				->searchable(),

			Column::name('alumno.p_apellido')
				->label('P. Apellido')
				->defaultSort('desc')
				->searchable(),

			Column::name('alumno.s_apellido')
				->label('S. Apellido')
				->defaultSort('desc')
				->searchable(),

			Column::name('alumno.pnf.nombre')
				->label('PNF')
				->defaultSort('desc')
				->searchable(),

			BooleanColumn::name('periodos.id')
				->label('Estatus')
				->defaultSort('desc')
				->exportCallback(fn ($id) =>
					$id ? 'ACTIVO' : 'INACTIVO'
				)
				->filterable(),

			Column::name('tipo')
				->label('Beca')
				->defaultSort('desc')
				->searchable()
				->filterable(['ESTUDIO', 'AYUDANTIA', 'PREPARADURIA']),

			Column::callback(['id'], function ($id) {
				return view('panel.admin.becas.partials.table-botones', ['id' => $id]);
			})->unsortable()
		];
    }
}
