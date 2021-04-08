<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class NotasController extends Controller
{
    public function index()
	{
		$alumno = Alumno::where('cedula',24377317)->first();
		return view('panel.admin.documentos.notas.pdf',['alumno' => $alumno]);
	}

	public function pdf(Alumno $alumno)
	{


		$html = view('panel.admin.documentos.notas.pdf',['alumno' => $alumno]);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto
        $dompdf->getCanvas()->page_text(500, 777, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream("$alumno->nombres$alumno->apellidos.pdf", array("Attachment" => false));
	}
}
