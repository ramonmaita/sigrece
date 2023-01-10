<?php

namespace App\Exports;

use App\Models\Alumno;
use App\Models\DesAsignaturaDocenteSeccion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class SeccionEstudiantesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $alumnos;

	public function __construct($alumnos)
    {
		$this->alumnos = $alumnos;
    }

    public function view(): View
    {
        return view('panel.admin.secciones.estudiantes_seccion_export', [
            'alumnos' => Alumno::whereIn('id', $this->alumnos)->get()
        ]);
    }
}
