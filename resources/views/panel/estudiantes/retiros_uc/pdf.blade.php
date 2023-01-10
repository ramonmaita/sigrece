@php
	// dd($nota_final);
    // ini_set('max_execution_time', 90);
	error_reporting(0);
	use Carbon\Carbon;
	Carbon::setLocale('America/Caracas');
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
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Retiro de UC</title>
	<style>
		@page {
			margin-top: 100px;
			margin-bottom: 60px;
			margin-right: 50px;
			margin-left: 50px;

		}
   		header { position: fixed; top: -80px; left: 0px; right: 0px;  height: auto; background-size: 80%; font-size: 10pt; font-family: 'Times New Roman'; }
    	footer { position: fixed; bottom: -80px; left: 0px; right: 0px;/* background-color: lightblue;*/ height: 50px;  }
    	@page :first{
    		margin-top: 50px;
			margin-bottom: 60px;
			margin-right: 50px;
			margin-left: 50px;
		}

		#asignaturas th{
			font-size: 8pt;
		}
		#asignaturas td{
			font-size: 10pt;
			font-family: 'times new roman';
			border-bottom: 1px dashed lightgrey;
		}
		p > span{
			font-weight: 600;
			/* padding-right: 20px;
			padding-left: 20px; */
			border-bottom: 1px solid #000;
		}
		.parrafo{
			font-family: 'Times New Roman';
			line-height: 20px;
		}
		.linea{
			border-bottom: 1px solid #000;
			padding-bottom: 8px !important;
		}
		#obeservaciones{
			font-size: 10pt;
		}
	</style>
</head>
<body>
	<header >
		<span>
			CONSTACIA DE:
			<span class="linea" style="text-transform: uppercase;">
			 {{ $alumno->p_nombre.' '.$alumno->s_nombre.' '.$alumno->p_apellido.' '.$alumno->s_apellido}}
			</span>
		</span>

		<span style="float: right;">
			N° DE CÉDULA:
			<span class="linea">
				{{ number_format($alumno->cedula,0,'','.') }}
			</span>
		</span>
		<br>
		<span>
			PROGRAMA NACIONAL DE FORMACIÓN:
			<span class="linea">
				{{ $alumno->Pnf->nombre }}
			</span>
		</span>
	</header>
	<footer>
		<div style="position: absolute ; bottom: 5px;">
			<table  border="0" style="width: 70%;font-size:10pt;font-family:'Times New Roman', serif;margin-top-15px;" align="center" cellspacing="0" cellpadding="0" >

					<tr align="center">
					<td style="font-size: 12pt">__________________________________________<br>
				Ing. Ramón Antonio Maita Bolívar{{-- Dulce María José Pérez Suárez  MsC.Yomely Josefina Pérez Fajardo --}}  <br /> Director{{-- de la Dirección --}} De Registro Y Control De Actividades Académicas </p></td></tr>
			<tr>
				<td><p align="center" class="Estilo3">Revolucionado La educaciòn Universitaria<br style="margin-top: 0px;" />
				 _____________________________________________________________________________________________________<br />
				Calle Igualdad, entre Calle Progreso y Rosario, Nº 28, Edif IUTEB, Casco Historico de <br />
				Ciudad Bolivar - Estado Bolivar - Venezuela  - Telefono (0285) 6340339, Email: iuteb.rrpp@gmail.com </p></td>

			</tr>

			</table>
		</div>
	</footer>
	<main style="margin-bottom: 140px;/*140px*/ margin-top: -50px;">


		<img src="{{ asset('/img/cintillo.png') }}" style='width:100%;'>
		<br>
		<h3 align="center"><u>SOLICITUD DE RETIRO</u></h3>
		<table>
			<tr>
				<th>Nombres</th>
				<th>Apellidos</th>
			</tr>
			<tr>
				<td>{{ $alumno->nombres }}</td>
				<td>{{ $alumno->apellidos }}</td>
			</tr>
			<tr>
				<th>Cédula</th>
				<th>PNF</th>
			</tr>
			<tr>
				<td>{{ number_format($alumno->cedula,0,'','.') }}</td>
				<td>{{ $alumno->Pnf->nombre }}</td>
			</tr>
		</table>

		<table width="100%" border="0" cellspacing="0" cellpadding="3" id="asignaturas">
			<thead style="border-top: 3px solid #000; border-bottom: 3px solid #000; margin-bottom: 10px;">
				<tr>
					<th width="8%" style="padding-top: 10px; padding-bottom: 10px;" >PERÍODO</th>
					<th width="10%" style="padding-top: 10px; padding-bottom: 10px;" >TRAYECTO</th>
					<th width="55%" style="padding-top: 10px; padding-bottom: 10px;" >UNIDAD CURRICULAR</th>
					<th width="15%" style="padding-top: 10px; padding-bottom: 10px;" >SECCIÓN</th>
				</tr>
			</thead>
			<br>
			<tbody style="margin-top: 100px !important;">

			</tbody>
		</table>
	</main>

</body>
</html>
