<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Periodo;
use Illuminate\Http\Request;

class VerificarDocumentosController extends Controller
{
    public function show_comprobante($periodo,Alumno $estudiante,$tipo,$rand)
	{
		$periodo = Periodo::where('nombre',$periodo)->where('estatus',0)->first();
		return view('web.verificar.comprobante.show',['estudiante' => $estudiante, 'periodo' => $periodo]);
	}

	public function show_constancia(Alumno $alumno,$dia,$tipo,$rand)
	{

		$periodo = Periodo::where('estatus',0)->first();
		$trayecto_id = 0;
		$tra = $arrayName = array();
		$inicial = 0;
		$uno = 0;
		$dos = 0;
		$tres = 0;
		$cuatro = 0;
		$cinco = 0;
		if($alumno->InscritoActual()){
			foreach ($alumno->InscritoActual()->Inscripcion as $key => $inscripcion) {
				$trayecto_id = $inscripcion->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id;
				switch ($trayecto_id) {

					case 1:
					$uno = 1;
					array_push($tra, $uno);
					break;
					case 2:
					$dos = 2;
					array_push($tra, $dos);
					break;
					case 3:
					$tres = 3;
					array_push($tra, $tres);
					break;
					case 4:
					$cuatro = 4;
					array_push($tra, $cuatro);
					break;
					case 5:
					$cinco = 5;
					array_push($tra, $cinco);
					break;
					default:
					case 8:
					$inicial = 0;
					array_push($tra, $inicial);
					break;
					# code...
					break;
				}
			}
			$trayecto = max(array_keys(array_count_values($tra)));
		}else{
			$trayecto = false;
		}
		return view('web.verificar.constancia.show',['estudiante' => $alumno, 'dia' => $dia, 'periodo' => $periodo,'trayecto' => $trayecto]);

	}
}
