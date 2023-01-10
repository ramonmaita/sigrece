<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Certificación de Emisión de Titulo</title>
</head>

<body>

    <main>
        @php
            $pnf = '';
            switch ($datos_graduando->pnf) {
                // MISION SUCRE
                case 2:
                    $pnf = 'Geología y Minas';
                    break;
                case 4:
                    $pnf = 'Electricidad';
                    break;
                case 6:
                    $pnf = $datos_graduando->titulo == 1 ? 'Informática' : 'Sistemas';
                    break;
                case 8:
                    $pnf = 'Mecánica';
                    break;
                case '10':
                    $pnf = 'Tecnología de Producción Agroalimentaria';
                    break;
                // CARRERAS
                case 25:
                    $pnf = 'Geología y Minas';
                    break;
                case 30:
                    $pnf = 'Mecánica';
                    break;
                case 35:
                    $pnf = 'Sistemas Industriales';
                    break;
                // PNF
                case 40:
                    $pnf = $datos_graduando->titulo == 1 ? 'Electricidad' : 'Electricista';
                    break;
                case 45:
                    $pnf = 'Geociencias';
                    break;
                case 50:
                    $pnf = 'Informática';
                    break;
                case 55:
                    $pnf = $datos_graduando->titulo == 1 ? 'Mantenimiento Industrial' : 'Mantenimiento';
                    break;
                case 60:
                    $pnf = $datos_graduando->titulo == 1 ? 'Mecánica' : ($retVal = $datos_graduando->Alumno->sexo == 'M' ? 'Mecánico' : 'Mecánica');
                    break;
                case 65:
                    $pnf = 'Sistemas de Calidad y Ambiente';
                    break;

                default:
                    # code...
                    break;
            }
        @endphp

        @php

            $image_path = '/img/cintillo_nuevo.png';
            use Milon\Barcode\DNS1D;
            $d = new DNS1D();
            $d->setStorPath(__DIR__ . '/cache/');
        @endphp
        {{-- <img src="{{ asset('img/logouni.png') }}"> --}}
        <table style='width:700px;' align='center'>


            <tr>
                <td><img src="{{ asset('img/cintillo_nuevo.png') }}" style='width:700px;'></td>
            </tr>

        </table>


        @php
            use Carbon\Carbon;

            $fecha = Carbon::now();

            $fecha = Carbon::parse($fecha)->format('d-m-Y');
            // $year = Carbon::now()->format('Y');
            $year = 2021;
				switch (Carbon::parse($datos_graduando->egreso)->format('m')) {
                case 1:
                    $mes_egreso = 'Enero';
                    break;
                case 2:
                    $mes_egreso = 'Febrero';
                    break;
                case 3:
                    $mes_egreso = 'Marzo';
                    break;
                case 4:
                    $mes_egreso = 'Abril';
                    break;
                case 5:
                    $mes_egreso = 'Mayo';
                    break;
                case 6:
                    $mes_egreso = 'Junio';
                    break;
                case 7:
                    $mes_egreso = 'Julio';
                    break;
                case 8:
                    $mes_egreso = 'Agosto';
                    break;
                case 9:
                    $mes_egreso = 'Septiembre';
                    break;
                case 10:
                    $mes_egreso = 'Octubre';
                    break;
                case 11:
                    $mes_egreso = 'Noviembre';
                    break;
                case 12:
                    $mes_egreso = 'Diciembre';
                    break;

                default:
                    $mes_egreso = '';
                    break;
            }

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

        <br><br>

        <h2 align="center">CERTIFICACIÓN DE EMISIÓN DE TÍTULO</h2>

        <br>

        <p align="justify" style="font-size: 12pt; line-height: 30px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Quien suscribe, @include('panel.admin.documentos.certificados.partials.datos_rector',['upt' => true]), y @include('panel.admin.documentos.certificados.partials.datos_secretaria',['upt' => false]), hacen constar que el título de<span style="text-transform: uppercase; margin:0px;">
				<b>
						@if ($datos_graduando->titulo == 1)
							{{ $retVal = @$datos_graduando->Alumno->sexo == 'M' || $datos_graduando->sexo == 'M' ? 'Técnico Superior  Universitario' : ' Técnica Superior  Universitaria' }}
							en
						@endif

						@if ($datos_graduando->titulo == 3)
							Técnico Superior Universitario en la Especialidad de
						@endif
						@if ($datos_graduando->titulo == 2)
							{{ $retVal = @$datos_graduando->Alumno->sexo == 'M' || $datos_graduando->sexo == 'M' ? 'Ingeniero' : 'Ingeniera' }}
							@if ($datos_graduando->pnf != 40 && $datos_graduando->pnf != 60)
								en
							@endif
						@endif

						{{ $pnf }}</b></span>, {{ ($datos_graduando->sexo == 'F' || $datos_graduando->sexo == 'FEMENINO') ? 'de la ciudadana':'del ciudadano' }}: <b>{{ ($datos_graduando->Alumno) ? $datos_graduando->Alumno->nombres.' '.$datos_graduando->Alumno->apellidos : $datos_graduando->nombres.' '.$datos_graduando->apellidos }}</b>, titular de cédula de identidad
            <b>N° {{ ($datos_graduando->Alumno) ? $datos_graduando->Alumno->nacionalidad : $datos_graduando->nacionalidad }}-{{ number_format($datos_graduando->cedula, 0, ',', '.') }}</b>, fue emitido por esta universidad previo cumplimiento de los requisitos legales para su
            conferimiento y asentado en el acta N° <b>{{ $datos_graduando->nro_titulo}}</b>, Folio <b>{{ $datos_graduando->nro_acta }}</b>, del libro N° <b>{{ $datos_graduando->libro }}</b>, de fecha {{ Carbon::parse($datos_graduando->egreso)->format('d') }} de {{ $mes_egreso }} del año {{ Carbon::parse($datos_graduando->egreso)->format('Y') }}.

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



        <p align="justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Constancia que se expide a petición de la parte interesada en Ciudad Bolívar, a los <span class="linea">{{ Carbon::now()->format('d') }}</span> días del mes de
            <span class="linea">{{ $mes }}</span> de <span
                class="linea">{{ Carbon::now()->format('Y') }}</span>.
        </p>



        @include('panel.admin.documentos.certificados.partials.footer')
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
