<?php

namespace App\Http\Controllers\Auxiliar;

use App\Http\Controllers\Controller;
use App\Mail\ComprobanteInscripcion;
use App\Models\ActualizacionDato;
use App\Models\Alumno;
use App\Models\Asignado;
use App\Models\Asignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Ingreso;
use App\Models\Inscripcion;
use App\Models\Inscrito;
use App\Models\Periodo;
use App\Models\Seccion;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NuevoIngresoController extends Controller
{
    public function index_asignado()
	{
		return view('panel.auxiliar.inscripciones.nuevo_ingreso.asignados.index');
	}

	public function search_asignado(Request $request)
	{
		$request->validate([
			'nacionalidad' => 'required',
			'cedula' => 'required|numeric|digits_between:6,9'
		]);
		$alumno  = Alumno::where('cedula',$request->cedula)->where('nacionalidad',$request->nacionalidad)->first();
		$id = ($alumno) ? $alumno->id : '' ;
		$periodo = Periodo::where('estatus',0)->first();
		$actulaizo_datos = ActualizacionDato::where('alumno_id',$id)->first();
		$nuevo = Asignado::where('cedula',$request->cedula)->where('periodo_id',$periodo->id)->first();
		// if($actulaizo_datos){
		// 	return back()->with('jet_error','Ya realizó la actualización de datos. Inicie sesión para mas opciones.');
		// }
		if($nuevo){

			if(Auth::user()->hasPermissionTo('ANGOSTURA DEL ORINOCO')){
				switch ($nuevo->Pnf->codigo) {
					case 40:
											//   año  mes dia hora minuto segundo
						$inicio = Carbon::create(2022, 10, 11, 7, 0, 0);
						break;
					case 45:
											//   año  mes dia hora minuto segundo
						$inicio = Carbon::create(2022, 10, 12, 7, 0, 0);
						break;
					case 50:
											//   año  mes dia hora minuto segundo
						$inicio = Carbon::create(2022, 10, 10, 7, 0, 0);
						break;
					case 55:
											//   año  mes dia hora minuto segundo
						$inicio = Carbon::create(2022, 12, 12, 7, 0, 0);
						break;
					case 60:
											//   año  mes dia hora minuto segundo
						$inicio = Carbon::create(2022, 10, 13, 7, 0, 0);
						break;
					case 65:
											//   año  mes dia hora minuto segundso
						$inicio = Carbon::create(2022, 10, 13, 7, 0, 0);
						break;
					case 70:
											//   año  mes dia hora minuto segundo
						$inicio = Carbon::create(2022, 10, 14, 7, 0, 0);
						break;
					case 75:
											//   año  mes dia hora minuto segundo TODO: IMI
						$inicio = Carbon::create(2022, 10, 14, 7, 0, 0);
						break;
					case 80:
											//   año  mes dia hora minuto segundo  TODO: HSL
						$inicio = Carbon::create(2022, 10, 11, 7, 0, 0);
						break;
					case 85:
											//   año  mes dia hora minuto segundo  TODO: QUI
						$inicio = Carbon::create(2022, 10, 14, 7, 0, 0);
						break;
					case 90:
											//   año  mes dia hora minuto segundo  TODO: DYL
						$inicio = Carbon::create(2022, 10, 14, 7, 0, 0);
						break;
					case 95:
											//   año  mes dia hora minuto segundo  TODO: AGRO
						$inicio = Carbon::create(2022, 10, 12, 7, 0, 0);
						break;

					default:
						# code...
						break;
				}
			}else{
				// TODO: TODOS LOS NUCLEOS MENOS ANGOSTURA DEL ORINOCO
				$inicio = Carbon::create(2022, 10, 9, 8, 00, 00);
			}
			$actual = Carbon::now();
			// $inicio = Carbon::create(2021, 9, 27, 8, 30, 00);
			$fin = Carbon::create(2022, 10, 14, 23, 59, 00);

			if($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin)){
				$id_encriptado = encrypt($nuevo->id);
				return redirect()->route('panel.auxiliar.inscripciones.nuevo-ingreso.asignados.show-form',['id_encriptado' => $id_encriptado]);
			}else{
				$inicio = Carbon::parse($inicio)->diffForHumans();
				$mensaje = "El sistema aperturará  $inicio para el PNF en ".$nuevo->Pnf->nombre;
				return back()->with('jet_error',$mensaje);
			}
			// return view('web.estudiantes.buscar_estudiante',['alumno' => $alumno]);
		}else{
			$mensaje = "La Cédula:  <b class='mx-2 underline'>".$request->nacionalidad."-".$request->cedula."</b> no se encuenta en nuestros registros.";
			return back()->with('jet_error',$mensaje);
		}
	}

	public function show_form_asignado($id_encriptado)
	{
		$id_desencriptado = decrypt($id_encriptado);
		$nuevo  = Asignado::find($id_desencriptado);
		return view('panel.auxiliar.inscripciones.nuevo_ingreso.asignados.form',['nuevo' => $nuevo]);
	}

	public function index_flotante()
	{
		return view('panel.auxiliar.inscripciones.nuevo_ingreso.flotante.form');
	}
	public function index_search_alumno()
	{
		return view('panel.auxiliar.inscripciones.nuevo_ingreso.index');
	}


	public function buscar_alumno(Request $request)
	{
		$request->validate([
			'nacionalidad' => 'required',
			'cedula' => 'required|numeric|digits_between:6,9'
		]);
		$alumno  = Alumno::where('cedula',$request->cedula)->where('nacionalidad',$request->nacionalidad)->first();
		// $id = ($alumno) ? $alumno->id : '' ;
		// $actulaizo_datos = ActualizacionDato::where('alumno_id',$id)->first();
		// $nuevo = Asignado::where('cedula',$request->cedula)->first();
		// if($actulaizo_datos){
		// 	return back()->with('jet_error','Ya realizó la actualización de datos. Inicie sesión para mas opciones.');
		// }
		if($alumno){

			// $actual = Carbon::now();
			// $inicio = Carbon::create(2021, 9, 27, 8, 30, 00);
			// $fin = Carbon::create(2021, 10, 15, 23, 59, 00);
			// if($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin) || Auth::user()->hasRole('Admin')){
				$id_encriptado = encrypt($alumno->id);
				return redirect()->route('panel.auxiliar.inscripciones.nuevo-ingreso.uc_a_inscribir',['id_encriptado' => $id_encriptado]);
			// }else{
			// 	$inicio = Carbon::parse($inicio)->diffForHumans();
			// 	$mensaje = "El sistema aperturará  $inicio para el PNF en ".$nuevo->Pnf->nombre;
			// 	return back()->with('jet_error',$mensaje);
			// }
			// return view('web.estudiantes.buscar_estudiante',['alumno' => $alumno]);
		}else{
			$mensaje = "La Cédula:  <b class='mx-2 underline'>".$request->nacionalidad."-".$request->cedula."</b> no se encuenta en nuestros registros.";
			return back()->with('jet_error',$mensaje);
		}
	}
	public function cambiar_plan(Alumno $alumno)
	{
		$nuevo_plan = $alumno->plan_id;

		switch ($alumno->plan_id) {
			case '27':
				$nuevo_plan = 5;
				break;
			case '28':
				$nuevo_plan = 11;
				break;
			case '29':
				$nuevo_plan = 14;
				break;
			case '30':
				$nuevo_plan = 17;
				break;
			case '31':
				$nuevo_plan = 21;
				break;
			case '32':
				$nuevo_plan = 23;
				break;
			case '33':
				$nuevo_plan = 24;
				break;
			case '34':
				$nuevo_plan = 25;
				break;
			case '35':
				$nuevo_plan = 26;
				break;
			case '36':
				$nuevo_plan = 39;
				break;

			default:
				$nuevo_plan = $alumno->plan_id;
				break;
		}

		if( $nuevo_plan != $alumno->plan_id){
			$alumno->update([
				'plan_id' => $nuevo_plan
			]);
		}
	}

	public function uc_inscribir($id_encriptado)
	{
		$id_desencriptado = decrypt($id_encriptado);
		$alumno  = Alumno::find($id_desencriptado);
		if($alumno->plan_id >= 27 && $alumno->plan_id <= 36){
			$this->cambiar_plan($alumno);
		}
		$incritas = array();
		if($alumno->InscritoActual()){
			foreach ($alumno->InscritoActual()->Inscripcion as $key => $inscripcion) {
				// echo $inscripcion->RelacionDocenteSeccion->des_asignatura_id;
				array_push($incritas,$inscripcion->RelacionDocenteSeccion->DesAsignatura->Asignatura->id);
				// echo "<br>";
			}
		}
		$uc_acursar = array();
		foreach ($alumno->Plan->Asignaturas->where('trayecto_id',8)->whereNotIn('id',$incritas) as $key => $asignatura) {
			array_push($uc_acursar, $asignatura);
		}

		// return dd($uc_acursar);

		return view('panel.auxiliar.inscripciones.nuevo_ingreso.uc_inscribir',['alumno' => $alumno, 'uc_acursar' => $uc_acursar]);
	}

	public function store(Request $request)
	{
		// return dd($request);
		$request->validate(
			[
				'uc_a_inscribir' => 'required|array|min:1'
			]
		);
		// return '';
		try {
			DB::beginTransaction();
				$alumno = Alumno::find($request->alumno_id);
				$periodo = Periodo::where('estatus',0)->first();
				$inscrito = Inscrito::updateOrCreate(
					[
						'periodo_id' => $periodo->id,
						'alumno_id' => $alumno->id,
					],
					['fecha' => Carbon::now()]
				);
				foreach ($request->seccion as $key => $seccion) {
					if (array_key_exists($key,$request->uc_a_inscribir)) {
						$asignaturas = Asignatura::whereIn('id',$request->uc_a_inscribir[$key])->get();
						$seccion_db = Seccion::find($seccion);
						$seccion_db->update(['cupos' => ($seccion_db->cupos - 1) ]);
						foreach ($asignaturas as $key => $asignatura) {
							$uc_cohortes = DesAsignaturaDocenteSeccion::where('seccion_id',$seccion)
							->whereIn('des_asignatura_id', $asignatura->DesAsignaturas->pluck('id'))
							->where('estatus','ACTIVO')->get();
							foreach ($uc_cohortes as $key => $uc_cohorte) {
								Inscripcion::create([
									'desasignatura_docente_seccion_id' => $uc_cohorte->id,
									'inscrito_id' => $inscrito->id,
									'alumno_id' => $alumno->id
								]);
							}
						}
					}
				}

				// TODO: CAMBIAR EL ID DEL PERIODO EN LAS INSCRIPCIONES

				Ingreso::updateOrCreate(
					[
						'alumno_id' => $alumno->id,
						'periodo_id' => $periodo->id,
						'tipo' => ($alumno->CheckPeriodo(6)) ? 'ASIGNADO' : 'REINGRESO',
					], //TODO: EL VALOR QUE NO SE ACTUALIZA
					[
						'estatus' => 'INSCRITO' ,
					]
				);

				// $periodo = Periodo::where('estatus',0)->first();
				// $html = view('panel.admin.documentos.comprobante.pdf',['alumno' => $alumno, 'periodo' => $periodo]);
				// $options = new Options();
				// $options->setIsRemoteEnabled(true);
				// $dompdf = new Dompdf($options);
				// $dompdf->loadHtml($html);
				// $dompdf->setPaper('letter');
				// $font = $dompdf->getFontMetrics()->get_font("helvetica");
				// //ancho alto
				// $dompdf->getCanvas()->page_text(500, 770, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
				// $dompdf->render();
				// // return $dompdf->stream("$alumno->cedula - $alumno->nombres $alumno->apellidos.pdf", array("Attachment" => false));
				// // $pdf = PDF::loadView('reportes.historia_clinica', compact('historia_clinica'));
				// $comprobante = $dompdf->output();
				// Mail::to($alumno->Usuario->email)
				// ->send(new ComprobanteInscripcion($alumno, $dompdf->output()));
			DB::commit();
			return redirect()->route('panel.auxiliar.inscripciones.nuevo-ingreso.index_alumno')->with('jet_mensaje','inscripcion realizada con exito');
		} catch (\Throwable $th) {
			DB::rollback();
			return redirect()->route('panel.auxiliar.inscripciones.nuevo-ingreso.index_alumno')->with('jet_error',$th->getMessage());
		}
		// return dd($request);
	}

}
