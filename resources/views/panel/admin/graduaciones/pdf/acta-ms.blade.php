@php
use Carbon\Carbon;
Carbon::setLocale('es');

@endphp


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Acta De Grado</title>
	<style>
		@font-face {
		  font-family: 'prince valiant';
		  src: local('prince valiant'),
		       url({{ public_path().'/fonts/PrinceValiant.woff' }}) format('truetype');
		}
		@font-face {
		  font-family: 'gregorian';
		  src: local('gregorian'),
		       url({{ public_path().'/fonts/GregorianFLF.ttf' }}) format('truetype');
		}
		body{
			font-family: 'Times New Roman';
			/*font-family: verdana;*/
			font-size: 12pt;
			background-image: url({{ public_path().'/img/fondo-acta3.png' }})  ;
		}

		body > p , body > span , body > table {

			margin-right: 80px;
			margin-left: 45px;
		}
		@page {
			margin-top: 0px;
			margin-bottom: 0px;
			margin-right: 0px;
			margin-left: 0px;

		}

		p{
			line-height: 1.6;
		}

		.datos{
			font-family: 'gregorian';
			font-size: 14pt;
			border-bottom: 1px solid #000;
			padding: 30 30;
		}

		.page-break {
		    page-break-after: always;
		}
	</style>
</head>
<body>

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
				$resolucion = 'según Resolución 268, del 24/10/2016, publicado en Gaceta Oficial Número 41021, del 01/11/2016';
				break;
			case 4:
				$pnf = 'Electricidad' ;
				$resolucion = 'el Artículo 21,  Ordinal 7  del Reglamento de Institutos y Colegios Universitarios, según Resolución 865, del 27/09/1995, publicado en Gaceta Oficial Número 4995, del 31/10/1995';
				break;
			case 6:
				$pnf = ($graduando->titulo == 1) ? 'Informática' : 'Sistemas' ;
				$resolucion = 'según Decreto N° 1393, publicado en Gaceta Oficial Número 39771 del 04/10/2011';
				break;
			case 8:
				$pnf = 'Mecánica' ;
				$resolucion = 'el Artículo 21,  Ordinal 7  del Reglamento de Institutos y Colegios Universitarios, según Resolución 865, del 27/09/1995, publicado en Gaceta Oficial Número 4995, del 31/10/1995';
				break;
			case 10:
				$pnf = 'Tecnología de Producción Agroalimentaria';
				$resolucion = 'según Resolución N° 4716, publicado en Gaceta Oficial Número 40262 del 01/10/2013';
			break;
			case 12:
				break;
		// CARRERAS
		case 25:
			$pnf = 'Geología y Minas';
			$resolucion = 'el Artículo 21,  Ordinal 7  del Reglamento de Institutos y Colegios Universitarios, según Resolución 865, del 27/09/1995, publicado en Gaceta Oficial Número 4995, del 31/10/1995';
			break;
		case 30:
			$pnf = 'Mecánica' ;
			$resolucion = 'el Artículo 21,  Ordinal 7  del Reglamento de Institutos y Colegios Universitarios, según Resolución 865, del 27/09/1995, publicado en Gaceta Oficial Número 4995, del 31/10/1995';
			break;
		case 35:
			$pnf = 'Sistemas Industriales' ;
			$resolucion = 'el Artículo 21,  Ordinal 7  del Reglamento de Institutos y Colegios Universitarios, según Resolución 865, del 27/09/1995, publicado en Gaceta Oficial Número 4995, del 31/10/1995';
			break;
		// PNF
		case 40:
			$pnf = ($graduando->titulo == 1) ? 'Electricidad' : 'Electricista' ;
			$resolucion = 'según Resolución N° 3195, publicado en Gaceta Oficial Número 39058 del 13/11/2008';
			break;
		case 45:
			$pnf = 'Geociencias' ;
			$resolucion = 'según Resolución N° 353, publicado en Gaceta Oficial Número 39431 del 25/05/2010';
			break;
		case 50:
			$pnf = 'Informática' ;
			$resolucion = 'según Resolución N° 3498, publicado en Gaceta Oficial Número 39098 del 14/01/2009';
			break;
		case 55:
			$pnf = ($graduando->titulo == 1) ? 'Mantenimiento Industrial' : 'Mantenimiento' ;
			$resolucion = 'según Resolución N° 3193, publicado en Gaceta Oficial Número 39058 del 13/11/2008';
			break;
		case 60:
			$pnf = ($graduando->titulo == 1) ? 'Mecánica' : $retVal = ($graduando->sexo == 'M') ? 'Mecánico' : 'Mecánica' ;
			$resolucion = 'según Resolución N° 3194, publicado en Gaceta Oficial Número 39058 del 13/11/2008';
			break;
		case 65:
			$pnf = 'Sistemas de Calidad y Ambiente' ;
			$resolucion = 'según Resolución N° 619, publicado en Gaceta Oficial Número 39502 del 03/09/2010';

			break;

		default:
			# code...
			break;
	}

	$contador = 1;
