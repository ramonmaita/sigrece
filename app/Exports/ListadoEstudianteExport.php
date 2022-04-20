<?php

namespace App\Exports;

use App\Models\DesAsignaturaDocenteSeccion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ListadoEstudianteExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

	protected $seccion_id , $desasignatura_id;

	public function __construct($seccion_id , $desasignatura_id)
    {
		$this->desasignatura_id = $desasignatura_id;
		$this->seccion_id = $seccion_id;
    }

    public function view(): View
    {
        return view('panel.docentes.secciones.gestion.partials.listado_estudiantes_excel', [
            'relacion' => DesAsignaturaDocenteSeccion::with('inscritos')->where('des_asignatura_id', $this->desasignatura_id)->where('seccion_id',$this->seccion_id)->first()
        ]);
    }
}
