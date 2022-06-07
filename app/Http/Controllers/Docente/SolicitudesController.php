<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Evento;
use App\Models\Periodo;
use App\Models\Seccion;
use App\Models\Solicitud;
use App\Models\SolicitudCorreccion;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
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
		$solicitudes = SolicitudCorreccion::where('solicitante_id',Auth::user()->id)->get();
        return view('panel.docentes.solicitudes.index',['solicitudes' => $solicitudes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$actual = Carbon::now()->toDateTimeString();
		$cerrado = true;
		$evento_solicitud_correccion = Evento::where('tipo','SOLICITUD DE CORRECCION')
		->where('evento_padre',0)
		->where('inicio','<=',$actual)
		->where('fin','>=',$actual)
		->orderBy('id','desc')
		->first();
		if($evento_solicitud_correccion){
			$aplicable = json_decode($evento_solicitud_correccion->aplicable);
			if ($evento_solicitud_correccion->aplicar == 'TODOS') {
				$cerrado = false;
			}elseif ($evento_solicitud_correccion->aplicar == 'ESPECIFICO' && array_search(Auth::user()->cedula,$aplicable[1]) !== false) {
				$cerrado = false;
			}
		}

		if($cerrado == false){
			return view('panel.docentes.solicitudes.create');
		}else{
			return abort(404);
		}
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
		$periodo = Periodo::where('nombre',$solicitud->periodo)->first();
		$seccion = Seccion::where('nombre',$solicitud->seccion)->where('periodo_id',$periodo->id)->first();
		$relacion = DesAsignaturaDocenteSeccion::where('docente_id',$solicitud->Solicitante->Docente->id)->where('seccion_id',$seccion->id)->where('des_asignatura_id',$solicitud->desasignatura_id)->first();
		return view('panel.docentes.solicitudes.show',['solicitud' => $solicitud,'relacion' => $relacion]);
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

	public function pdf(SolicitudCorreccion $solicitud)
	{
		// if($seccion->cedula_docente != Auth::user()->cedula){
		// 	return abort(403);
		// }
		// $detalles = HistoricoNota::where('seccion', $seccion->seccion)->where('cod_desasignatura', $seccion->cod_desasignatura)->where('cedula_docente', $seccion->cedula_docente)->where('periodo', $seccion->periodo)->first();
		// $notas = HistoricoNota::where('seccion', $seccion->seccion)
		// 	->where('periodo', $seccion->periodo)
		// 	->where('cod_desasignatura',$seccion->cod_desasignatura)
		// 	->where('cedula_docente',$seccion->cedula_docente)
		// 	->where('docente',$seccion->docente)
		// 	->where('especialidad',$seccion->especialidad)
		// 	->where('estatus', 0)
		// 	->groupBy('cedula_estudiante')
		// 	->orderBy('cedula_estudiante', 'asc')
		// 	->get();
		// $fecha = CargaNota::where('periodo',$seccion->periodo)
		// 	->where('cod_desasignatura',$seccion->cod_desasignatura)
		// 	->where('cedula_docente',$seccion->cedula_docente)
		// 	->where('seccion',$seccion->seccion)
		// 	->first();
		$periodo = Periodo::where('nombre',$solicitud->periodo)->first();
		$seccion = Seccion::where('nombre',$solicitud->seccion)->where('periodo_id',$periodo->id)->first();
		$usuario = User::find($solicitud->solicitante_id);
		$relacion = DesAsignaturaDocenteSeccion::where('docente_id',$usuario->Docente->id)->where('seccion_id',$seccion->id)->where('des_asignatura_id',$solicitud->desasignatura_id)->first();
		$html = view('panel.docentes.solicitudes.pdf', ['solicitud' => $solicitud,'relacion' => $relacion]);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter','landscape');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto
        $dompdf->getCanvas()->page_text(500, 750, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream("SOLICITUD DE $solicitud->tipo N $solicitud->id.pdf", array("Attachment" => false));
		// $pdf = PDF::loadView('panel.docentes.secciones.acta_notas', ['estudiantes' => $notas, 'detalles' => $detalles]);

		// return $pdf->stream();
		// return $pdf->download('invoice.pdf');
	}
}
