<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
	public function pdf(Alumno $alumno)
	{
		$html = view('panel.admin.documentos.expediente.pdf',['alumno' => $alumno]);
		// return $html;
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto
        $dompdf->getCanvas()->page_text(500, 755, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream("Expediente $alumno->nombres $alumno->apellidos.pdf", array("Attachment" => false));
	}
}
