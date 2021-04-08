<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Trayecto;
use Illuminate\Http\Request;

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
		// echo $alumno->Historico;
		// echo "</br>";
		$trayectos_a = [];
		// echo '<table width="100%" border="1">';
		$trayectos = Trayecto::orderBy('index')->get();
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
					if(round($nota_final/count($asignatura->DesAsignaturas)) >= 12 && $asignatura->aprueba == 0 || round($nota_final/count($asignatura->DesAsignaturas)) >= 16 && $asignatura->aprueba == 1){
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
        return view('panel.admin.estudiantes.show',['alumno' => $alumno,'trayectos' => $trayectos_a]);
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
