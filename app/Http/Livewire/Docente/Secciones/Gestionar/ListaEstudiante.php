<?php

namespace App\Http\Livewire\Docente\Secciones\Gestionar;

use App\Models\DesAsignaturaDocenteSeccion;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Spatie\Permission\Models\Role;

class ListaEstudiante extends LivewireDatatable
{
    public function builder()
    {
		 $relacion = DesAsignaturaDocenteSeccion::with('inscritos')
		->where('des_asignatura_id', $this->params['desasignatura_id'])
		->where('seccion_id',$this->params['seccion_id'])->first();
		return dd( $relacion);
		return DesAsignaturaDocenteSeccion::find($relacion->id);
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->linkTo('job', 4),

			// Column::name('inscritos.inscrito_id')
			// 	->label('a'),

        ];
    }
}
