<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\CargaNota;
use Illuminate\Http\Request;
use App\Models\HistoricoNota;
use App\Models\DesAsignatura;
use App\Models\Docente;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeccionesController extends Controller
{
    public function index()
    {
    	// $secciones = HistoricoNota::where('periodo','2020')->where('cedula_docente',Auth::user()->cedula)->groupBy('seccion')->groupBy('especialidad')->get();
    	$secciones = HistoricoNota::where('cedula_docente',Auth::user()->cedula)->where('periodo','2020')->groupBy('seccion')->groupBy('cod_desasignatura')->orderBy('cod_desasignatura')->get();
    	return view('panel.docentes.secciones.index',['secciones' => $secciones]);
    }

    public function cargar_notas($seccion, $cod_desasignatura)
    {
    	// $estudiantes = HistoricoNota::where('cedula_docente',Auth::user()->cedula)->where('periodo','2020')->groupBy('seccion')->groupBy('cod_desasignatura')->orderBy('cod_desasignatura')->get();
    	$desAsignatura = DesAsignatura::where('codigo',$cod_desasignatura)->first();
    	$pnf = $desAsignatura->Asignatura->Plan->Pnf->codigo;
    	$asignaturas = HistoricoNota::where('seccion',$seccion)
			->where('periodo','2020')->where('especialidad',$pnf)
			->where('cedula_docente',Auth::user()->cedula)
			->where('cod_desasignatura',$cod_desasignatura)
			->groupBy('cedula_estudiante')
			->orderBy('cedula_estudiante','asc')
			->get();

			// return $asignaturas;
		if(count($asignaturas) <= 0){
			return abort(403);
		}

    	return view('panel.docentes.secciones.cargar_notas',['asignaturas' => $asignaturas,'seccion' => $seccion, 'desAsignatura' => $desAsignatura]);
    }

	public function guardar_nota(Request $request, HistoricoNota $seccion)
	{
		// if(Auth::user()->cedula == 14054813){

		// 	return dd($request);
		// }
		try {
			DB::beginTransaction();
			$nombre_seccion = $seccion->seccion;
			$periodo = $seccion->periodo;
			$especialidad = $seccion->especialidad;
			$ci_docente = $seccion->cedula_docente;
			$docente = Docente::where('cedula',$ci_docente)->first();
			if(!empty($request->notas)){
				foreach ($request->notas as $key => $nota) {
					$nota_guardar = HistoricoNota::where('seccion', $seccion->seccion)
						->where('cedula_estudiante', $request->estudiantes[$key])
						->where('periodo', $seccion->periodo)
						->where('cod_desasignatura',$seccion->cod_desasignatura)
						->where('cedula_docente',$seccion->cedula_docente)
						// ->where('seccion',$nombre_seccion)
						->where('docente',$seccion->docente)
						->where('especialidad',$seccion->especialidad)
						->where('estatus', 1)->update([
						'nota' => ($nota == 0 || !$nota) ? 1 : $nota,
						'observacion' => 'CERRADA',
						'estatus' => 0
					]);
				}
			}else{
				return back()->with('jet_error','Debe de colocar las Calificaciones');
			}

			CargaNota::updateOrCreate(
				// ['departure' => 'Oakland', 'destination' => 'San Diego'],
				['periodo' => $periodo,'seccion' => $nombre_seccion, 'cedula_docente' => $docente->cedula,'docente' => $docente->nombre_completo,'cod_desasignatura' => $seccion->cod_desasignatura,'user_id' => Auth::user()->id],
				['fecha' => Carbon::now()],
			);
			DB::commit();

			return redirect()->route('panel.docente.secciones.index')->with('jet_mensaje', 'Calificaciones Cargadas Exitosamente');

		} catch (\Throwable $th) {
			//throw $th;
			DB::rollback();
			return back()->with('jet_error',$th->getMessage());
		}
	}

	public function acta(HistoricoNota $seccion)
	{
		if($seccion->cedula_docente != Auth::user()->cedula){
			return abort(403);
		}
		$detalles = HistoricoNota::where('seccion', $seccion->seccion)->where('cod_desasignatura', $seccion->cod_desasignatura)->where('cedula_docente', $seccion->cedula_docente)->where('periodo', $seccion->periodo)->first();
		$notas = HistoricoNota::where('seccion', $seccion->seccion)
			->where('periodo', $seccion->periodo)
			->where('cod_desasignatura',$seccion->cod_desasignatura)
			->where('cedula_docente',$seccion->cedula_docente)
			->where('docente',$seccion->docente)
			->where('especialidad',$seccion->especialidad)
			->where('estatus', 0)
			->groupBy('cedula_estudiante')
			->orderBy('cedula_estudiante', 'asc')
			->get();
		$fecha = CargaNota::where('periodo',$seccion->periodo)
			->where('cod_desasignatura',$seccion->cod_desasignatura)
			->where('cedula_docente',$seccion->cedula_docente)
			->where('seccion',$seccion->seccion)
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
}
