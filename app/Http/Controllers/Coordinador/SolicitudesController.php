<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Periodo;
use App\Models\Seccion;
use App\Models\SolicitudCorreccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$solicitudes = SolicitudCorreccion::where('jefe_id', Auth::user()->Coordinador->user_id)->get();
		
        return view('panel.coordinador.solicitudes.index',['solicitudes' => $solicitudes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SolicitudCorreccion $solicitud)
    {
		if($solicitud->estatus_jefe == 'EN ESPERA'){
			$solicitud->update([
				'estatus_jefe' => 'EN REVISION'
			]);
		}
		$periodo = Periodo::where('nombre',$solicitud->periodo)->first();
		$seccion = Seccion::where('nombre',$solicitud->seccion)->where('periodo_id',$periodo->id)->first();
		$relacion = DesAsignaturaDocenteSeccion::where('docente_id',$solicitud->Solicitante->Docente->id)->where('seccion_id',$seccion->id)->where('des_asignatura_id',$solicitud->desasignatura_id)->first();
		return view('panel.coordinador.solicitudes.show',['solicitud' => $solicitud,'relacion' => $relacion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        SolicitudCorreccion::find($request->solicitud_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