@endphp
	{{-- <img src="{{ public_path().'/img/logouni.png' }}" alt="" width="100%"> --}}


	<table width="100%" style="margin: 0px 90px 00px 35px; padding-top: 100px; ">
		<tr>
			<th align="left">Nro. {{$graduando->nro_titulo}}</th>
			<th align="right">Folio: {{$graduando->nro_acta}}</th>
		</tr>
	</table>
	<br><br>


	<br>
	<center>
		<span  style="font-family: 'gregorian'; font-size: 28pt; text-align: center; margin-top: 8px;">
			Acta de Grado
		</span>
	</center>
	<br><br>

	<p style="text-align: justify;">
		Hoy {{Carbon::parse($graduando->egreso)->format('d')}} de {{strtolower($mes) }} del año {{Carbon::parse($graduando->egreso)->format('Y')}}, en Ciudad Bolívar Estado Bolívar. El Rector y la Secretaria  de la Universidad Politécnica Territorial Del Estado Bolívar, en uso de la atribución que le confiere {{$resolucion}}, expide el Título de {{ ($graduando->titulo == 2) ? ':' : '' }}

		@if ($graduando->titulo == 1)
			{{ $retVal = ($graduando->sexo == 'M') ? 'Técnico Superior  Universitario' : ' Técnica Superior  Universitaria'  }}
			en:
		@endif

		@if ($graduando->titulo == 3)
			Técnico Superior  Universitario en la Especialidad de:
		@endif
		{{-- @if ($graduando->titulo != 'TSU')
			@if ($graduando->pnf != 40 && $graduando->pnf != 60)
				en
			@endif
		@else
			en
		@endif
		: --}}
	</p>

{{-- 	<br> --}}
	<p style="font-family: 'gregorian'; font-size: 28pt; text-align: center !important; margin-top: 0px !important;">


			@if($graduando->titulo == 2)
				{{ $retVal = ($graduando->sexo == 'M') ? 'Ingeniero' : 'Ingeniera'  }}
				@if ($graduando->pnf != 40 && $graduando->pnf != 60)
					en
				@endif
			@endif

			{{$pnf}}

	</p>
{{-- 	<br> --}}

	<p style="text-align: justify;">
		{{ $retVal = ($graduando->sexo == 'M') ? 'Al ' : 'A la'  }} Ciudadan{{ $retVal = ($graduando->sexo == 'M') ? 'o' : 'a'  }}: <span class="datos" style="text-transform: capitalize !important;"> {{ ucwords(mb_strtolower(' '.$graduando->apellidos,"UTF-8" )) }}, {{ ucwords(mb_strtolower(' '.$graduando->nombres,"UTF-8" )) }}  </span> titular  {{ ($graduando->nacionalidad == 'V') ? 'de la Cédula de Identidad' : 'del Pasaporte'  }} número: <span class="datos" style="font-size: 12pt !important">{{ ($graduando->nacionalidad == 'V') ? $graduando->nacionalidad.'-'.$graduando->cedula : $graduando->cedula  }}</span>, {{ $retVal = ($graduando->sexo == 'M') ? 'nacido' : 'nacida'  }} en <span class="datos" style="text-transform: capitalize !important;"> {{ mb_strtolower( $graduando->l_nacimiento,"UTF-8" ) }}</span>, el  <span class="datos" style="font-size: 12pt !important">{{ Carbon::parse($graduando->f_nacimiento)->format('d/m/Y')}}</span>, por haber aprobado el plan de estudios en tal opción y haber cumplido con los requisitos de ley que rigen la materia. Para constancia se levanta la presente Acta y firma el Rector, la Secretaria y el Graduando.
	</p>

	<br>
	<p align="center">
		{{-- En Ciudad Bolívar, a los tres días del mes de agosto del año dos mil dieciocho. --}}
		En Ciudad Bolívar, a los {{ strtolower($dia) }} días del mes de {{strtolower($mes) }} del año dos mil {{ strtolower($graduando->numero_letras(Carbon::parse($graduando->egreso)->format('y'))) }}.
		<br>
		Años: {{Carbon::parse($graduando->egreso)->format('Y') - 1810 }} de la Independencia y {{Carbon::parse($graduando->egreso)->format('Y') - 1859 }} de la Federación.
	</p>

	<div style="position: absolute ; bottom: 80px;">
		<table  border="0" style="width:100%;font-size:12pt;font-family:'Times New Roman', serif;margin-top-15px;" align="center" cellspacing="0" cellpadding="0" >

			<tr>
				<th align="center"> Dr. C. Willfor Rafael Goudeth Galindo <br> Rector</th>
				<th align="center">MsC. Gabriela Betzabe Murillo Granados <br> Secretaria</th>
			</tr>
			<tr>
				<th colspan="2" style="padding-top: 70px; margin-right: 100px;" align="center">
					El Graduando
				</th>
			</tr>

		</table>
	</div>

</body>
</html>
