<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Periodo;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class ComprobanteController extends Controller
{
    public function index()
	{
		return view('panel.admin.documentos.comprobante.pdf');
	}

	public function pdf(Alumno $alumno)
	{
		$periodo = Periodo::where('estatus',0)->first();
		$html = view('panel.admin.documentos.comprobante.pdf',['alumno' => $alumno, 'periodo' => $periodo]);
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto
        $dompdf->getCanvas()->page_text(500, 770, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream("$alumno->cedula - $alumno->nombres $alumno->apellidos.pdf", array("Attachment" => false));
	}
}
