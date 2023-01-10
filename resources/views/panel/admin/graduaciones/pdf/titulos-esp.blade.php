@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Titulo</title>
	<style>
		@font-face {
		  font-family: 'prince valiant';
		  src: local('prince valiant'),
		       url({{ asset('/fonts/PrinceValiant.woff') }}) format('truetype');
		}
		@font-face {
		  font-family: 'gregorian';
		  src: local('gregorian'),
		       url({{ asset('/fonts/GregorianFLF.ttf') }}) format('truetype');
		}
		@font-face {
		  font-family: 'american_text_bt';
		  src: local('american_text_bt'),
		       url({{ asset('/fonts/american_text_bt.ttf') }}) format('truetype');
		}
		body, h1, h2, h3, h4, h5 {
			font-family: 'american_text_bt';
			width: 100%;
			/*border: solid 1px #000;*/
		}
		p{
			font-size: 12pt;
			line-height: 20px;
		}
		.inicial{
			/*color: #990000;*/
			color: blue;
			/*font-family: 'gregorian';*/
		}
		.cont{
				width: 100%;
				/*width: 700px;*/
				margin: 0 auto;
				position: relative;
			}
		/*.center-img {
			width: 100%;
		    position: absolute;
		    top: 10%;
		    left: 30%;
		    transform: translate(-50%, -50%);
		}
		.img-f { */
			/*padding-top: 5%;
			margin-top: 50%;*/
		  /*  width: 100%;
		    height: auto;
		    opacity: 0.2;*/
		    /*border: 1px solid black;*/
		/*}*/
		.page-break {
		    page-break-after: always;
		}
	</style>
