<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Constancia de Estudios</title>
</head>

<body>

    <main>


        @php

            $image_path = '/img/logouni.png';
            use Milon\Barcode\DNS1D;
            $d = new DNS1D();
            $d->setStorPath(__DIR__ . '/cache/');
            switch ($trayecto) {
                case 0:
                    $trayecto = 'TRAYECTO INICIAL';
                    break;
                case 1:
                    $trayecto = 'PRIMER TRAYECTO';
                    break;
                case 2:
                    $trayecto = 'SEGUNDO TRAYECTO';
                    break;
                case 3:
                    $trayecto = 'TERCER TRAYECTO';
                    break;
                case 4:
                    $trayecto = 'CUARTO TRAYECTO';
                    break;
                case 5:
                    $trayecto = 'QUINTO TRAYECTO';
                    break;

                default:
                    # code...
                    break;
            }
        @endphp
        {{-- <img src="{{ asset('img/logouni.png') }}"> --}}
        <table style='width:700px;' align='center'>


            <tr>
                <td><img src="{{ asset('img/cintillo.png') }}" style='width:700px;'></td>
            </tr>

        </table>


        @php
            use Carbon\Carbon;

            $fecha = Carbon::now();

            $fecha = Carbon::parse($fecha)->format('d-m-Y');
            // $year = Carbon::now()->format('Y');
            $year = 2021;
            switch (Carbon::now()->format('m')) {
                case 1:
                    $mes = 'Enero';
                    break;
                case 2:
                    $mes = 'Febrero';
                    break;
                case 3:
                    $mes = 'Marzo';
                    break;
                case 4:
                    $mes = 'Abril';
                    break;
                case 5:
                    $mes = 'Mayo';
                    break;
                case 6:
                    $mes = 'Junio';
                    break;
                case 7:
                    $mes = 'Julio';
                    break;
                case 8:
                    $mes = 'Agosto';
                    break;
                case 9:
                    $mes = 'Septiembre';
                    break;
                case 10:
                    $mes = 'Octubre';
                    break;
                case 11:
                    $mes = 'Noviembre';
                    break;
                case 12:
                    $mes = 'Diciembre';
                    break;

                default:
                    $mes = '';
                    break;
            }
        @endphp

        <br><br><br>

        <h2 align="center">CONSTANCIA DE ESTUDIO</h2>

        <br><br>
        <br>

        <p align="justify" style="font-size: 12pt; line-height: 30px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Quien suscribe, jefa de la Dirección De Registro Y Control De
            Actividades Académicas de la Universidad Politécnica Territorial
            Del Estado Bolívar, hace constar por medio de la presente que el ciudadano
            <u
                style="  text-transform: uppercase;"><b>{{ @$alumno->p_nombre . ' ' . $alumno->s_nombre . ' ' . $alumno->p_apellido . ' ' . $alumno->s_apellido }}</b></u>,
            portador de la cédula de identidad <u
                style=" "><b>{{ number_format(@$alumno->cedula, 0, '', '.') }}</b></u>,
            cursa estudio en esta casa de Educación universitaria en el Programa Nacional de Formación
            <u
                style=" "><b>{{ @$alumno->Pnf->nombre }}</b></u>,
            en el <u
                style=" "><b>{{ @$trayecto }}</b></u>,
            durante el periodo académico <u
                style=" "><b>{{ $year }}</b></u>,
            desde <u style=" "><b>Mayo
                    del {{ $year }}
			hasta Marzo {{ $year+1 }}.</b></u>
            {{-- @if ($trayecto == 0)
			@if (Carbon::parse($inscrito->fecha)->format('m') > 07)
				Septiembre del 2018 hasta Diciembre 2018.
			@else
				Mayo del 2018 hasta Julio 2018.
			@endif
		@else
			<span style="border-bottom: 1px solid #000; padding-right: 5px; padding-left: 5px;"><b>Enero
			del 2018 hasta Diciembre 2018.</b></span>
		@endif --}}
        </p>

        <br><br>

        <p align="justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Constancia que se expide a solicitud de parte interesada, en
            Ciudad Bolívar a los <span class="linea">{{ Carbon::now()->format('d') }}</span> días del mes de <span
                class="linea">{{ $mes }}</span> de <span
                class="linea">{{ Carbon::now()->format('Y') }}</span>
        </p>



        <div style="position: absolute ; bottom: 5px;">
            <table border="0" style="width: 70%;font-size:12pt;font-family:'Times New Roman', serif;margin-top-15px;"
                align="center" cellspacing="0" cellpadding="0">
                {{-- <tr align="center">
				<td>
					<h4 align="center" style="margin-bottom: 140px; margin-top: 70px;">

						<img src="{{ public_path() . '/img/firma.jpg' }}" alt="">

					</h4>
				</td>
			</tr> --}}

                <tr align="center">
                    <td>
                        <h4 align="center" style="margin-bottom: 140px;">
                            {{-- MsC. Yomely Josefina Pérez Fajardo --}}

							Ing. Dulce María José Pérez Suárez
                            <br>
                            Jefa Encargada de la Dirección De Registro Y Control De Actividades Académicas
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p align="center" class="Estilo3">Revolucionando la educaciòn universitaria<br />
                            _____________________________________________________________________________________________________<br />
                            Calle Igualdad, entre Calle Progreso y Rosario, Nº 28, Edif IUTEB, Casco Historico de <br />
                            Ciudad Bolivar - Estado Bolivar - Venezuela - Telefono (0285) 6340339
                        </p>
                    </td>

                </tr>

            </table>
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
