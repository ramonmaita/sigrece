<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Periodo;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class ConstanciaController extends Controller
{
    public function index()
	{
		return view('panel.admin.documentos.constancia.pdf');
	}

	public function pdf(Alumno $alumno)
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
		// dd($alumno->InscritoActual()->Inscripcion->with('RelacionDocenteSeccion'));
		// return;
		$html = view('panel.admin.documentos.constancia.pdf',['alumno' => $alumno, 'periodo' => $periodo,'trayecto' => $trayecto]);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto
		$dompdf->getCanvas()->page_text(480, 800, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream("Constancia $alumno->cedula - $alumno->nombres $alumno->apellidos.pdf", array("Attachment" => false));
	}
}