</head>
<body >
@foreach($graduandos as $graduando)
	@php

	$dia = '';
	switch (Carbon::parse($graduando->egreso)->format('d')) {
	    case 1:
	        $dia = 'UNO';
	        break;
	    case 2:
	        $dia = 'DOS';
	        break;
	    case 3:
	        $dia = 'TRES';
	        break;
	    case 4:
	        $dia = 'CUATRO';
	        break;
	    case 5:
	        $dia = 'CINCO';
	        break;
	    case 6:
	        $dia = 'SEIS';
	        break;
	    case 7:
	        $dia = 'SIETE';
	        break;
	    case 8:
	        $dia = 'OCHO';
	        break;
	    case 9:
	        $dia = 'NUEVE';
	        break;
	    case 10:
	        $dia = 'DIEZ';
	        break;
	    case 11:
	        $dia = 'ONCE';
	        break;
	    case 12:
	        $dia = 'DOCE';
	        break;
	    case 13:
	        $dia = 'TRECE';
	        break;
	    case 14:
	        $dia = 'CATORCE';
	        break;
	    case 15:
	        $dia = 'QUINCE';
	        break;
	    case 16:
	        $dia = 'DIECISÉIS';
	        break;
	    case 17:
	        $dia = 'DIECISIETE';
	        break;
	    case 18:
	        $dia = 'DIECIOCHO';
	        break;
	    case 19:
	        $dia = 'DIECINUEVE';
	        break;
	    case 20:
	        $dia = 'VEINTE';
	        break;
       case 21:
	        $dia = 'VEINTIUN';
	        break;
	    case 22:
	        $dia = 'VEINTIDOS';
	        break;
	    case 23:
	        $dia = 'VEINTITRES';
	        break;
	    case 24:
	        $dia = 'VEINTICUATRO';
	        break;
	    case 25:
	        $dia = 'VEINTICINCO';
	        break;
	    case 26:
	        $dia = 'VEINTISEIS';
	        break;
	    case 27:
	        $dia = 'VEINTISIETE';
	        break;
	    case 28:
	        $dia = 'VEINTIOCHO';
	        break;
	    case 29:
	        $dia = 'VEINTINUEVE';
	        break;
	    case 30:
	        $dia = 'TREINTA';
	        break;
	    case 31:
	        $dia = 'TREINTAIUN';
	        break;

	    default:
	        $dia = '';
	        break;
	}
	$year = '';
	switch (Carbon::parse($graduando->egreso)->format('y')) {
	    case 1:
	        $year = 'UNO';
	        break;
	    case 2:
	        $year = 'DOS';
	        break;
	    case 3:
	        $year = 'TRES';
	        break;
	    case 4:
	        $year = 'CUATRO';
	        break;
	    case 5:
	        $year = 'CINCO';
	        break;
	    case 6:
	        $year = 'SEIS';
	        break;
	    case 7:
	        $year = 'SIETE';
	        break;
	    case 8:
	        $year = 'OCHO';
	        break;
	    case 9:
	        $year = 'NUEVE';
	        break;
	    case 10:
	        $year = 'DIEZ';
	        break;
	    case 11:
	        $year = 'ONCE';
	        break;
	    case 12:
	        $year = 'DOCE';
	        break;
	    case 13:
	        $year = 'TRECE';
	        break;
	    case 14:
	        $year = 'CATORCE';
	        break;
	    case 15:
	        $year = 'QUINCE';
	        break;
	    case 16:
	        $year = 'DIECISÉIS';
	        break;
	    case 17:
	        $year = 'DIECISIETE';
	        break;
	    case 18:
	        $year = 'DIECIOCHO';
	        break;
	    case 19:
	        $year = 'DIECINUEVE';
	        break;
	    case 20:
	        $year = 'VEINTE';
	        break;

	    default:
	        $year = '';
	        break;
	}
	switch (Carbon::parse($graduando->egreso)->format('m')) {
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
		switch ($graduando->pnf) {
			// MISION SUCRE
			case 2:
				$pnf = 'Geología y Minas';
				break;
			case 4:
				$pnf = 'Electricidad' ;
				break;
			case 6:
				$pnf = ($graduando->titulo == 1) ? 'Informática' : 'Sistemas' ;
				break;
			case 8:
				$pnf = 'Mecánica' ;
				break;
			case '10':
				$pnf = 'Tecnología de Producción Agroalimentaria';
				break;

			// CARRERAS
			case 20:
				$pnf = 'Electricidad';
				break;
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
				$pnf = ($graduando->titulo == 1) ? 'Electricidad' : 'Electricista' ;
				break;
			case 45:
				$pnf = 'Geociencias' ;
				break;
			case 50:
				// $pnf = 'Informática' ;
				$pnf = 'Energía Electrica' ;
				break;
			case 55:
				$pnf = ($graduando->titulo == 1) ? 'Mantenimiento Industrial' : 'Mantenimiento' ;
				break;
			case 60:
				$pnf = ($graduando->titulo == 1) ? 'Mecánica' : $retVal = ($graduando->Alumno->sexo == 'M') ? 'Mecánico' : 'Mecánica' ;
				break;
			case 65:
				$pnf = 'Sistemas de Calidad y Ambiente' ;
				break;

			default:
				# code...
				break;
		}
	@endphp

	<div class="cont" style="background-color:rgba(255, 255, 255, 0.9); background-image: url({{ asset('/img/fondo-titulo.png') }});">

		<div class="center-img">
			<table border="0"  align="center" cellpadding="0" cellspacing="0" style="margin-top: -20px;" width="100%">
				<tr>
					<td width="25%"></td>
					<td width="50%">


							<center>

							<img src="{{ asset('/img/escudo.jpg') }}" alt="" height="160px" width="160px"{{--  style="margin-left: 190px;" --}} >

							</center>

					</td>
					<td align="right" width="25%">
						<img src="data:image/png;base64,{{DNS2D::getBarcodePNG(route('verificar_graduando',['nacionalidad' => $graduando->nacionalidad, 'cedula' => $graduando->cedula]), 'QRCODE')}}" alt="barcode" height="120px" width="120px"  style="align: right " />
						{{-- <img src="data:image/png;base64,{{DNS2D::getBarcodePNG('https:sigrece.uptbolivar.com/'.$graduando->nacionalidad.'/'.$graduando->cedula.'/verificar/'.$graduando->nro_titulo, 'QRCODE')}}" alt="barcode" height="120px" width="120px"  style="align: right " /> --}}
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<center>
							<p style="font-size: 18pt; text-align: center; padding-top: 0px !important; line-height: 20px; margin-top: 0px; margin-bottom: 10px;">
								República Bolívariana de Venezuela
								<br>
								Ministerio del Poder Popular para la Educación Universitaria
							</p>
						</center>
					</td>
				</tr>
				{{-- <tr>
					<td colspan="3">
						<center>

							<span style="font-size: 16pt; text-align: center;">
							Ministerio del Poder Popular para Educación Universitaria, Ciencia y Tecnología
							</span>
						</center>
					</td>
				</tr> --}}
			</table>


			<p style="font-size: 18pt; text-align: center; margin-top: 10px !important; margin-bottom: 0px !important;">
				<span class="inicial">D</span>r. <span class="inicial">C</span>. <span class="inicial">W</span>illfor <span class="inicial">R</span>afael <span class="inicial">G</span>oudeth <span class="inicial">G</span>alindo
			</p>

			<p align="center" style="margin: 5px;">
				Rector de la
			</p>
			<span style="font-size: 18pt; text-align: center;">
				<center>
					{{-- <img src="{{ public_path().'/img/iuteb.png' }}" alt="" height="85px"> --}}
					<p style="font-size: 28pt; text-align: center; padding-top: 0px !important; line-height: 20px; margin: 10px; margin-bottom: 10px;">
						<span class="inicial">U</span>niversidad <span class="inicial">P</span>olitecnica <span class="inicial">T</span>erritorial del <span class="inicial">E</span>stado <span class="inicial">B</span>olívar
					</p>
				</center>
			</span>
			<p align="center" style="margin: 0px; font-size: 16pt;">
				Hace Constar
			</p>
			<p style="margin: 0px; font-size: 16pt;">
				Que {{ $retVal = ($graduando->sexo == 'M') ? 'el' : 'la'  }} Ciudadan{{ $retVal = ($graduando->sexo == 'M') ? 'o' : 'a'  }}{{ ($graduando->titulo == 1 ||  $graduando->titulo == 3) ? ':' : ':'  }}
			</p>
			<div style=" /*font-family: 'gregorian';*/ font-size: 26pt; text-align: center; margin-top: 0px; margin-bottom: 0px;">
				<center style="text-transform: capitalize !important;">
					{{ ucwords(mb_strtolower(' '.$graduando->nombres,"UTF-8" )) }}  {{ ucwords(mb_strtolower(' '.$graduando->apellidos,"UTF-8" )) }}
				</center>
			</div>
			<p align="center" style="font-size: 16pt; margin: 0px; ">
				Titular {{ ($graduando->nacionalidad == 'V') ? 'de la Cédula de Identidad' : 'del Pasaporte'  }} Número {{ ($graduando->nacionalidad == 'V') ? $graduando->nacionalidad.'-'.$graduando->cedula : $graduando->cedula  }}, natural de <span style="text-transform: capitalize !important;">{{ mb_strtolower( $graduando->l_nacimiento,"UTF-8" ) }}</span>, {{ $retVal = ($graduando->sexo == 'M') ? 'Nacido' : 'Nacida'  }} el {{ Carbon::parse($graduando->f_nacimiento)->format('d/m/Y')}}, aspirante al Título de

				@if ($graduando->titulo == 1)
					{{ $retVal = ($graduando->sexo == 'M') ? 'Técnico Superior  Universitario' : ' Técnica Superior  Universitaria'  }}
				@elseif ($graduando->titulo == 3)
					Técnico Superior  Universitario
				@else
					{{ $retVal = ($graduando->sexo == 'M') ? 'Ingeniero' : 'Ingeniera'  }}
				@endif

				@if ($graduando->titulo != 1)
					@if ($graduando->pnf != 40 && $graduando->pnf != 60)
						en
					@endif
				@else
					en
				@endif
				{{$pnf}}, cumplió con todos los requisitos exigidos por las leyes y reglamentos para obtenerlo, por lo cual, en nombre de la República y por autoridad de la Ley, le confiero el título de:
			</p>

			@if ($graduando->titulo == 1 || $graduando->titulo == 3)
			<span style="font-size: 26pt; text-align: center; margin-top: 0px;">
			@else
			<div style="font-size: 30pt;  text-align: center; margin-top: 0px;">
			@endif
				<center>
					@if ($graduando->titulo == 4)
						@php
							echo '<span class="inicial">E</span>specialista en '.$pnf;
						@endphp

					@elseif ($graduando->titulo == 5)
						@php
							echo '<span class="inicial">T</span>écnico <span class="inicial">S</span>uperior <span class="inicial">U</span>niversitario en:';
						@endphp

					@else

						{{-- @php
						echo $retVal = ($graduando->sexo == 'M') ? "<span class='inicial'>I</span>ngeniero" : "<span class='inicial'>I</span>ngeniera  $pnf";
						@endphp --}}
						@php

							if ($graduando->sexo == 'M'){
								$retVal = ($graduando->pnf != 40 && $graduando->pnf != 60) ? 'en ' : '';
								echo "<span class='inicial'>I</span>ngeniero ".$retVal."$pnf";
							}else{
								$retVal = ($graduando->pnf != 40 && $graduando->pnf != 60) ? 'en ' : '';
								echo "<span class='inicial'>I</span>ngeniera ".$retVal."$pnf";
							}
						@endphp
					@endif



					{{-- @if ($graduando->titulo != 1)
						@if ($graduando->pnf != 40 && $graduando->pnf != 60)
							en:
						@endif
					@else
						en:
					@endif --}}
				</center>
			</div>
			@if($graduando->titulo == 1 || $graduando->titulo == 3 )
			<span style=" /*font-family: 'gregorian';*/ font-size: 26pt; text-align: center; margin-top: 0px;">
				<center>
					{{$pnf}}
				</center>
			</span>
			@endif
			@php
				$p = $graduando->ira;
			@endphp
			<span style="font-size: 18pt; text-align: center; margin-top: 0px; padding-bottom:150px;">
				<center>
					Mención Géstion de Mantenimiento
				</center>
			</span>
			@if ($p >= 18.00 && $p <= 19.49)
				<span style="font-family: 'gregorian'; font-size: 16pt; text-align: center; margin-top: 0px; padding-bottom:150px;">
					<center>
						Menciòn Honorifica "Cum Laude"
					</center>
				</span>
			@endif
			@if ($p >= 19.50 && $p <= 20)
				<span style="font-family: 'gregorian'; font-size: 16pt; text-align: center; margin-top: 0px; padding-bottom:150px;">
					<center>
						Menciòn Honorifica  "Summa Cum Laude"
					</center>
				</span>
			@endif
			<p align="center" style="font-size: 16pt; margin: 0px; margin-top:5px !important">
				Tómese razón de este título en la Secretaría de la Universidad, y Reconózcase  en toda la República  {{ $retVal = ($graduando->sexo == 'M') ? 'al' : 'a la'  }} Ciudadan{{ $retVal = ($graduando->sexo == 'M') ? 'o' : 'a'  }}
				{{-- <span style="text-transform: capitalize !important;">
				{{ ucwords(mb_strtolower(' '.$graduando->nombres,"UTF-8" )) }}  {{ ucwords(mb_strtolower(' '.$graduando->apellidos,"UTF-8" )) }}</span>, como tal

				@if ($graduando->titulo == 1)
					{{ $retVal = ($graduando->sexo == 'M') ? 'Técnico Superior  Universitario' : 'Técnica Superior  Universitaria'  }}
				@elseif ($graduando->titulo == 3)
					Técnico Superior  Universitario

				@else
					{{ $retVal = ($graduando->sexo == 'M') ? 'Ingeniero' : 'Ingeniera'  }}
				@endif

				@if ($graduando->titulo != 1)
					@if ($graduando->pnf != 40 && $graduando->pnf != 60)
						en
					@endif
				@else
					en
				@endif
				{{$pnf}} --}}
				con todas las facultades y derechos que le otorgan las Leyes y Reglamentos.
				<br>
				En fé de lo cual Firmo el presente título en unión de la Secretaria y un Profesor. En Ciudad Bolívar, a los {{ strtolower($dia) }} días del  mes de {{ strtolower($mes) }} del año dos mil veintidos. Año {{Carbon::parse($graduando->egreso)->format('Y') - 1810 }} de la Independencia y {{Carbon::parse($graduando->egreso)->format('Y') - 1859 }} de la Federación.
			</p>
			<br>
			<br>


			<br>
			<div style="position: absolute ; bottom: 0px; margin-top: 25px; /*border: 1px solid #000;*/ " >
				<table width="100%" border="0" style="font-size: 12pt; margin-bottom: 10px;" cellpadding="0" cellspacing="0">
					<tr>
						<td width="33%">
							{{-- <br> --}}
							<span style="padding-top: 15px; "  valign="middle">
								Secretaria
							</span>
							<br>
							<span style="font-family:'Times New Roman', serif;">
								C.I. 11.226.408
							</span>
						</td>
						<td width="33%" style="padding-bottom: 40px"  valign="top">
							{{-- <br> --}}
							<span style="margin-left: 80px !important;">
								El Rector
							</span>
							<br>
							<span style="margin-left: 80px !important; font-family:'Times New Roman', serif;">
								C.I. 11.173.641
							</span>
						</td>
						<td width="33%" valign="bottom">
						{{-- <br> --}}
							<span style="margin-left: 100px !important; padding-top: 15px; ">
								{{-- Secretaria --}}
								El Profesor

							</span>
							<br>
							<span style="margin-left: 100px !important; font-family:'Times New Roman', serif;">
								{{-- C.I. 11.226.408 --}}
								C.I.

							</span>
						</td>
					</tr>
				</table>
				<table  border="0" style="width: 100%;font-size:10pt; margin-top:-15px; margin-bottom: -20px" align="center" cellspacing="0" cellpadding="0" >

					<tr>
						<td width="50%">
							<p style="font-size: 10pt !important">

								Oficina Principal Del Registro Público del
								<br>
								<span style="margin-left: 70px">de</span> <span style="margin-left: 70px">de 20</span>  <span style="margin-left: 40px"> Años {{substr(Carbon::parse($graduando->egreso)->format('Y') - 1810,0,-1) }} </span> <span style="margin-left: 40px"> y {{substr(Carbon::parse($graduando->egreso)->format('Y') - 1859,0,-1) }} </span>
								<br>
								con esta fecha y bajo el No.<span style="margin-left: 70px"> al folio del protocolo Único y Principal.</span>
								<br>
								Como ha sido registrado el presente Título: derecho a escrito Bs.
								<br>
								p.p: bs. <span style="margin-left: 50px">Título bs. </span><span style="margin-left: 50px"> Total bs. </span><span style="margin-left: 50px"> planilla n°. </span> <br>
							</p>
							{{-- <br> --}}
							<p style="text-align: center; font-size: 10pt !important">El Registro Principal</p>
						</td>
						<td width="50%" align="right">
						<br>
						<br>
						<br><br>
							<span style="margin-bottom: 0px; font-size: 10pt; bottom: 0px">
								No. <b class="times">{{$graduando->nro_titulo}}</b> Inscrito al Folio <b class="times">{{$graduando->nro_acta}}</b> del Libro No. <b class="times">{{$graduando->libro}}</b>
							</span>
						</td>
					</tr>


				</table>
			</div>

		</div>
	</div>
	<div class="page-break"></div>
@endforeach
</body>
</html>
