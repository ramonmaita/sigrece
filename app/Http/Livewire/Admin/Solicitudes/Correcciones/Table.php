<?php

namespace App\Http\Livewire\Admin\Solicitudes\Correcciones;

use App\Models\SolicitudCorreccion;
use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Table extends LivewireDatatable
{
	public $exportable = true;

    public function builder()
    {
		$solicitudes = SolicitudCorreccion::query();
		if($solicitudes){
			$solicitudes = $solicitudes->where('estatus_jefe','PROCESADO')->whereIn('estatus_admin',['EN ESPERA', 'EN REVISION']);
		}
        return $solicitudes;
		// ->leftJoin('users as user', 'solicitante_id', 'user.id');
    }

    public function columns()
    {
		return [
            // NumberColumn::name('id')
            //     ->label('ID')
            //     ->linkTo('job', 4),
			DateColumn::name('fecha')
				->label('fecha')
				// ->editable(true)
				->defaultSort('desc')
				->searchable(),
			Column::name('seccion')
				->label('seccion')
				// ->editable(true)
				->defaultSort('desc')
				->searchable(),
				// ->filterable(),

            Column::name('desasignatura.nombre')
				->label('UC')
				->searchable(),
			Column::name('desasignatura.tri_semestre')
				->label('TRIMESTE|SEMESTRE|AÑO')
                ->searchable(),
            // Column::name('motivo')
            //     ->label('motivo')
            //     // ->editable(true)
            //     ->defaultSort('desc')
            //     ->searchable(),
            //     // ->filterable(),

			Column::name('solicitante.nombre')
				// ->filterable($this->solicitantes)
                ->label('Nombre Solicitante')
                ->defaultSort('desc')
                ->searchable(),

			Column::name('solicitante.apellido')
				// ->filterable($this->solicitantes)
                ->label('Apellido Solicitante')
                ->defaultSort('desc')
                ->searchable(),

			Column::name('estatus_jefe')
                ->label('estatus pnf')
                // ->editable(true)
                ->defaultSort('desc')
                ->searchable(),

			Column::name('estatus_admin')
                ->label('estatus drcaa')
                // ->editable(true)
                ->defaultSort('desc')
                ->searchable(),

            Column::callback(['id'], function ($id) {
                return view('panel.admin.solicitudes.partials.table-botones', ['id' => $id]);
            })->unsortable()
        ];
    }

}
