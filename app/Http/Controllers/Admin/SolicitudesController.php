<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Periodo;
use App\Models\Seccion;
use App\Models\SolicitudCorreccion;
use Illuminate\Http\Request;

class SolicitudesController extends Controller
{
    public function index()
	{
		return view('panel.admin.solicitudes.index');
	}

	public function show(SolicitudCorreccion $solicitud)
    {
		if($solicitud->estatus_admin == 'EN ESPERA'){
			$solicitud->update([
				'estatus_admin' => 'EN REVISION'
			]);
		}
		$periodo = Periodo::where('nombre',$solicitud->periodo)->first();
		$seccion = Seccion::where('nombre',$solicitud->seccion)->where('periodo_id',$periodo->id)->first();
		$relacion = DesAsignaturaDocenteSeccion::where('docente_id',$solicitud->Solicitante->Docente->id)->where('seccion_id',$seccion->id)->where('des_asignatura_id',$solicitud->desasignatura_id)->first();
		return view('panel.admin.solicitudes.show',['solicitud' => $solicitud,'relacion' => $relacion]);
    }
}
