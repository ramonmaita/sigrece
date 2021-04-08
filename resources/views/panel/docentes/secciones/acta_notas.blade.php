@php
	use Carbon\Carbon;
	Carbon::setLocale('America/Caracas');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Notas</title>
	<style>
		@page {
			margin-top: 100px;
			margin-bottom: 60px;
			margin-right: 50px;
			margin-left: 50px;

		}
   		header { position: fixed; top: -80px; left: 0px; right: 0px;  height: auto; background-size: 80%; font-size: 10pt; font-family: 'Times New Roman'; }
    	footer { position: fixed; bottom: 0px; left: 0px; right: 0px;/* background-color: lightblue;*/ height: 50px;  }
    	@page :first{
    		margin-top: 50px;
			margin-bottom: 60px;
			margin-right: 50px;
			margin-left: 50px;
		}

		#asignaturas th , .asignaturas th  {
			font-size: 8pt;
		}
		#asignaturas td, .asignaturas td {
			font-size: 10pt;
			font-family: 'times new roman';
			border-bottom: 1px dashed lightgrey;
		}
		p > span{
			font-weight: 600;
			padding-right: 20px;
			padding-left: 20px;
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

	</header>
	<footer>
		<div style="bottom: 5px;">
			<table  border="1" style="width: 100%;font-size:10pt;font-family:'Times New Roman', serif;margin-top-15px;" align="center" cellspacing="0" cellpadding="0" >

				<tr>
					<td width="50%">
						DOCENTE: {{ (empty($detalles->Docente->nombre)) ? $detalles->docente : $detalles->Docente->nombre }}
						<br>
						CÉDULA: {{ (empty($detalles->Docente->cedula)) ? $detalles->cedula_docente : $detalles->Docente->cedula }}
						<br>
						FIRMA:
					</td>
					<td width="50%">
						FIRMA Y SELLO DEL DEPARTAMENTO ACADÉMICO:
						<br>
						<br>
						<br>
					</td>
				</tr>


			</table>
			<small>
				Generado: {{ \Carbon\Carbon::now()->format('d/m/Y h:i:s A') }}
			</small>
		</div>
	</footer>
	<main style="margin-bottom: 130px; margin-top: -50px;">

		<img src="{{ asset('/img/cintillo.png') }}" style='width:100%;'>
		<h5 align="center">CALIFICACIONES DEFINITIVAS <br>PROGRAMA NACIONAL DE FORMACIÓN <br> PERÍODO ACADÉMICO: <u>{{ $detalles->periodo }}</u> </h5>

		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="asignaturas">
			<thead style="border-top: 3px solid #000; border-bottom: 3px solid #000; margin-bottom: 10px;">

				<tr>
					<td width="80%">
						UNIDAD CURRICULAR: <u>{{ $detalles->nombre_asignatura }}</u>
						<br>
						TRAYECTO: <u> {{ $detalles->Asignatura->Trayecto->nombre }}</u>  TRIMESTRE: <u>{{ $detalles->DesAsignatura->tri_semestre }}</u>

					</td>
					<td width="20%" align="right">
						SECCIÓN: <u>{{ $detalles->seccion }}</u>
						<br>
						FECHA: <u>{{ Carbon::parse($fecha->created_at)->format('d/m/Y') }}</u>
					</td>
				</tr>
			</thead>

		</table>

		<br>


		<table width="100%" border="0" cellspacing="0" cellpadding="3" id="asignaturas">
			<thead style="border-top: 3px solid #000; border-bottom: 3px solid #000; margin-bottom: 10px;">
				<tr>
					<th width="8%" style="padding-top: 10px; padding-bottom: 10px;" >N°</th>
					<th width="10%" style="padding-top: 10px; padding-bottom: 10px;" >CÉDULA</th>
					<th width="55%" style="padding-top: 10px; padding-bottom: 10px;" >APELLIDOS Y NOMBRES</th>
					<th width="15%" style="padding-top: 10px; padding-bottom: 10px;" >CALIFICACIÓN</th>
				</tr>
			</thead>
			<br>
			<tbody style="margin-top: 100px !important;">
				@php
					$c = 0;
				@endphp


				@foreach($estudiantes as $key => $estudiante)

					<tr @if($estudiante->estatus == 15) style="background: yellow;" @endif>
						<td>{{ $key+1 }}</td>
						<td>{{ $estudiante->cedula_estudiante }}</td>
						<td style="text-transform: capitalize !important;">{{ ucfirst( mb_strtolower(@$estudiante->Alumno->apellidos,"UTF-8" )).', '.ucfirst( mb_strtolower(@$estudiante->Alumno->nombres,"UTF-8" )) }}</td>
						<td>{{ @$estudiante->nota .' '. @$estudiante->letras(@$estudiante->nota) }}</td>
					</tr>

				@endforeach

			</tbody>
		</table>

	</main>

</body>
</html>
