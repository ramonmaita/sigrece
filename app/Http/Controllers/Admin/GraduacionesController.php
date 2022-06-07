<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Asignatura;
use Illuminate\Http\Request;
use App\Models\Graduando;
use App\Models\HistoricoNota;
use App\Models\Pnf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GraduacionesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('panel.admin.graduaciones.index');
	}

	public function buscar(Request $request)
	{
		$request->validate([
			// 'nacionalidad' => 'required',
			'cedula' => 'required|numeric|digits_between:6,9'
		]);
		$graduando = Graduando::where('cedula', $request->cedula)->orderBy('id', 'desc')->first();
		if ($graduando) {
			return redirect()->route('panel.graduacion.show', ['graduando' => $graduando]);
		} else {
			return back()->with('error', "No se encotraron resultados para la cédula $request->cedula");
		}
		return;
		// return view('panel.admin.graduaciones.index');
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
	public function show(Graduando $graduando)
	{
		return view('panel.admin.graduaciones.show', ['graduando' => $graduando]);
	}

	public function titulo(Graduando $graduando)
	{
		ini_set('max_execution_time', 4200);

		// $graduando = Graduando::find($graduando);
		// return $graduando;
		$alumno = Alumno::where('cedula', $graduando->cedula)->first();
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		// $options->setDpi(100);
		$dompdf = new Dompdf($options);

		// return view('panel.graduacion.pdf.titulo', ['graduando' => $graduando]);

		if ($alumno) {
			if (\Carbon\Carbon::parse($graduando->egreso)->format('d-m-Y') < \Carbon\Carbon::parse('01-06-2020')->format('d-m-Y')) {
				$html = view('panel.graduacion.pdf.titulo-iuteb', ['graduando' => $graduando, 'alumno' => $alumno]);
			} else {
				$html = view('panel.admin.graduaciones.pdf.titulo', ['graduando' => $graduando, 'alumno' => $alumno]);
			}
		} else {
			$html = "titulo mision sucre $graduando->cedula";
			// $html = view('panel.graduacion.pdf.titulo-ms', ['graduando' => $graduando]);
		}

		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4');
		$dompdf->render();
		return $dompdf->stream("Titulo", array("Attachment" => false));
	}

	public function acta(Graduando $graduando)
	{
		ini_set('max_execution_time', 4200);

		// $graduando = Graduando::find($id);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
		$alumno = Alumno::where('cedula', $graduando->cedula)->first();

		// return view('panel.graduacion.pdf.acta', ['graduando' => $graduando]);
		if ($alumno) {
			$html = view('panel.admin.graduaciones.pdf.acta', ['graduando' => $graduando, 'alumno' => $alumno]);
		} else {
			$html = view('panel.graduacion.pdf.acta-ms', ['graduando' => $graduando]);
		}
		$dompdf->loadHtml($html);
		$dompdf->setPaper('letter');
		$dompdf->render();

		return $dompdf->stream("Acta", array("Attachment" => false));
	}

	public function notas($id)
	{
		// return substr('S50-0-00COL14',1);
		// ini_set('max_execution_time', 420);
		$graduando = Graduando::find($id);
		$g = 1;
		ini_set('max_execution_time', 4200);
		$alumno = Alumno::where('cedula', $graduando->cedula)->first();

		// return $graduando->promedio();

		// return $alumno->Plan->asignaturas();

		if ($alumno) {
			// if ($alumno->pnf_id == 2 && $alumno->plan_id == 15 || count($graduando) >= 2 ) {
			if ($alumno->pnf_id == 2 && $alumno->plan_id == 15) {
				$asigna_f = Asignatura::whereIn('trayecto_id', [8, 1, 2])->where('pnf_id', 45)->where('plan_id', 17)->get();
				$n = HistoricoNota::select('*', DB::raw(' count(*) as total'))->where('cedula_estudiante', $alumno->cedula)->where('especialidad', $alumno->Pnf->codigo)->where('estatus', 0)->where('cod_desasignatura', 'like', '%17%')
					->groupBy('cod_asignatura')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC')->get();
			} else {
				$n = HistoricoNota::select('*', DB::raw(' count(*) as total'))->where('cedula_estudiante', $alumno->cedula)->where('especialidad', $alumno->Pnf->codigo)->where('estatus', 0)
					->groupBy('cod_asignatura')->OrderByRaw('cod_desasignatura ASC, nro_periodo ASC')->get();
			}

			if ($graduando->titulo == 1) {
				if ($alumno->pnf_id == 1 && $alumno->plan_id == 5 || $alumno->pnf_id == 5 && $alumno->plan_id == 21) {

					$asigna = Asignatura::whereIn('trayecto_id', [8, 1, 2, 3])->where('pnf_id', $alumno->Pnf->id)->where('plan_id', $alumno->Plan->id)->get();
				} else {

					$asigna = Asignatura::whereIn('trayecto_id', [8, 1, 2])->where('pnf_id', $alumno->Pnf->id)->where('plan_id', $alumno->Plan->id)->get();
				}

				// $asigna = Asignatura::where('codigo','APT1312')->get();
				$n = HistoricoNota::select('*', DB::raw(' count(*) as total'))->where('cedula_estudiante', $alumno->cedula)->where('especialidad', $alumno->Pnf->codigo)->where('estatus', 0)
					->groupBy('cod_asignatura')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC')->get();
			}


			if ($graduando->titulo == 2) {
				$asigna = Asignatura::where('pnf_id', $alumno->Pnf->id)->where('trayecto_id', '!=', 7)->where('plan_id', $alumno->Plan->id)->get();

				// $asigna = Asignatura::where('codigo','APT1312')->get();
				$n = HistoricoNota::select('*', DB::raw(' count(*) as total'))->where('cedula_estudiante', $alumno->cedula)->where('especialidad', $alumno->Pnf->codigo)->where('estatus', 0)
					->groupBy('cod_asignatura')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC')->get();
			} else {
				$n = HistoricoNota::select('*', DB::raw(' count(*) as total'))->where('cedula_estudiante', $alumno->cedula)->where('especialidad', $alumno->Pnf->codigo)->where('estatus', 0)
					->groupBy('cod_asignatura')->OrderByRaw('cod_desasignatura ASC, nro_periodo ASC')->get();
			}

			$a  = array(); //NOTAS DE LOS TRIMESTRES ->OrderBy('ASIGNATURA' ,'ASC')->OrderBy('PERIODO' ,'DESC')
			$nota_final  = array(); // SUMATORIA DE LOS TRIMESTRES
			$uc =  array(); //CONTADOR PARA MULTIPLICAR POR LAS UC
			foreach ($asigna as $asig_a) {

				// return dd($asig_a->DesAsignaturas);
				foreach ($asig_a->DesAsignaturas as $notas) {
					$not = 0;
					$nota_f = 0;
					$contador = 0;
					// return Calificacion::where('cedula_estudiante', $alumno->cedula)->where('cod_asignatura','APT1312')->where('ASIGNATURA','S50-1-03AYP14')->groupBy('ASIGNATURA')->get();


					foreach ($c = HistoricoNota::where('cedula_estudiante', $alumno->cedula)->where('cod_asignatura', $notas->Asignatura->codigo)->where('cod_desasignatura', $notas->codigo)->groupBy('cod_desasignatura')->get() as $key =>  $nota) {
						$coun = count($c);
						// return $c;
						// return $notas->nombre;

						if (($coun > 1)) {
							$not = $nota->nota;
							$nota_f = $not;
							$contador = 1;
							// echo $ap;

						} else {
							// echo $nota->nota_trimestre().'<br>';
							$cod_anterior = '';
							$nota_anterior = 0;
							foreach ($nota->nota_trimestre() as $nt) {

								$u_nota = collect(HistoricoNota::where('cedula_estudiante', $nota->cedula_estudiante)->where('cod_desasignatura', $nt->cod_desasignatura)->OrderByRaw(' cod_desasignatura ASC, nro_periodo ASC')->where('estatus', 0)->get())->last();

								$not = $value = ($not == 0) ? $u_nota->nota : $not . ' ' . $u_nota->nota;
								$nota_f = $nota_f + $u_nota->nota;
								$contador++;
							}
						}
					}
					if ($notas->Asignatura->codigo === "AAA133" || $notas->Asignatura->codigo === "AAA233" || $notas->Asignatura->codigo === "AAA333" || $notas->Asignatura->codigo === "AAA433" || $notas->Asignatura->codigo === "CBATPE0309") {
						$not = 20;
						$nota_f = $not;
						$contador = 1;
					}
				}
				array_push($a, $not);
				array_push($uc, $contador);
				// array_push($nota_final, 12);
				// $contador = 1;
				if ($contador == 0) {
						$nota_fin = ($nota_f == 0) ? 30 / 1 : $nota_f / 1;
				} else {

					$nota_fin = $nota_f / $contador;
				}
				// echo $notas->nombre.' - ' .$notas->codigo. ': '. $nota_f .'<br>';
				array_push($nota_final, $nota_fin);
				// dd($nota_final);
				// $not = 0;
				// $nota_final = 0;
				// $contador = 0;

			}
			// return dd($a);
			// dd($a);
			// return '';

			// 26355270 20557810 23552675 26604947 26722003 23730264 26139389


			$options = new Options();
			$options->setIsRemoteEnabled(true);
			$dompdf = new Dompdf($options);


			$html = view('panel.admin.graduaciones.pdf.notas', [
				'alumno' => $alumno, //DATOS DEL ALUMNO
				'asigs' => $asigna, // ASIGNATURAS AGRUPADAS
				'calificaciones' => $a, // NOTAS DE LOS TRIMESTRES
				'g' => $g, // TIPO (GRADUANDO = 1 | ESTUDIANTE = 0)
				'total' => $uc, // CONTADOR PARA SACAR LAS UC
				'nota_final' => $nota_final, // SUMATORIA DE LAS NOTAS DE LOS TRIMESTRES


				'asig_faltante' => @$asigna_f,
				'graduando' => $graduando
			]);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('letter');
			$dompdf->render();
			$font = $dompdf->getFontMetrics()->get_font("helvetica");
			//ancho alto
			$dompdf->getCanvas()->page_text(500, 765, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0, 0, 0));
			return $dompdf->stream("Notas $alumno->cedula", array("Attachment" => false));
		} else {
			return abort(404);
		}
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

	public function titulos($pnf,$titulo,$periodo)
    {
        ini_set('max_execution_time', 4800);

	        // LA LINEA SIGUIENTE GENERA TODOS LOS TITULOS PERO ESTA CAMENTADO PARA QUE FUNCIONE DEBERA DE BORRAR LOS // Y COLOCARLOS EN LA LINEA DE MAS ABAJO
			// return $titulo;
	        $graduandos = Graduando::where('pnf',$pnf)->where('titulo',$titulo)->where('periodo',$periodo)->skip(80)->take(20)->get();

	        // LA SIGUIENTE LINEA SOLO GENERA 40 TITULOS POR DOCUMENTOS SI QUIERE QUE GENERE MAS O MENOS PUEDE CAMBIAR EL VALOR DE take(40) EL VALOR DE skip ES LA CANTIDAD DE REGISTROS QUE VA A OMITIR LA CONSULTA PARA LA PRIMERA GENERADA DE LOS TITULO HAY QUE DEJARLO EN 0 PARA GENERAR LA SIGUIENTE PARTE SE COLOCAN 40 EL VALOR DE skip QUE FUERON LOS PRIMEROS 40 QUE SE GENERARON EN EL LOTE ANTERIOR
            // $graduandos = Graduando::where('pnf',$pnf)->where('titulo',$titulo)->where('periodo',$periodo)->skip(45)->take(45)->get();
	        // $graduandos = Graduando::where('pnf',$pnf)->where('titulo',$titulo)->where('periodo',$periodo)->skip(0)->take(5)->get();


        // return count($graduandos);
	        // $graduandos = Graduando::whereIn('id',[6363,6370,6314])->get();

        $options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
		 $p = ' ';
        // return view('panel.graduacion.pdf.titulos', ['graduandos' => $graduandos]);
        if ($pnf <= 35) {
        	$html = view('panel.admin.graduaciones.pdf.titulos-ms', ['graduandos' => $graduandos]);
			$p = ($pnf >= 20 && $pnf <= 35) ?   'CARRERA '.Pnf::where('codigo',$pnf)->first()->acronimo :'MISION SUCRE '.$pnf ;

        }else{

			$html = view('panel.admin.graduaciones.pdf.titulos', ['graduandos' => $graduandos]);
			$p = Pnf::where('codigo',$pnf)->first()->acronimo;
        }
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();
		$t = ($titulo == 2) ? 'ING' : 'TSU';
        return $dompdf->stream("Titulos $t $p", array("Attachment" => false));
    }

	public function actas($pnf,$titulo,$periodo)
    {

        ini_set('max_execution_time', 4800);

        $graduandos = Graduando::where('pnf',$pnf)->where('titulo',$titulo)->where('periodo',$periodo)->skip(0)->take(45)->get();
        $options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
		$p = ' ';
        if ($pnf <= 35) {
        	$html = view('panel.admin.graduaciones.pdf.actas-ms', ['graduandos' => $graduandos]);

			$p = ($pnf >= 20 && $pnf <= 35) ?   'CARRERA '.Pnf::where('codigo',$pnf)->first()->acronimo :'MISION SUCRE '.$pnf ;
		}else{
        	$html = view('panel.admin.graduaciones.pdf.actas', ['graduandos' => $graduandos]);
			$p = Pnf::where('codigo',$pnf)->first()->acronimo;
        }
        $dompdf->loadHtml($html);
        // return $dompdf->download('actas.pdf');
        $dompdf->setPaper('letter');
        $dompdf->render();
		$t = ($titulo == 2) ? 'ING' : 'TSU';
        return $dompdf->stream("Actas $t $p", array("Attachment" => false));
    }
}
