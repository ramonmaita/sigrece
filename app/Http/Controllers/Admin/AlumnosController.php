<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Trayecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
    public function show(Alumno $alumno)
    {
		// echo array_keys($alumno->Plan->Asignaturas->groupBy('trayecto_id'));
		// echo dd(array_unique($alumno->Plan->Asignaturas->get('trayecto_id'),SORT_NUMERIC));
		// echo array_unique($alumno->Plan->Asignaturas->pluck('trayecto_id'),SORT_NUMERIC);
		// echo $alumno->Historico;
		// echo "</br>";
		$trayectos_a = [];
		// echo '<table width="100%" border="1">';

		$aprueba_normal = ($alumno->tipo == 10) ? 10 : 12;
		$aprueba_proyecto = ($alumno->tipo == 10) ? 10 : 16;

		$titulo = DB::table('graduandos')->where('cedula',$alumno->cedula)->where('pnf',$alumno->Pnf->codigo)->max('titulo');
		if ($titulo == 2) {
			# TITULO DE INGENIERO
			if ($alumno->Pnf->codigo == 40 || $alumno->Pnf->codigo == 60) {
				$trayectos_aprobados = [8,1,2,3,4,5];
				foreach ($alumno->Plan->Asignaturas->whereIn('trayecto_id',$trayectos_aprobados)->groupBy('trayecto_id') as $key => $a) {
					$trayecto = Trayecto::find($key);
					$uc_t = count($trayecto->Asignaturas->where('plan_id',$alumno->plan_id));
					$trayectos_a[] = [
						'nombre' => $trayecto->observacion,
						'uc_totales' => $uc_t,
						'uc_aprobadas' => $uc_t,
						'uc_pendientes' => 0,
						'porcentaje' => round(($uc_t/$uc_t)*100,2)
					];
				}
			}else{
				$trayectos_aprobados = [8,1,2,3,4];
				foreach ($alumno->Plan->Asignaturas->whereIn('trayecto_id',$trayectos_aprobados)->groupBy('trayecto_id') as $key => $a) {
					$trayecto = Trayecto::find($key);
					$uc_t = count($trayecto->Asignaturas->where('plan_id',$alumno->plan_id));
					$trayectos_a[] = [
						'nombre' => $trayecto->observacion,
						'uc_totales' => $uc_t,
						'uc_aprobadas' => $uc_t,
						'uc_pendientes' => 0,
						'porcentaje' => round(($uc_t/$uc_t)*100,2)
					];
				}
			}
		}elseif($titulo == 1){
			# TITULO DE TSU
			if ($alumno->Pnf->codigo == 40 || $alumno->Pnf->codigo == 60) {
				$trayectos_aprobados = [8,1,2,3];
				foreach ($alumno->Plan->Asignaturas->whereIn('trayecto_id',$trayectos_aprobados)->groupBy('trayecto_id') as $key => $a) {
					$trayecto = Trayecto::find($key);
					$uc_t = count($trayecto->Asignaturas->where('plan_id',$alumno->plan_id));
					$trayectos_a[] = [
						'nombre' => $trayecto->observacion,
						'uc_totales' => $uc_t,
						'uc_aprobadas' => $uc_t,
						'uc_pendientes' => 0,
						'porcentaje' => round(($uc_t/$uc_t)*100,2)
					];
				}
			}else{
				$trayectos_aprobados = [8,1,2];
				foreach ($alumno->Plan->Asignaturas->whereIn('trayecto_id',$trayectos_aprobados)->groupBy('trayecto_id') as $key => $a) {
					$trayecto = Trayecto::find($key);
					$uc_t = count($trayecto->Asignaturas->where('plan_id',$alumno->plan_id));
					$trayectos_a[] = [
						'nombre' => $trayecto->observacion,
						'uc_totales' => $uc_t,
						'uc_aprobadas' => $uc_t,
						'uc_pendientes' => 0,
						'porcentaje' => round(($uc_t/$uc_t)*100,2)
					];
				}
			}
		}else{
			$trayectos_aprobados = [];
		}
		// return '';
		$trayectos = Trayecto::orderBy('index')->whereNotIn('id',$trayectos_aprobados)->get();
		foreach ($trayectos as $key => $trayecto) {
			$aprobadas = 0;
			$reprobadas = 0;
			if(count($trayecto->Asignaturas->where('plan_id',$alumno->plan_id)) > 0){
				// echo '<tr><th colspan="5">'.$trayecto->nombre.'</th></tr>';
				foreach ($trayecto->Asignaturas->where('plan_id',$alumno->plan_id) as $key => $asignatura) {
					$nota = '';
					$nota_final = 0;
					// echo '<tr>';
					// echo '<td>'.@$alumno->ultimo_periodo($asignatura->codigo)->periodo.'</td>';
					// echo '<td>'.$asignatura->codigo.'</td>';
					// echo '<td>'.$asignatura->nombre.'</td>';
					if (count($alumno->Notas($asignatura->codigo,@$alumno->ultimo_periodo($asignatura->codigo)->nro_periodo)) <= 0 ){
						$nota = 0;
					}else{
						foreach ($alumno->Notas($asignatura->codigo,@$alumno->ultimo_periodo($asignatura->codigo)->nro_periodo) as $key => $nota_trimestre) {
							$nota .= $nota_trimestre->nota.' ';
							$nota_final += $nota_trimestre->nota;
						}
					}
					if(round($nota_final/count($asignatura->DesAsignaturas)) >= $aprueba_normal && $asignatura->aprueba == 0 || round($nota_final/count($asignatura->DesAsignaturas)) >= $aprueba_proyecto && $asignatura->aprueba == 1){
						$aprobadas++;
					}else{
						$reprobadas++;
					}
					// echo '<td>'.$nota.'</td>';
					// echo '<td style="background:'.((round($nota_final/count($asignatura->DesAsignaturas)) >= 12 && $asignatura->aprueba == 0 || round($nota_final/count($asignatura->DesAsignaturas)) >= 16 && $asignatura->aprueba == 1) ?'green' : 'red').'">'.round($nota_final/count($asignatura->DesAsignaturas)).'</td>';
					// echo "</tr>";
				}
				$uc_t = count($trayecto->Asignaturas->where('plan_id',$alumno->plan_id));
				$trayectos_a[] = [
					'nombre' => $trayecto->observacion,
					'uc_totales' => $uc_t,
					'uc_aprobadas' => $aprobadas,
					'uc_pendientes' => $reprobadas,
					'porcentaje' => round(($aprobadas/$uc_t)*100,2)
				];
			}
		}
		// echo '</table>';

		// print_r($trayectos_a);
		// return '';
		$titulos = DB::table('graduandos')->where('cedula',$alumno->cedula)
						->join('pnfs' ,'graduandos.pnf','=','pnfs.codigo')
						->select('graduandos.*','pnfs.*')
						->orderBy('graduandos.pnf')
						->orderBy('graduandos.titulo')
						->get();
        return view('panel.admin.estudiantes.show',['alumno' => $alumno,'trayectos' => $trayectos_a,'titulos' => $titulos]);
    }

	public function periodos(Alumno $alumno)
	{
		return view('panel.admin.estudiantes.periodos.corregir',['alumno' => $alumno]);
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
}
