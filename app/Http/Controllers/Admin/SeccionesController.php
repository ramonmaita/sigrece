<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SeccionEstudiantesExport;
use App\Http\Controllers\Controller;
use App\Models\Alumno;
use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Docente;
use App\Models\Asignatura;
use App\Models\CargaNota;
use App\Models\DesAsignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\HistoricoNota;
use App\Models\Inscripcion;
use App\Models\Periodo;
use App\Models\Pnf;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class SeccionesController extends Controller
{
	public function ver_seccion(Seccion $seccion)
	{
		$ucs = DesAsignaturaDocenteSeccion::where('seccion_id',$seccion->id)->pluck('id');
		$total = Inscripcion::whereIn('desasignatura_docente_seccion_id',$ucs)->groupBy('alumno_id')->get();
		$id_estudiantes = Inscripcion::whereIn('desasignatura_docente_seccion_id',$ucs)->groupBy('alumno_id')->pluck('alumno_id');
		$alumnos = Alumno::whereIn('id',$id_estudiantes)->get();
		// $total = DesAsignaturaDocenteSeccion::with(['inscritos' => function ($query)
		// {
		// 	$query->groupBy('alumno_id');
		// }])->where('seccion_id',$seccion->id)->get();
		$estudiantes = count($total);
		// dd($total);
		return view('panel.admin.secciones.show', ['seccion' => $seccion, 'estudiantes' => $estudiantes]);
	}
	public function estudiantes_seccion(Seccion $seccion)
	{
		$ucs = DesAsignaturaDocenteSeccion::where('seccion_id',$seccion->id)->pluck('id');
		$id_estudiantes = Inscripcion::whereIn('desasignatura_docente_seccion_id',$ucs)->groupBy('alumno_id')->pluck('alumno_id');
		$alumnos = $id_estudiantes;
		// $alumnos = Alumno::whereIn('id',$id_estudiantes)->get();

		$nombre_archivo = $seccion->nombre;
		return Excel::download(new SeccionEstudiantesExport($alumnos), "$nombre_archivo.xlsx");
		return dd($alumnos);
	}
	public function lista_esudiantes(Seccion $seccion, DesAsignatura $desasignatura)
	{
		$relacion = DesAsignaturaDocenteSeccion::with('inscritos')->where('des_asignatura_id', $desasignatura->id)->where('seccion_id',$seccion->id)->first();
		return view('panel.admin.secciones.lista_estudiantes_uc', ['seccion' => $seccion,'desasignatura' => $desasignatura, 'relacion' => $relacion]);
	}
	public function configurar($id)
	{
		$seccion  = Seccion::find($id);
		$docentes  = Docente::where('estatus', 'ACTIVO')->get();

		// return $seccion->Docentes;

		return view('panel.admin.secciones.configurar', ['seccion' => $seccion, 'docentes' => $docentes]);
	}

	public function guardar_config(Request $request)
	{
		// return dd($request);
		$seccion = Seccion::find($request->seccion_id);
		if (count($request->asignaturas_ins) > 0) {

			$k = 0;
			$na = array_filter($request->docente_id, "strlen");
			$docentes = array_values($na);
			// return dd($docentes);
			for ($i = 0; $i < count($request->asignaturas_ins); $i++) {
				$asig_anual_ins = Asignatura::find($request->asignaturas_ins[$i]);
				foreach ($asig_anual_ins->DesAsignaturas as $desasignatura) {
					// $relacion = new ReSeccAsigDoc;
					// $relacion->seccion_id = $request->seccion_id;
					// $relacion->cod_asig = $desasignatura->codigo;
					// if ($docentes[$k] == 0) {
					//     echo "$desasignatura->codigo - $docentes[$k] SIN ASIGNAR  <br>";
					//     // $relacion->docente_id = $docentes[$k];
					// }else{

					//     $docente = Docente::find($docentes[$k]);
					//     // $docente = $request->docente_id[$k];
					//     // $relacion->docente_id = $docente->cedula;
					//     echo "$docentes[$k] - $desasignatura->codigo - $docente->nombres $docente->apellidos  <br>";
					// }

					// DB::table('desasignatura_docente_seccion')->insert([
					// 	'des_asignatura_id' => $desasignatura->id,
					// 	'docente_id' => $docentes[$k],
					// 	'seccion_id' => $seccion->id,
					// ]);
					$seccion->DesAsignaturas()->attach(
						$seccion->id,
						[
							'docente_id' => $docentes[$k],
							'des_asignatura_id' => $desasignatura->id,
							'estatus' => 'ACTIVO'
						]
					);
					$k++;
					// $relacion->save();

				}
			}

			return redirect('panel/secciones')->with('mensaje', 'Asignaturas agregadas con exito.');
		} else {
			return back()->with('m_error', 'Debe de seleccionar asignaturas para agregar a la sección.');
		}
	}

	public function editar_config($id)
	{
		// SIGERACA
		// return DesAsignaturaDocenteSeccion::all();
		$seccion  = Seccion::find($id);
		$docentes  = Docente::where('estatus', 'ACTIVO')->get();

		// return $seccion->Docentes;

		return view('panel.admin.secciones.editar', ['seccion' => $seccion, 'docentes' => $docentes]);
	}

	public function actualizar_config(Request $request)
	{
		// return dd($request->docente_id);
		$seccion = Seccion::find($request->seccion_id);

		// return dd($request->asignaturas_ins);
		$asignaturas_a_vincular = array();
		$asignaturas_vinculadas = array_keys($seccion->DesAsignaturas->groupBy('asignatura_id')->toArray());
		foreach ($asignaturas_vinculadas as $asignaturas_a_vin) {
			array_push($asignaturas_a_vincular, intval($asignaturas_a_vin));
		}
		// echo "--- DOCENTE -- <br>";
		// print_r($request->docente_id);
		// echo "<br> - - - - -  <br>";
		// echo "--- LAS QUE YA ESTAN REGISTRADAS -- <br>";
		// print_r($asignaturas_vinculadas);
		// echo "<br> - - - - -  <br>";
		// echo "--- LAS ENVIADAS POR EL FORMULARIO -- <br>";
		// print_r($request->asignaturas_ins);
		// echo "<br> - - - - -  <br>";
		// return $asignaturas_vinculadas;
		// return $asignaturas_a_vincular;
		// $r = array_intersect($request->asignaturas_ins, $asignaturas_a_vincular);
		// echo "--- LAS QUE VAN A PERMANECER -- <br>";
		// print_r($r);
		// echo "<br> - - - - -  <br>";

		// echo "--- LAS QUE SE VAN AÑADIR -- <br>";
		// print_r(array_diff($request->asignaturas_ins, $asignaturas_a_vincular));
		// echo "<br> - - - - -  <br>";


		// echo "--- LAS QUE SE VAN BORRAR -- <br>";
		$uc_para_borrrar = array_diff($asignaturas_a_vincular, $request->asignaturas_ins);
		// print_r(array_diff($asignaturas_a_vincular, $request->asignaturas_ins ));
		if (count($request->asignaturas_ins) > 0) {
			foreach ($request->asignaturas_ins as $key => $uc) {
				$asig_anual_ins = Asignatura::find($uc);
				foreach ($asig_anual_ins->DesAsignaturas as $key => $des_uc) {
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

			return redirect('panel/secciones')->with('mensaje', 'Asignaturas agregadas con exito.');
		} else {
			return back()->with('m_error', 'Debe de seleccionar asignaturas para agregar a la sección.');
		}
	}

	public function secciones_activas()
	{
		$periodo = 2020;
		$secciones = HistoricoNota::where('periodo', $periodo)->where('estatus', '1')->groupBy('seccion')->get();
		return view('panel.admin.secciones.lista', ['secciones' => $secciones]);
	}

	public function show($periodo, $seccion, $pnf)
	{
		$seccion = HistoricoNota::where('seccion', $seccion)->where('periodo', $periodo)->groupBy('cod_desasignatura')->get();
		return view('panel.admin.secciones.uc', ['seccion' =>  $seccion]);
	}

	public function asignar_docente($periodo, $seccion, $pnf,$desasignatura)
	{
		$seccion = HistoricoNota::where('seccion', $seccion)->where('periodo', $periodo)->where('estatus', '1')->where('cod_desasignatura',$desasignatura)->groupBy('cod_desasignatura')->first();
		return view('panel.admin.secciones.asignar_docente', ['seccion' => $seccion, 'docentes' => Docente::all()]);
	}

	public function asignar(Request $request, HistoricoNota $seccion)
	{
		try {
			DB::beginTransaction();
			$docente = Docente::find($request->docente_id);
			$periodo = $seccion->periodo;
			$nombre_seccion = $seccion->seccion;
			$especialidad = $seccion->especialidad;
			$seccion = HistoricoNota::where('seccion', $seccion->seccion)
				->where('periodo', $periodo)
				->where('cod_desasignatura',$seccion->cod_desasignatura)
				->where('estatus', '1')
				->update(['cedula_docente' => $docente->cedula, 'docente' => $docente->nombre_completo]);

			DB::commit();
			return redirect()->route('panel.secciones.ver-uc', [
				'periodo' => $periodo,
				'seccion' => $nombre_seccion,
				'pnf' => $especialidad
			])
			->with('mensaje', 'Docente Asignado Exitosamente');

		} catch (\Exception $e) {
			DB::rollBack();
			return back()->with('error', $e->getMessage());
		}
	}

	public function listado_estudiantes(HistoricoNota $seccion)
	{
		$seccion = HistoricoNota::where('seccion', $seccion->seccion)
				->where('periodo', $seccion->periodo)
				->where('cod_desasignatura',$seccion->cod_desasignatura)
				->where('estatus', '1')->get();

		return view('panel.admin.secciones.listado_estudiantes',['seccion' =>  $seccion]);
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
		->whereIn('estatus', [0,1])
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

	public function planificacion($id)
	{
		$pnf = Pnf::find($id);
		$periodo = Periodo::where('estatus',0)->first();
		$html = view('panel.admin.secciones.planificacion',['pnf' => $pnf, 'periodo' => $periodo]);

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

	public function abrir($id_relacion)
	{

		try {
			DB::beginTransaction();
			$relacion = DesAsignaturaDocenteSeccion::where('id',$id_relacion)->with('inscritos')->first();
			// return dd($relacion);
			// $relacion = DesAsignaturaDocenteSeccion::with('inscritos')
			// ->where('des_asignatura_id', $this->desasignatura_id)
			// ->where('seccion_id',$this->seccion_id)->first();

			// $desasignatura = DesAsignatura::find($this->desasignatura_id);
			// $seccion = Seccion::find($this->seccion_id);
			// return dd($relacion->Actividades);

			foreach ($relacion->Actividades as  $actividad) {
				$actividad->Notas()->update([
					'estatus' => 'CARGADO'
				]);
			}
			$cargada = CargaNota::where('periodo',$relacion->Seccion->Periodo->nombre)
			->where('seccion',$relacion->Seccion->nombre)
			->where('cedula_docente',$relacion->Docente->cedula)
			->where('cod_desasignatura',$relacion->DesAsignatura->codigo)
			->first();

			$cargada->delete();
			// CargaNota::updateOrCreate(
			// 	// ['departure' => 'Oakland', 'destination' => 'San Diego'],
			// 	[
			// 		'periodo' => $relacion->Seccion->Periodo->nombre,
			// 		'seccion' => $relacion->Seccion->nombre,
			// 		'cedula_docente' => $relacion->Docente->cedula,
			// 		'docente' => $relacion->Docente->nombre_completo,
			// 		'cod_desasignatura' => $relacion->DesAsignatura->codigo,
			// 		'user_id' => Auth::user()->id],
			// 	['fecha' => Carbon::now()],
			// );



			DB::commit();
			return redirect()->back()->with('mensaje', 'Sección aperturada Exitosamente');
		} catch (\Throwable $th) {
			DB::rollback();
			return back()->with('error', $th->getMessage());
			// return vbak()
		}
	}

	public function cerrar_carga($id)
	{
		$periodo = Periodo::where('estatus',0)->first();
		$pnf = Pnf::find($id);
		$secciones = $pnf->Secciones->where('estatus','ACTIVA')->where('periodo_id',$periodo->id);
		return view('panel.admin.secciones.cerrar_carga',['pnf' => $pnf,'secciones' => $secciones]);
	}

	public function cerrar($id_relacion)
	{

		try {
			DB::beginTransaction();
			$relacion = DesAsignaturaDocenteSeccion::where('id',$id_relacion)->with('inscritos')->first();
			// return dd($relacion);
			// $relacion = DesAsignaturaDocenteSeccion::with('inscritos')
			// ->where('des_asignatura_id', $this->desasignatura_id)
			// ->where('seccion_id',$this->seccion_id)->first();

			// $desasignatura = DesAsignatura::find($this->desasignatura_id);
			// $seccion = Seccion::find($this->seccion_id);
			// return dd($relacion->Actividades);
			foreach($relacion->Inscritos as $inscritos){
				$nota = $inscritos->Alumno->Escala($inscritos->Alumno->NotasActividades($relacion->Actividades->pluck('id')));

				// $nota_guardar = HistoricoNota::where('seccion', $relacion->Seccion->nombre)
				// 		->where('cedula_estudiante', $inscritos->Alumno->cedula)
				// 		->where('periodo', $relacion->Seccion->Periodo->nombre)
				// 		->where('cod_desasignatura',$relacion->DesAsignatura->codigo)
				// 		->where('cedula_docente',$relacion->Docente->cedula)
				// 		// ->where('seccion',$nombre_seccion)
				// 		->where('docente',$relacion->Docente->nombres.' '.$relacion->Docente->apellidos)
				// 		->where('especialidad',)
				// 		->where('estatus', 1)->update([
				// 		'nota' => ($nota == 0 || !$nota) ? 1 : $nota,
				// 		'observacion' => 'CERRADA',
				// 		'estatus' => 0
				// 	]);
				HistoricoNota::updateOrCreate(
					[
						'periodo' => $relacion->Seccion->Periodo->nombre,
						'nro_periodo' =>  $relacion->Seccion->Periodo->nro,
						'cedula_estudiante' => $inscritos->Alumno->cedula,
						'cod_desasignatura' => $relacion->DesAsignatura->codigo,
						'cod_asignatura' => $relacion->DesAsignatura->Asignatura->codigo,
						'nombre_asignatura' => $relacion->DesAsignatura->nombre,
						'seccion' => $relacion->Seccion->nombre,
						'especialidad' => $relacion->Seccion->Pnf->codigo,
						'tipo' => ($relacion->DesAsignatura->Asignatura->aprueba == 1) ? 'PROYECTO' : 'NORMAL',
					],
					[
						'observacion' => 'POR CERRAR',
						'estatus' => 1,
						'nota' => $nota,
						'cedula_docente' => $relacion->Docente->cedula,
						'docente' => $relacion->Docente->nombres.' '.$relacion->Docente->apellidos,
					]
				);
			}

			foreach ($relacion->Actividades as  $actividad) {
				$actividad->Notas()->update([
					'estatus' => 'CERRADO'
				]);
			}

			CargaNota::updateOrCreate(
				[
					'periodo' => $relacion->Seccion->Periodo->nombre,
					'seccion' => $relacion->Seccion->nombre,
					'cedula_docente' => 1,
					'docente' => 'SIGRECE',
					'cod_desasignatura' => $relacion->DesAsignatura->codigo,
					'user_id' => Auth::user()->id],
				['fecha' => Carbon::now()],
			);



			DB::commit();
			return redirect()->back()->with('mensaje', 'Sección Cerrada Exitosamente');
		} catch (\Throwable $th) {
			DB::rollback();
			return back()->with('error', $th->getMessage());
			// return vbak()
		}
	}

}
