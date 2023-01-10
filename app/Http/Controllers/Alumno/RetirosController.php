<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Periodo;
use App\Models\Solicitud;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class RetirosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodo = Periodo::where('estatus',0)->first();
		$retiros = Solicitud::where('tipo','RETIRO DE UC')->where('periodo',$periodo->nombre)->groupBy(['solicitante_id','estatus','periodo'])->get();
		return view('panel.estudiantes.retiros_uc.index',['retiros' => $retiros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.estudiantes.retiros_uc.create');
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
    public function show($id)
    {

		return view('panel.estudiantes.retiros_uc.show_pdf');
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

	public function show_pdf()
	{
		return view('panel.estudiantes.retiros_uc.show_pdf');
	}

	public function pdf(Alumno $alumno)
	{
		// $alumno = Alumno::where('cedula',Auth::user()->cedula)->first();
		$html = view('panel.estudiantes.retiros_uc.pdf',['alumno' => $alumno]);
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
