<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
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
		$solicitudes = Solicitud::where('solicitante_id',Auth::user()->id)->get();
        return view('panel.docentes.solicitudes.index',['solicitudes' => $solicitudes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.docentes.solicitudes.create');
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
    public function show($id)
    {
        //
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

	public function pdf(Solicitud $solicitud)
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

		$html = view('panel.docentes.solicitudes.pdf', ['solicitud' => $solicitud]);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
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
