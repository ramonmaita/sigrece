<?php

namespace App\Http\Controllers\Docente;

use App\Exports\ListadoEstudianteExport;
use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Asignatura;
use App\Models\CargaNota;
use Illuminate\Http\Request;
use App\Models\HistoricoNota;
use App\Models\DesAsignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Docente;
use App\Models\Periodo;
use App\Models\Seccion;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class SeccionesController extends Controller
{
    public function index()
    {
		$periodo = Periodo::where('estatus',0)->first();
		$docente = Docente::where('cedula',Auth::user()->cedula)->first();
		$secciones = DB::table('desasignatura_docente_seccion')
		->join('des_asignaturas','desasignatura_docente_seccion.des_asignatura_id','=','des_asignaturas.id')
		->join('seccions','desasignatura_docente_seccion.seccion_id','=','seccions.id')
		->join('nucleos','seccions.nucleo_id','=','nucleos.id')
		->join('asignaturas','des_asignaturas.asignatura_id','=','asignaturas.id')
		->join('trayectos','asignaturas.trayecto_id','=','trayectos.id')
		->select('desasignatura_docente_seccion.*','des_asignaturas.asignatura_id','seccions.nombre as seccion','nucleos.nucleo','asignaturas.*','trayectos.nombre as trayecto')
		->where('docente_id',$docente->id)
		->where('seccions.periodo_id',$periodo->id)
		->where('seccions.estatus','ACTIVA')
		->groupBy('seccion_id')
		->groupBy('des_asignaturas.asignatura_id')
		->get();

		// return dd($secciones);
		// $secciones = DesAsignaturaDocenteSeccion::where('docente_id',$docente->id)->groupBy('seccion_id')->groupBy('des_asignatura_id')->get();
		return view('panel.docentes.secciones.gestion.index',['secciones' => $secciones]);


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

	public function show_seccion(Asignatura $asignatura, Seccion $seccion)
	{
		$docente = Docente::where('cedula',Auth::user()->cedula)->first();
		// return dd($asignatura->DesAsignaturas->pluck('id'));
		$unidades = DesAsignaturaDocenteSeccion::where('seccion_id',$seccion->id)->where('docente_id',$docente->id)->whereIn('des_asignatura_id',$asignatura->DesAsignaturas->pluck('id'))->get();

		return view('panel.docentes.secciones.gestion.show',['seccion' => $seccion,'unidades' => $unidades]);

	}

	public function lista_esudiantes(Seccion $seccion, DesAsignatura $desasignatura)
	{
		$relacion = DesAsignaturaDocenteSeccion::with('inscritos')->where('des_asignatura_id', $desasignatura->id)->where('seccion_id',$seccion->id)->first();

		$nombre_archivo = "T-".$desasignatura->Asignatura->Trayecto->nombre." - ".$desasignatura->Asignatura->nombre." (".$desasignatura->nombre.") ".$desasignatura->Asignatura->Plan->cohorte." - ".$desasignatura->tri_semestre;
		return Excel::download(new ListadoEstudianteExport($relacion->seccion_id, $relacion->des_asignatura_id), "$nombre_archivo.xlsx");

		Excel::create("$seccion->nombre", function($excel) {

			$excel->sheet('LISTADO', function($sheet,$relacion) {

				$sheet->loadView('panel.docente.secciones.gestion.partials.listado_estudiantes_excel')->with('relacion',$relacion);

			});

		})->download('xls');
		return view('panel.admin.secciones.lista_estudiantes_uc', ['seccion' => $seccion,'desasignatura' => $desasignatura, 'relacion' => $relacion]);
	}

	public function avance_notas($relacion)
	{
		ini_set('max_execution_time', 6200);
		// if($seccion->cedula_docente != Auth::user()->cedula){
		// 	return abort(403);
		// }
		$relacion = DesAsignaturaDocenteSeccion::where('id',$relacion)->with('inscritos')->first();

		$actividades = Actividad::with('notas')->where('desasignatura_docente_seccion_id',$relacion->id)->get();
		$nota = [];
		foreach ($actividades as $key => $actividad) {
			foreach ($actividad->Notas as $key => $notas) {
				// $data = [
				// 	$notas->actividad_id => $notas->nota
				// ];
				// array_push($this->nota,$data);
				// array_push()
				// $data  = array($notas->actividad_id => $notas->nota);
				// array_push($this->nota[$notas->alumno_id][],$data);
				$nota[$notas->alumno_id][$notas->actividad_id]  = $notas->nota ;
			}
		}

		$html = view('panel.docentes.secciones.gestion.avance_notas', ['nota' => $nota, 'actividades' => $actividades, 'relacion' => $relacion]);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter','landscape');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto
        $dompdf->getCanvas()->page_text(700, 580, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream('AVANCE DE NOTAS.pdf', array("Attachment" => false));
        // return $dompdf->stream(@$relacion->first()->Seccion->seccion.'('.@$relacion->first()->DesAsignatura->tri_semestre.') - '.@$relacion->first()->DesAsignatura->nombre.' - '.@$relacion->first()->Docente->nombres.' '.@$relacion->first()->Docente->apellidos.'.pdf', array("Attachment" => false));
		// $pdf = PDF::loadView('panel.docentes.secciones.acta_notas', ['estudiantes' => $notas, 'detalles' => $detalles]);

		// return $pdf->stream();
		// return $pdf->download('invoice.pdf');
	}

	public function actanueva(DesAsignaturaDocenteSeccion $relacion)
	{
		ini_set('max_execution_time', 4200);
		// if($seccion->cedula_docente != Auth::user()->cedula){
		// 	return abort(403);
		// }
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
		->whereIn('estatus', [1,0])
		->groupBy('cedula_estudiante')
		->orderBy('cedula_estudiante', 'asc')
		->get();
		// return dd($notas);
		$fecha = CargaNota::where('periodo', $seccion->Periodo->nombre)
			->where('cod_desasignatura',$relacion->DesAsignatura->codigo)
			// ->where('cedula_docente',$relacion->Docente->cedula)
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
}
