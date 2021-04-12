<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Inscripcion;
use App\Models\Periodo;
use App\Models\Solicitud;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RetirosController extends Controller
{
    public function index()
	{
		$periodo = Periodo::where('estatus',0)->first();
		$retiros = Solicitud::where('tipo','RETIRO DE UC')->where('periodo',$periodo->nombre)->groupBy(['solicitante_id','estatus','periodo'])->get();
		return view('panel.admin.retiro_uc.index',['retiros' => $retiros]);
	}

	public function create()
	{
		return view('panel.admin.retiro_uc.create');
	}

	public function show(Solicitud $solicitud)
	{
		$alumno = Alumno::find($solicitud->DetalleRetiro->alumno_id);
		$periodo = Periodo::where('estatus',0)->first();
		$retiros = Solicitud::with(['DetalleRetiro' => function ($query) use ($alumno)
		{
			$query->where('alumno_id',$alumno->id);
		}])->where('tipo','RETIRO DE UC')->where('periodo',$periodo->nombre)->get();

		$fechaMin = Carbon::parse($retiros->min('fecha'))->format('Y-m-d');
		$fechaMax =  Carbon::parse($retiros->max('fecha'))->format('Y-m-d');
		$retiros = Inscripcion::onlyTrashed()->whereRaw(
			"(deleted_at >= ? AND deleted_at <= ?)",
			[$fechaMin." 00:00:00", $fechaMax." 23:59:59"]
		  )->where('alumno_id',$alumno->id)->get();
		return view('panel.admin.retiro_uc.show',['solicitud' => $solicitud,'retiros' => $retiros,'alumno' => $alumno]);
	}


}
