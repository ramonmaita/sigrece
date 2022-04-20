<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocentesController extends Controller
{
    public function show(Docente $docente)
	{
		// $docente = Docente::find($docente);
		$periodo = Periodo::where('estatus',0)->first();
		$secciones = DB::table('desasignatura_docente_seccion')
		->join('des_asignaturas','desasignatura_docente_seccion.des_asignatura_id','=','des_asignaturas.id')
		->join('seccions','desasignatura_docente_seccion.seccion_id','=','seccions.id')
		->join('nucleos','seccions.nucleo_id','=','nucleos.id')
		->join('asignaturas','des_asignaturas.asignatura_id','=','asignaturas.id')
		->join('trayectos','asignaturas.trayecto_id','=','trayectos.id')
		->select('desasignatura_docente_seccion.*','des_asignaturas.asignatura_id','seccions.nombre as seccion','nucleos.nucleo','asignaturas.*','trayectos.nombre as trayecto')
		->where('docente_id',$docente->id)
		->where('seccions.periodo_id',$periodo->id)
		->groupBy('seccion_id')
		->groupBy('des_asignaturas.asignatura_id')
		->get();
		return view('panel.admin.docentes.show',['docente' => $docente, 'secciones' => $secciones]);
	}

	public function show_uc(Docente $docente, Seccion $seccion, Asignatura $asignatura)
	{
		$unidades = DesAsignaturaDocenteSeccion::where('seccion_id',$seccion->id)->where('docente_id',$docente->id)->whereIn('des_asignatura_id',$asignatura->DesAsignaturas->pluck('id'))->get();

		return view('panel.admin.docentes.show_uc',['seccion' => $seccion,'unidades' => $unidades, 'docente' => $docente]);
	}
}
