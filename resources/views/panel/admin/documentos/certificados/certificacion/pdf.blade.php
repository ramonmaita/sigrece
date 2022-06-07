<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Certificación del Programa</title>
</head>

<body>

    <main>


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

        <h2 align="center">CERTIFICACIÓN DEL PROGRAMA</h2>

        <br>

        <p align="justify" style="font-size: 12pt; line-height: 30px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Quien suscribe, @include(
                'panel.admin.documentos.certificados.partials.datos_rector',
                ['upt' => true]
            ), y
            @include(
                'panel.admin.documentos.certificados.partials.datos_secretaria',
                ['upt' => false]
            ), certifican: que el Contenido Programático {{ ($tipo == 'PNF') ? 'del' : 'de la' }}<span
                style="text-transform: uppercase; margin:0px;">
                <b>{{ $pnf }}</b></span>, consta de <b>{{ $folios }} folios</b> útiles, es traslado fiel y exacto de su
            original que reposa en los archivos de esta Universidad.

        </p>



        <p align="justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; En Ciudad Bolívar,
            a los <span class="linea">{{ Carbon::now()->format('d') }}</span> días del mes de
            <span class="linea">{{ $mes }}</span> de <span
                class="linea">{{ Carbon::now()->format('Y') }}</span>.
        </p>



        <div style="position: absolute ; bottom: 5px;">
            <table border="0" style="width: 100%;font-size:12pt;font-family:'Times New Roman', serif;" align="center"
                cellspacing="0" cellpadding="12">
                {{-- <tr align="center">
				<td>
					<h4 align="center" style="margin-bottom: 140px; margin-top: 70px;">

						<img src="{{ public_path() . '/img/firma.jpg' }}" alt="">

					</h4>
				</td>
			</tr> --}}

                <tr align="center">
                    <td>
                        <h4 align="center" style="margin-bottom: 2px;">
                            {{-- MsC. Yomely Josefina Pérez Fajardo --}}

                            Dr.C. Willfor Rafael Goudeth Galindo
                            <br>
                            Rector
                        </h4>
                        <small>Designado en Resolución Nº 013, Gaceta Oficial Nº 41.825, de fecha 19/02/2020</small>
                    </td>
                    <td>
                        <h4 align="center" style="margin-bottom: 2px;">
                            {{-- MsC. Yomely Josefina Pérez Fajardo --}}

                            MSc. Gabriela Betzabe Murillo Granados
                            <br>
                            Secretaría
                        </h4>
                        <small>Designada en Resolución Nº 045, Gaceta Oficial Nº 41.922, de fecha 15/07/2020</small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4 align="center" class="Estilo3" style="color: red; margin-bottom:2px !important;">“El
                            Sol de Venezuela Nace en el Esequibo” </h4>
                        <p align="center" style="font-size: 10pt;">
                            _________________________________________________________________________________________<br />
                            Dirección: N° 28, Edificio UPTBolívar, Calle Igualdad entre Rosario y Progreso, Casco
                            Histórico – <br>
                            Ciudad Bolívar, Municipio Angostura del Orinoco, Estado Bolívar. <br>
                            RIF: G-200020-70-9 <br>
                            Sitio Web: https://www.uptbolivar.edu.ve <br>
                            Correo Electrónico: rectorado.uptbolivar@gmail.com <br>
                            Twitter: @uptbolivar, Instagram: upt.bolivar, Facebook: UPT Bolívar <br>
                            Teléfonos: 0285-632-0664/ 0412-858-8681

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
