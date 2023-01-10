<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class CulminacionController extends Controller
{
    public function index()
	{
		return view('panel.admin.documentos.culminacion.pdf');
	}

	public function pdf(Alumno $alumno, $titulo)
	{


		// dd($alumno->InscritoActual()->Inscripcion->with('RelacionDocenteSeccion'));
		// return;
		$html = view('panel.admin.documentos.culminacion.pdf',['alumno' => $alumno, 'titulo' => $titulo]);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto
		$dompdf->getCanvas()->page_text(480, 800, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream("Constancia de Culminacion de $alumno->cedula - $alumno->nombres $alumno->apellidos.pdf", array("Attachment" => false));
	}
}
