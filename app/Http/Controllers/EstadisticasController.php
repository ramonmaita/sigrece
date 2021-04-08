<?php

namespace App\Http\Controllers;

use App\Models\CargaNota;
use App\Models\HistoricoNota;
use App\Models\Pnf;
use Illuminate\Http\Request;

class EstadisticasController extends Controller
{
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
}
