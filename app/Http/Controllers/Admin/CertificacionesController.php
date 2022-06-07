<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Graduando;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class CertificacionesController extends Controller
{
    public function buscar(Request $request)
	{
		$request->validate([
			// 'nacionalidad' => 'required',
			'cedula' => 'required|numeric|digits_between:6,9'
		]);
		$graduando = Graduando::where('cedula', $request->cedula)->orderBy('id', 'desc')->first();
		if ($graduando) {
			return redirect()->route('panel.documentos.certificados.show', ['graduando' => $graduando]);
		} else {
			return back()->with('error', "No se encotraron resultados para la cédula $request->cedula");
		}
		return;
		// return view('panel.admin.graduaciones.index');
	}

	public function show(Graduando $graduando)
	{
		return view('panel.admin.documentos.certificados.show', ['graduando' => $graduando]);
	}

	public function autenticacion(Graduando $graduando)
	{
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		// $options->setDpi(100);
		$datos = ($graduando->Alumno) ? $graduando->Alumno->nacionalidad.'-'.$graduando->Alumno->cedula.' '.$graduando->Alumno->nombres.' '.$graduando->Alumno->apellidos : $graduando->nacionalidad.'-'.$graduando->cedula.' '.$graduando->nombres.' '.$graduando->apellidos;

		$dompdf = new Dompdf($options);

		$html =  view('panel.admin.documentos.certificados.autenticacion.pdf',['datos_graduando' => $graduando]);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4');
		$dompdf->render();
		return $dompdf->stream("Autenticación de Titulo de $datos", array("Attachment" => false));

	}

	public function emision(Graduando $graduando)
	{
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		// $options->setDpi(100);
		$datos = ($graduando->Alumno) ? $graduando->Alumno->nacionalidad.'-'.$graduando->Alumno->cedula.' '.$graduando->Alumno->nombres.' '.$graduando->Alumno->apellidos : $graduando->nacionalidad.'-'.$graduando->cedula.' '.$graduando->nombres.' '.$graduando->apellidos;
		$dompdf = new Dompdf($options);

		$html =  view('panel.admin.documentos.certificados.emision.pdf',['datos_graduando' => $graduando]);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4');
		$dompdf->render();
		return $dompdf->stream("Emisión de Titulo de $datos", array("Attachment" => false));


	}
	public function certificacion($especialidad)
	{
		$pnf = '';
		$folios = 0;
		switch ($especialidad) {
			// MISION SUCRE
			case 2:
				$pnf = 'Programa Nacional De Formación en Geología y Minas';
				$tipo = 'PNF';
				$folios = 0;
				break;
			case 4:
				$pnf = 'Programa Nacional De Formación en Electricidad';
				$tipo = 'PNF';
				$folios = 0;
				break;
			case 6:
				$pnf = 'Programa Nacional De Formación en Informática';
				$tipo = 'PNF';
				$folios = 0;
				break;
			case 8:
				$pnf = 'Programa Nacional De Formación en Mecánica';
				$tipo = 'PNF';
				$folios = 0;
				break;
			case '10':
				$pnf = 'Programa Nacional De Formación en Tecnología de Producción Agroalimentaria';
				$tipo = 'PNF';
				$folios = 0;
				break;
			// CARRERAS
			case 20:
				$pnf = 'Especialidad en Electricidad';
				$tipo = 'Especialidad';
				$folios = 379;
				break;
			case 25:
				$pnf = 'Especialidad en Geología y Minas';
				$tipo = 'Especialidad';
				$folios = 400;
				break;
			case 30:
				$pnf = 'Especialidad en Mecánica';
				$tipo = 'Especialidad';
				$folios = 440;
				break;
			case 35:
				$pnf = 'Especialidad en Sistemas Industriales';
				$tipo = 'Especialidad';
				$folios = 387;
				break;
			// PNF
			case 40:
				$pnf = 'Programa Nacional De Formación en Electricidad';
				$tipo = 'PNF';
				$folios = 315;
				break;
			case 45:
				$pnf = 'Programa Nacional De Formación en Geociencias';
				$tipo = 'PNF';
				$folios = 196;
				break;
			case 50:
				$pnf = 'Programa Nacional De Formación en Informática';
				$tipo = 'PNF';
				$folios = 178;
				break;
			case 55:
				$pnf = 'Programa Nacional De Formación en Ingeniería de Mantenimiento';
				$tipo = 'PNF';
				$folios = 351;
				break;
			case 60:
				$pnf = 'Programa Nacional De Formación en Mecánica';
				$tipo = 'PNF';
				$folios = 305;
				break;
			case 65:
				$pnf = 'Programa Nacional De Formación en Sistemas de Calidad y Ambiente';
				$tipo = 'PNF';
				$folios = 193;
				break;

			default:
				$folios = 0;
				break;
		}
		$options = new Options();
		$options->setIsRemoteEnabled(true);
		// $options->setDpi(100);
		$dompdf = new Dompdf($options);

		$html =  view('panel.admin.documentos.certificados.certificacion.pdf',['pnf' => $pnf, 'folios' => $folios,'tipo' => $tipo]);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4');
		$dompdf->render();
		return $dompdf->stream("Certificación del Programa - $pnf", array("Attachment" => false));

	}
}
