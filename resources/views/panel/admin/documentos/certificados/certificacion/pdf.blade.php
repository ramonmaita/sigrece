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
