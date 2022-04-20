<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\CargaNota;
use App\Models\DesAsignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\HistoricoNota;
use App\Models\Pnf;
use App\Models\Seccion;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

		$secciones = Seccion::where('estatus','ACTIVA')->where('pnf_id',Auth::user()->Coordinador->pnf_id)->get();

		return view('panel.coordinador.secciones.index',['secciones' => $secciones]);

        // $docente = Docente::where('cedula',Auth::user()->cedula)->first();
		$secciones = DB::table('desasignatura_docente_seccion')
		->join('des_asignaturas','desasignatura_docente_seccion.des_asignatura_id','=','des_asignaturas.id')
		->join('seccions','desasignatura_docente_seccion.seccion_id','=','seccions.id')
		->join('nucleos','seccions.nucleo_id','=','nucleos.id')
		->join('asignaturas','des_asignaturas.asignatura_id','=','asignaturas.id')
		->join('trayectos','asignaturas.trayecto_id','=','trayectos.id')
		->select('desasignatura_docente_seccion.*','des_asignaturas.asignatura_id','seccions.nombre as seccion','nucleos.nucleo','asignaturas.*','trayectos.nombre as trayecto')
		->where('seccions.pnf_id',Auth::user()->Coordinador->pnf_id)
		->where('seccions.estatus','ACTIVA')
		->groupBy('seccion_id')
		->groupBy('des_asignaturas.asignatura_id')
		->get();

		// return dd($secciones);
		// $secciones = DesAsignaturaDocenteSeccion::where('docente_id',$docente->id)->groupBy('seccion_id')->groupBy('des_asignatura_id')->get();
		return view('panel.docentes.secciones.gestion.index',['secciones' => $secciones]);
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
    public function show(Seccion $seccion)
    {
        return view('panel.coordinador.secciones.show', ['seccion' => $seccion]);
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
    public function update(Request $request, $id)
    {
        //
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

	public function planificacion()
	{
		$pnf = Pnf::find(Auth::user()->Coordinador->pnf_id);

		$html = view('panel.admin.secciones.planificacion',['pnf' => $pnf]);

		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A3','portrait');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto
        // $dompdf->getCanvas()->page_text(500, 750, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream('PLANIFICACION '.$pnf->nombre.'.pdf', array("Attachment" => false));
	}

	public function acta($relacion)
	{
		// if($seccion->cedula_docente != Auth::user()->cedula){
		// 	return abort(403);
		// }
		$relacion = DesAsignaturaDocenteSeccion::find($relacion);
		// return dd($relacion);
		$seccion = $relacion->Seccion;
		$detalles = HistoricoNota::where('seccion', $relacion->Seccion->nombre)
		->where('cod_desasignatura', $relacion->DesAsignatura->codigo)
		->where('cedula_docente', $relacion->Docente->cedula)
		->where('periodo', $seccion->Periodo->nombre)
		->first();
		$notas = HistoricoNota::where('seccion', $relacion->Seccion->nombre)
		->where('periodo', $relacion->Seccion->Periodo->nombre)
		->where('cod_desasignatura',$relacion->DesAsignatura->codigo)
		->where('cedula_docente',$relacion->Docente->cedula)
		->where('especialidad', $relacion->Seccion->Pnf->codigo)
		->where('estatus', 1)
		->groupBy('cedula_estudiante')
		->orderBy('cedula_estudiante', 'asc')
		->get();
		// return dd($notas);
		$fecha = CargaNota::where('periodo', $seccion->Periodo->nombre)
			->where('cod_desasignatura',$relacion->DesAsignatura->codigo)
			->where('cedula_docente',$relacion->Docente->cedula)
			->where('seccion',$relacion->Seccion->nombre)
			->first();

		$html = view('panel.docentes.secciones.acta_notas', ['estudiantes' => $notas, 'detalles' => $detalles,'fecha' => $fecha]);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto
        $dompdf->getCanvas()->page_text(500, 750, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream($seccion->seccion.'('.$detalles->DesAsignatura->tri_semestre.') - '.$detalles->DesAsignatura->nombre.' - '.$detalles->docente.'.pdf', array("Attachment" => false));
		// $pdf = PDF::loadView('panel.docentes.secciones.acta_notas', ['estudiantes' => $notas, 'detalles' => $detalles]);

		// return $pdf->stream();
		// return $pdf->download('invoice.pdf');
	}

	public function lista_esudiantes(Seccion $seccion, DesAsignatura $desasignatura)
	{
		$relacion = DesAsignaturaDocenteSeccion::with('inscritos')->where('des_asignatura_id', $desasignatura->id)->where('seccion_id',$seccion->id)->first();
		return view('panel.coordinador.secciones.listado_estudiantes', ['seccion' => $seccion,'desasignatura' => $desasignatura, 'relacion' => $relacion]);
	}
}
