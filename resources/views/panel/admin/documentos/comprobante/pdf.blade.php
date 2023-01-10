<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Comprobante</title>
</head>

<body>

    <main>


        @php

            $image_path = '/img/logouni.png';
            use Milon\Barcode\DNS2D;
            $d = new DNS2D();
            $d->setStorPath(__DIR__ . '/cache/');

            $random = rand(001, 999);
            $data = route('verificar-documentos.show_comprobante', [$periodo->nombre, $alumno->id, 1, $random]);

            use Carbon\Carbon;
            $inscrito = $alumno->Inscrito->where('periodo_id', $periodo->id)->first();
            $fecha = Carbon::parse($inscrito->fecha)->format('d-m-Y');
        @endphp
        <table style='width:700px;' align='center' border="0" style="position: absolute">


            <tr>
                <td colspan="2"><img src="{{ asset('img/cintillo.png') }}" style='width:700px;'></td>
            </tr>

            <tr>
                <td width='100%'>
                    <div align='center'><u>COMPROBANTE DE INSCRIPCI&Oacute;N</u></div>
                    <div align='center'><u>PROGRAMAS NACIONALES DE FORMACI&Oacute;N</u></div>
                    <div align='center'>Per&iacute;odo Acad&eacute;mico : {{ $periodo->nombre }}</div>
                </td>
                <td rowspan="2" align="center" valign="top">
                    @php echo '<img src="data:image/png;base64,' .$d->getBarcodePNG("$data", 'QRCODE') . '" alt="barcode"   />'; @endphp
                    <small style="font-size: 8pt !important;">
                        {{ $periodo->nombre }}-{{ $alumno->id }}-01-{{ $random }}
                    </small>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" style="width:100%;" align="center" cellspacing="0" cellpadding="0"
                        style="font-size:10pt;width:100%;font-family: 'Times New Roman', serif;">
                        <tr>
                            <td width="100%" align="left" colspan="2">

                                <table style="font-size:10pt;width:100%;font-family: 'Times New Roman', serif;">
                                    <tr>
                                        <td width="50%" style="text-transform: uppercase;">APELLIDOS: <u>
                                                {{ $alumno->apellidos }}</u></td>
                                        <td width="5%"></td>
                                        <td width="45%">P.N.F.: <u> {{ $alumno->pnf->nombre }}</u></td>
                                    </tr>

                                    <tr>
                                        <td width="50%" style="text-transform: uppercase;">NOMBRES: <u>
                                                {{ $alumno->nombres }}</u> </td>
                                        <td width="5%"></td>
                                        <td width="45%">FECHA DE INSCRIPCI&Oacute;N: <u> {{ $fecha }} </u>
                                        </td>
                                    </tr>

                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>
                                    <font size="13px">CEDULA DE IDENTIDAD: <u>
                                            {{ number_format($alumno->cedula, 0, '', '.') }}
                                        </u></font>
                                </b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                {{-- <img src="barcode/'.$ide.'.gif"  alt="codigo de barra" width="185" height="65" /> --}}
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>






        <center><b><u>UNIDADES CURRICULARES INSCRITAS </u></b></center><br>

        <table border="1" cellspacing="0" cellpadding="0"
            style="font-size:12pt;margin-top-15px;width:100%;font-family: "Times New Roman", serif;" align="center">

            <tr>
                <td width="100%">

                    <table width="100%" border="0" cellspacing="1" cellpadding="0"
                        style="font-size:11pt;margin-top-15px;">
                        <tr>
                            <th width="15%" align="left">
                                <div><b>Trayecto</b> </div>
                            </th>
                            <th width="15%" align="left">
                                <div><b>{{ Str::ucfirst(Str::lower($alumno->Plan->cohorte)) }}</b> </div>
                            </th>
                            <th width="35%">
                                <div><b>Nombre De La Unidad Curricular</b></div>
                            </th>
                            <th width="25%" align="right">
                                <div style="text-align: center; "><b>Secci&oacute;n</b></div>
                            </th>
                            {{-- <th width="15%"><div style="text-align: center;"><b>Turno</b></div> </th> --}}
                        </tr>
                    </table>

                </td>
            </tr>

        </table>

        {{-- {{ $inscrito->Inscripcion }} --}}
        <table width="100%" border="0" cellspacing="1" cellpadding="0" style="font-size:10pt;margin-top-15px;">
            {{-- @foreach ($alumno->asignaturas_inscritas($alumno->cedula) as $asignatura)
		<tr>
		    <td width="6%" align="center">
		    	<div>
					{{ @$asignatura->Asignatura->Trayecto->nombre }}
		    	</div>
			</td>
		    <td width="6%" align="center">
		     	<div>
					{{ @$asignatura->DesAsignatura->tri_semestre }}
		     	</div>
		    </td>


		    <td width="30%">
		    	<div>
		    		{{ @$asignatura->nombre_asignatura }}
		    	</div>
		    </td>

		    <td width="10%" style=" font-size: 10pt;">
		    	<div style="text-transform: uppercase;">
		    		{{ @$asignatura->seccion }}
		    	</div>
		    </td>

		    <td width="10%">
		    	<div>
		    		{{ @$asignatura->Seccion->turno }}
		    	</div>
		    </td>

     	</tr>
	@endforeach --}}
            @foreach ($inscrito->Inscripcion as $uc)
                @if (@$uc->RelacionDocenteSeccion->DesAsignatura->Asignatura->plan_id == $alumno->plan_id)
                    <tr>
                        <td width="6%" align="center">
                            <div>
                                {{ @$uc->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->nombre }}
                            </div>
                        </td>
                        <td width="6%" align="center">
                            <div>
                                {{ @$uc->RelacionDocenteSeccion->DesAsignatura->tri_semestre }}
                            </div>
                        </td>


                        <td width="30%">
                            <div>
                                {{ @$uc->RelacionDocenteSeccion->DesAsignatura->nombre }}
                            </div>
                        </td>

                        <td width="10%" style=" font-size: 10pt;">
                            <div style="text-transform: uppercase;">
                                {{ @$uc->RelacionDocenteSeccion->Seccion->nombre }}
                            </div>
                        </td>

                        {{-- <td width="10%">
				<div>
					{{ @$uc->RelacionDocenteSeccion->Seccion->turno }}
				</div>
			</td> --}}

                    </tr>
                @endif
            @endforeach

        </table>




        <div style="position: absolute ; bottom: -30px;">
            <table border="0"
                style="width: 70%;font-size:10pt;font-family:'Times New Roman', serif;margin-top-15px;" align="center"
                cellspacing="0" cellpadding="0">

                {{-- <tr align="center">
			<td>

			<img src="{{ public_path() . '/img/firma.jpg' }}" alt="">
			</td>
		</tr> --}}
                <tr align="center">
                    <td>
                        Este comprobante te acredita para asistir unicamente a la(s) seccion(es) descrita(s).<br />
                        De lo contrario, es exclusiva responsabilidad del estudiante presenciar unidades curriculares en
                        otras sección<br />
                        sin realizar el proceso de cambio correspondiente.<br>

                        <em><strong>CONSERVA ESTE DOCUMENTO, NO LO PIERDAS

                                <br><br>

                    </td>
                </tr>
                <tr align="center">
                    <td>__________________________________________<br>
                        FIRMA Y SELLO DE LA DIRECCIÓN DE <br /> REGISTRO Y CONTROL DE ACTIVIDADES ACADÉMICAS </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p align="center" class="Estilo3">Revolucionando la educaciòn universitaria<br />
                            _____________________________________________________________________________________________________<br />
                            Calle Igualdad, entre Calle Progreso y Rosario, Nº 28, Edif UPTBolívar, Casco Historico de
                            <br />
                            Ciudad Bolivar - Estado Bolivar - Venezuela - Telefono (0285) 6340339, Email:
                            iuteb.rrpp@gmail.com
                        </p>
                    </td>

                </tr>

            </table>
            <br>
            @php
                $inicio = \Carbon\Carbon::createFromFormat('H:i a', '01:00 AM');
                $fin = \Carbon\Carbon::createFromFormat('H:i a', '02:00 AM');
                $check_hora = \Carbon\Carbon::now()->between($inicio, $fin, true);
            @endphp
            <small>
                Generado el {{ \Carbon\Carbon::now()->format('d-m-Y') }} a
                @if (\Carbon\Carbon::now()->between(
                    \Carbon\Carbon::createFromFormat('H:i a', '01:00 AM'),
                    \Carbon\Carbon::createFromFormat('H:i a', '02:00 AM'),
                    true) ||
                    \Carbon\Carbon::now()->between(
                        \Carbon\Carbon::createFromFormat('H:i a', '01:00 PM'),
                        \Carbon\Carbon::createFromFormat('H:i a', '02:00 PM'),
                        true))
                    la
                @else
                    las
                @endif
                {{ \Carbon\Carbon::now()->format(' h:i:s A') }}
            </small>
        </div>
        {{-- <style>
.page-break {
    page-break-after: always;
}
</style>
	<div class="page-break"></div>
	<h1>Page 2</h1> --}}
    </main>
</body>

</html>
