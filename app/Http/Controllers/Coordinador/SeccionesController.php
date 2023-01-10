<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\CargaNota;
use App\Models\DesAsignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Docente;
use App\Models\HistoricoNota;
use App\Models\Periodo;
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
		$periodo = Periodo::where('estatus',0)->first();
		$secciones = Seccion::where('estatus', 'ACTIVA')->where('pnf_id', Auth::user()->Coordinador->pnf_id)->where('periodo_id',$periodo->id)->get();

		return view('panel.coordinador.secciones.index', ['secciones' => $secciones]);

		// $docente = Docente::where('cedula',Auth::user()->cedula)->first();
		$secciones = DB::table('desasignatura_docente_seccion')
			->join('des_asignaturas', 'desasignatura_docente_seccion.des_asignatura_id', '=', 'des_asignaturas.id')
			->join('seccions', 'desasignatura_docente_seccion.seccion_id', '=', 'seccions.id')
			->join('nucleos', 'seccions.nucleo_id', '=', 'nucleos.id')
			->join('asignaturas', 'des_asignaturas.asignatura_id', '=', 'asignaturas.id')
			->join('trayectos', 'asignaturas.trayecto_id', '=', 'trayectos.id')
			->select('desasignatura_docente_seccion.*', 'des_asignaturas.asignatura_id', 'seccions.nombre as seccion', 'nucleos.nucleo', 'asignaturas.*', 'trayectos.nombre as trayecto')
			->where('seccions.pnf_id', Auth::user()->Coordinador->pnf_id)
			->where('seccions.estatus', 'ACTIVA')
			->groupBy('seccion_id')
			->groupBy('des_asignaturas.asignatura_id')
			->get();

		// return dd($secciones);
		// $secciones = DesAsignaturaDocenteSeccion::where('docente_id',$docente->id)->groupBy('seccion_id')->groupBy('des_asignatura_id')->get();
		return view('panel.docentes.secciones.gestion.index', ['secciones' => $secciones]);
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
		$periodo = Periodo::where('estatus',0)->first();
		$html = view('panel.admin.secciones.planificacion',['pnf' => $pnf, 'periodo' => $periodo]);

		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A3', 'portrait');
		$dompdf->render();
		$font = $dompdf->getFontMetrics()->get_font("helvetica");
		//ancho alto
		// $dompdf->getCanvas()->page_text(500, 750, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
		return $dompdf->stream('PLANIFICACION ' . $pnf->nombre . '.pdf', array("Attachment" => false));
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
			->where('cod_desasignatura', $relacion->DesAsignatura->codigo)
			->where('cedula_docente', $relacion->Docente->cedula)
			->where('especialidad', $relacion->Seccion->Pnf->codigo)
			->whereIn('estatus', [1, 0])
			->groupBy('cedula_estudiante')
			->orderBy('cedula_estudiante', 'asc')
			->get();
		// return dd($notas);
		$fecha = CargaNota::where('periodo', $seccion->Periodo->nombre)
			->where('cod_desasignatura', $relacion->DesAsignatura->codigo)
			->where('cedula_docente', $relacion->Docente->cedula)
			->where('seccion', $relacion->Seccion->nombre)
			->first();

		$html = view('panel.docentes.secciones.acta_notas', ['estudiantes' => $notas, 'detalles' => $detalles, 'fecha' => $fecha]);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('letter');
		$dompdf->render();
		$font = $dompdf->getFontMetrics()->get_font("helvetica");
		//ancho alto
		$dompdf->getCanvas()->page_text(500, 750, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0, 0, 0));
		return $dompdf->stream($seccion->seccion . '(' . $detalles->DesAsignatura->tri_semestre . ') - ' . $detalles->DesAsignatura->nombre . ' - ' . $detalles->docente . '.pdf', array("Attachment" => false));
		// $pdf = PDF::loadView('panel.docentes.secciones.acta_notas', ['estudiantes' => $notas, 'detalles' => $detalles]);

		// return $pdf->stream();
		// return $pdf->download('invoice.pdf');
	}

	public function lista_esudiantes(Seccion $seccion, DesAsignatura $desasignatura)
	{
		$relacion = DesAsignaturaDocenteSeccion::with('inscritos')->where('des_asignatura_id', $desasignatura->id)->where('seccion_id', $seccion->id)->first();
		return view('panel.coordinador.secciones.listado_estudiantes', ['seccion' => $seccion, 'desasignatura' => $desasignatura, 'relacion' => $relacion]);
	}

	public function configurar($id)
	{
		$seccion  = Seccion::find($id);
		$docentes  = Docente::where('estatus', 'ACTIVO')->get();

		// return $seccion->Docentes;

		return view('panel.coordinador.secciones.configurar', ['seccion' => $seccion, 'docentes' => $docentes]);
	}

	public function guardar_config(Request $request)
	{
		try {
			DB::beginTransaction();
			$seccion = Seccion::find($request->seccion_id);
			if (count($request->asignaturas_ins) > 0) {

				$k = 0;
				$na = array_filter($request->docente_id, "strlen");
				$docentes = array_values($na);
				// return dd($docentes);
				for ($i = 0; $i < count($request->asignaturas_ins); $i++) {
					$asig_anual_ins = Asignatura::find($request->asignaturas_ins[$i]);
					foreach ($asig_anual_ins->DesAsignaturas as $desasignatura) {
						$seccion->DesAsignaturas()->attach(
							$seccion->id,
							[
								'docente_id' => $docentes[$k],
								'des_asignatura_id' => $desasignatura->id,
								'estatus' => 'ACTIVO'
							]
						);
						$k++;
					}
				}

				DB::commit();
				return redirect()->route('panel.coordinador.secciones.index')->with('jet_mensaje', 'Asignaturas agregadas con exito.');
			} else {
				return back()->with('jet_error', 'Debe de seleccionar asignaturas para agregar a la sección.');
			}
		} catch (\Throwable $th) {
			return redirect()->back()->with('jet_error', $th->getMessage());
		}
	}

	public function editar_config($id)
	{
		$seccion  = Seccion::find($id);
		$docentes  = Docente::where('estatus', 'ACTIVO')->get();

		return view('panel.coordinador.secciones.editar', ['seccion' => $seccion, 'docentes' => $docentes]);
	}

	public function actualizar_config(Request $request)
	{
		// return dd($request->asignaturas_ins);
		try {
			DB::beginTransaction();
			$seccion = Seccion::find($request->seccion_id);
			$asignaturas_a_vincular = array();
			$asignaturas_vinculadas = array_keys($seccion->DesAsignaturas->groupBy('asignatura_id')->toArray());
			foreach ($asignaturas_vinculadas as $asignaturas_a_vin) {
				array_push($asignaturas_a_vincular, intval($asignaturas_a_vin));
			}
			$uc_para_borrrar = array_diff($asignaturas_a_vincular, $request->asignaturas_ins);
			if (count($request->asignaturas_ins) > 0) {
				foreach ($request->asignaturas_ins as $key => $uc) {
					$asig_anual_ins = Asignatura::find($uc);
					foreach ($asig_anual_ins->DesAsignaturas as $key => $des_uc) {
						// return dd($request->docente_id[$des_uc->id]);
						DB::table('desasignatura_docente_seccion')
							->updateOrInsert(
								['seccion_id' => $seccion->id, 'des_asignatura_id' => $des_uc->id],
								[
									'docente_id' => $request->docente_id[$des_uc->id], 'estatus' => 'ACTIVO',
									"created_at" =>  \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
								]
							);
					}
				}
				foreach ($uc_para_borrrar as $uc_b) {

					DB::table('desasignatura_docente_seccion')->where('seccion_id', $seccion->id)->whereIn('des_asignatura_id', Asignatura::find($uc_b)->DesAsignaturas->pluck('id'))->update(['docente_id' => 1, 'estatus' => 'INACTIVO']);
				}

				DB::commit();
				return redirect()->route('panel.coordinador.secciones.index')->with('jet_mensaje', 'Asignaturas agregadas con exito.');
			} else {
				return redirect()->back()->with('jet_error', 'Debe de seleccionar asignaturas para agregar a la sección.');
			}
		} catch (\Throwable $th) {

			return redirect()->back()->with('jet_error', $th->getMessage());
		}
	}
}
