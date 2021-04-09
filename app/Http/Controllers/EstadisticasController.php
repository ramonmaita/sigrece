<?php

namespace App\Http\Controllers;

use App\Models\ActualizacionDato;
use App\Models\CargaNota;
use App\Models\HistoricoNota;
use App\Models\Inscrito;
use App\Models\Pnf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller
{
	// TODO: CARGA DE NOTAS 2020
    public function index_carga_notas()
	{
		$total_secciones_pnf = array();
		$total_cargado_pnf = array();
		$pnf_detalles = array();
		$pnfs = Pnf::where('codigo','>=',40)->orderBy('codigo','asc')->get();
		// dd($pnfs);
		// return HistoricoNota::where('periodo',2020)->where('especialidad',$pnfs->first()->codigo)->groupBy('seccion')->pluck('seccion');
		foreach ($pnfs as $key => $pnf) {
			// echo $pnf->codigo."<br>";
			$total_secciones = HistoricoNota::where('periodo',2020)->where('especialidad',$pnf->codigo)->groupBy('seccion')->pluck('seccion');
			// $total_cargado = HistoricoNota::where('periodo',2020)->where('especialidad',$pnf->codigo)->where('estatus',0)->groupBy('seccion')->pluck('seccion');
			foreach ($total_secciones as $key => $seccion) {
				$seccion_uc = HistoricoNota::where('periodo',2020)->where('especialidad',$pnf->codigo)->where('seccion',$seccion)->groupBy('cod_desasignatura')->pluck('cod_desasignatura');
				$cargado = CargaNota::where('periodo',2020)->where('seccion',$seccion)->count();
				// $cargado += 3;
				$porcentage = ($cargado*100)/count($seccion_uc);
				// echo $seccion." total: ".count($seccion_uc)." Cargado: ".$cargado." %de carga: ".$porcentage."<br>";

				array_push($pnf_detalles,array(
					'seccion' => $seccion,
					'uc_total' => count($seccion_uc),
					'uc_cargada' => $cargado,
					'p_carga' => $porcentage
				));
			}
			// print_r($pnf_detalles);
			// echo "<br>";
			array_push($total_secciones_pnf,['pnf' => $pnf->nombre,'secciones' => $pnf_detalles]);
			unset($pnf_detalles);
			$pnf_detalles = array();
			// array_push($total_cargado_pnf, $total_cargado);
		}
		// echo $total_secciones_pnf[2]['secciones'][1]['seccion'];
		// dd($total_secciones_pnf);
		// echo $total_secciones_pnf[3][5];
		//  $total_secciones_pnf[3][5]['total'] = 5;
		// dd($total_secciones_pnf);
		// return '';
		// str_replace(' ','_',)
		return view('panel.admin.estadisticas.carga_notas.index',['total_secciones_pnf' => $total_secciones_pnf]);
	}


	public function show_secciones($seccion,$periodo)
	{
		$seccion = HistoricoNota::where('seccion', $seccion)->where('periodo', $periodo)->groupBy('cod_desasignatura')->get();
		return view('panel.admin.estadisticas.carga_notas.show',['seccion' => $seccion]);
	}

	// TODO: INSCRIPCIONES
	public function index_actualizacion_datos()
	{
		return view('panel.admin.estadisticas.actualizacion_datos.index',[]);
	}

	public function data()
	{
		$inicio = Carbon::create(2021,4,8); //TODO: CAMBIAR POR LA FECHA 2021-04-08
		$fin = Carbon::create(2021,4,23);

		$dia = Carbon::parse('2021-04-08'); //TODO: CAMBIAR POR LA FECHA 2021-04-08
		$datos = [];
		$label = [];
		$cantidad = 0;
		$dias = $inicio->diffInDays($fin);

		for ($i=0; $i <= $dias; $i++) {
			$dia_buscar = $dia;
			$dia_buscar = $dia_buscar->format('Y-m-d');
			$cantidad = ActualizacionDato::whereDate('updated_at','LIKE',"%$dia_buscar%")->count();
			array_push($label,Carbon::parse($dia)->format('d-m-Y'));
			$dia->addDay();
			array_push($datos, $cantidad);
		}

		$dia = Carbon::parse('2021-04-08'); //TODO: CAMBIAR POR LA FECHA 2021-04-08
		$datos_inscritos = [];
		$label_inscritos = [];
		$cantidad = 0;
		for ($i=0; $i <= $dias; $i++) {
			$dia_buscar = $dia;
			$dia_buscar = $dia_buscar->format('Y-m-d');
			$cantidad = Inscrito::whereDate('created_at','LIKE',"%$dia_buscar%")->count();
			array_push($label_inscritos,Carbon::parse($dia)->format('d-m-Y'));
			$dia->addDay();
			array_push($datos_inscritos, $cantidad);
		}

		// TODO: PARA GRAFICA DE INSCRITOS POR PNF
		$data = [];
		$pnfs = Pnf::whereIn('id',[1,2,3,4,5,6,7,12,13])->get();
		foreach ($pnfs as $key => $pnf) {
			$data[$pnf->codigo] = [
				'pnf' => $pnf->acronimo,
				'cantidad' => 0
			];
		}
		$inscritos = Inscrito::with('alumno')->get();
		foreach ($inscritos as $key => $inscrito_pnf) {
			$data[$inscrito_pnf->Alumno->Pnf->codigo]['cantidad'] = $data[$inscrito_pnf->Alumno->Pnf->codigo]['cantidad'] + 1;
		}

		return response()->json([
			'datos' => $datos,
			'label' => $label,
			'datos_inscritos' => $datos_inscritos,
			'label_inscritos' => $label_inscritos,
			'data_inscritos_pnf' => $data,
			'dias' => $dias
		]);
	}

}
