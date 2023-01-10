<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Constancia de Culminacion de Estudios</title>
</head>

<body>

    <main>


        @php

            $image_path = '/img/logouni.png';
            use Milon\Barcode\DNS1D;
            $d = new DNS1D();
            $d->setStorPath(__DIR__ . '/cache/');

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
			$pnf = '';
		switch ($alumno->Pnf->codigo) {
			// CARRERAS
			case 25:
				$pnf = 'Geología y Minas';
				break;
			case 30:
				$pnf = 'Mecánica' ;
				break;
			case 35:
				$pnf = 'Sistemas Industriales' ;
				break;
			// PNF
			case 40:
				$pnf = ($titulo == 'TSU') ? 'Electricidad' : 'Electricista' ;
				break;
			case 45:
				$pnf = 'Geociencias' ;
				break;
			case 50:
				$pnf = 'Informática' ;
				break;
			case 55:
				$pnf = ($titulo == 'TSU') ? 'Mantenimiento Industrial' : 'Mantenimiento' ;
				break;
			case 60:
				$pnf = ($titulo == 'TSU') ? 'Mecánica' : $retVal = ($graduando->Alumno->sexo == 'M') ? 'Mecánico' : 'Mecánica' ;
				break;
			case 70:
				$pnf = 'Orfreberia y Joyeria' ;
				break;
			case 75:
				$pnf = ($titulo == 'TSU') ? 'Materiales Instriales' : 'Metalurgia' ;
				break;
			case 80:
				$pnf = 'Higiene y Seguridad Laboral' ;
				break;

			default:
				# code...
				break;
		}
        @endphp

        <br><br>

        <h2 align="center">CONSTANCIA DE CULMINACIÓN DE ESTUDIOS</h2>

        <br><br>


        <p align="justify" style="font-size: 12pt; line-height: 30px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Quien suscribe, Directora Encargada De Registro Y Control De
            Actividades Académicas de la Universidad Politécnica Territorial
            Del Estado Bolívar, hace constar por medio de la presente que el ciudadano
            <u
                style="  text-transform: uppercase;"><b>{{ @$alumno->p_nombre . ' ' . $alumno->s_nombre . ' ' . $alumno->p_apellido . ' ' . $alumno->s_apellido }}</b></u>,
            portador de la cédula de identidad <u
                style=" "><b>N° {{ ($alumno->nacionalidad == 'V' || $alumno->nacionalidad == 'VENEZOLANO') ? 'V' : $alumno->nacionalidad }}-{{ number_format(@$alumno->cedula, 0, '', '.') }}</b></u>,
            cursó y aprobó satisfactoriamente todas las unidades curriculares del plan de estudio del <span style="text-transform: capitalize;">programa nacional de formación en {{ Str::lower($alumno->Pnf->nombre) }}</span>
			y se encuentra en espera de los tramites administrativos para optar al título de: <u><b style="text-transform: uppercase">
				@if ($titulo == 'TSU')
				{{ $retVal = ($alumno->sexo == 'M' || $alumno->sexo == 'MASCULINO') ? 'Técnico Superior  Universitario' : ' Técnica Superior  Universitaria'  }}
			@else
				{{ $retVal = ($alumno->sexo == 'M' || $alumno->sexo == 'MASCULINO') ? 'Ingeniero' : 'Ingeniera'  }}
			@endif

			@if ($titulo == 'ING')
				@if ($alumno->Pnf->codigo != 40 && $alumno->Pnf->codigo != 60)
					en
				@endif
			@else
				en
			@endif
			{{$pnf}}</b></u>.

        </p>

        <br>

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
                            Directora (E) De Registro y Control De Actividades Académicas
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p align="center" class="Estilo3">Revolucionando la educaciòn universitaria<br />
                            _________________________________________________________________________________________<br />
                            Calle Igualdad, entre Calle Progreso y Rosario, Nº 28, Edif UPTBolívar, Casco Historico de <br />
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
