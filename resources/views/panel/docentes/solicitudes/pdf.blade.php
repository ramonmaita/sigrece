@php
	use Carbon\Carbon;
	Carbon::setLocale('America/Caracas');
@endphp
@php
	switch ($solicitud->tipo) {
		case 'CORRECCION':
			$tipo =  'CORRECCION DE CALIFICACION';
			break;

		case 'RESET':
			$tipo =  'RESETEO DE NOTAS';
			break;
		default:
			$tipo =  'INCORPORACION A LA UNIDAD CURRICULAR';
			break;
	}
	$tipo =  'CORRECCION DE CALIFICACION';
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>SOLICITUD DE {{ $tipo }}</title>
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

		u{
			font-weight: 600;
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
						DOCENTE: {{$solicitud->Solicitante->nombre }}  {{$solicitud->Solicitante->apellido }}
						<br>
						CÉDULA: {{  $solicitud->Solicitante->cedula }}
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
		<h3 align="center" style="{{ ($solicitud->tipo == 'RESET') ? 'margin-top:60px' : '' }}">
			SOLICITUD DE {{ $tipo }}
		</h3>
		{{-- @if ($solicitud->tipo == 'CORRECCION') --}}
			<p style="text-align: justify">
				Yo <u>{{$solicitud->Solicitante->nombre }}  {{$solicitud->Solicitante->apellido }}</u> portador de la cédula de identidad N° <u>{{$solicitud->Solicitante->cedula }}</u>,
				por mediante de la presente solicito a la Dirección De Registro Y
				Control De Actividades Académicas la corrección de calificación de los estudiantes abajo descritos,
				quienes cursaron la Unidad Curricular <u>{{ $solicitud->DesAsignatura->nombre }} </u> del Trayecto <u>{{  $solicitud->DesAsignatura->Asignatura->Trayecto->nombre }}</u> Trimestre <u>{{ $solicitud->DesAsignatura->tri_semestre }}</u> impartida por mí en el periodo <u>{{ $solicitud->periodo }}</u> en la sección <u>{{ $solicitud->seccion }}</u>, por motivo <u>{{ $solicitud->motivo }}</u>
			</p>
		{{-- @elseif ($solicitud->tipo == 'RESET')
			<p style="text-align: justify; line-height: 2; margin-top:80px">
				Yo <u>{{$solicitud->Solicitante->nombre }}  {{$solicitud->Solicitante->apellido }}</u> portador de la cédula de identidad N° <u>{{$solicitud->Solicitante->cedula }}</u>,
				por mediante de la presente solicito a la Dirección De Registro Y
				Control De Actividades Académicas que sea resetada la carga de calificaciones la Unidad Curricular <u>{{ $solicitud->DesAsignatura->nombre }} </u> del Trayecto <u>{{  $solicitud->DesAsignatura->Asignatura->Trayecto->nombre }}</u> Trimestre <u>{{ $solicitud->DesAsignatura->tri_semestre }}</u> impartida por mí en el periodo <u>{{ $solicitud->periodo }}</u> en la sección <u>{{ $solicitud->seccion }}</u>, por motivo <u>{{ $solicitud->motivo }}</u>
			</p>
		@else
			<p style="text-align: justify">
				Yo <u>{{$solicitud->Solicitante->nombre }}  {{$solicitud->Solicitante->apellido }}</u> portador de la cédula de identidad N° <u>{{$solicitud->Solicitante->cedula }}</u>,
				por mediante de la presente solicito a la Dirección De Registro Y
				Control De Actividades Académicas sean incorporados los estudiantes abajo descritos
				a la Unidad Curricular <u>{{ $solicitud->DesAsignatura->nombre }} </u> del Trayecto <u>{{  $solicitud->DesAsignatura->Asignatura->Trayecto->nombre }}</u> Trimestre <u>{{ $solicitud->DesAsignatura->tri_semestre }}</u> impartida por mí en el periodo <u>{{ $solicitud->periodo }}</u> en la sección <u>{{ $solicitud->seccion }}</u>, por motivo <u>{{ $solicitud->motivo }}</u>
			</p>
		@endif --}}
		{{-- <table width="100%" border="0" cellspacing="0" cellpadding="3" class="asignaturas">
			<thead style="border-top: 3px solid #000; border-bottom: 3px solid #000; margin-bottom: 10px;">

				<tr>
					<td width="80%">
						UNIDAD CURRICULAR: <u>{{ @$detalles->nombre_asignatura }}</u>
						<br>
						TRAYECTO: <u> {{ @$detalles->Asignatura->Trayecto->nombre }}</u>  TRIMESTRE: <u>{{ @$detalles->DesAsignatura->tri_semestre }}</u>

					</td>
					<td width="20%" align="right">
						SECCIÓN: <u>{{ @$detalles->seccion }}</u>
						<br>
						FECHA: <u>{{ Carbon::parse(@$fecha->created_at)->format('d/m/Y') }}</u>
					</td>
				</tr>
			</thead>

		</table> --}}

		<br>

		@if($solicitud->tipo != 'RESET')

			<table width="100%" border="0" cellspacing="0" cellpadding="3" id="asignaturas">
				<thead style="border-top: 3px solid #000; border-bottom: 3px solid #000; margin-bottom: 10px;">
					<tr>
						<th width="8%" style="padding-top: 10px; padding-bottom: 10px;" >N°</th>
						<th width="10%" style="padding-top: 10px; padding-bottom: 10px;" >CÉDULA</th>
						<th width="40%" style="padding-top: 10px; padding-bottom: 10px;" >APELLIDOS Y NOMBRES</th>
						<th>OBSERVACION</th>
						@foreach ($relacion->Actividades as $actividad)
							<th>{{ $actividad->actividad }} - {{ $actividad->porcentaje }}</th>
						@endforeach
						<th>1-100</th>
						<th>1-20</th>
					</tr>
				</thead>
				<br>
				<tbody style="margin-top: 100px !important;">
					@php
						$c = 0;
						$nota_anterior = 0;
						$nota_nueva = 0;
					@endphp

					@foreach ($solicitud->Detalles->groupBy('alumno_id') as $key => $detalles)
						<tr>
							<td>{{ $c+1 }}</td>
							<td>{{ $detalles->first()->Alumno->cedula }}</td>
							<td>{{ $detalles->first()->Alumno->nombres }} {{ $detalles->first()->Alumno->apellidos }}</td>
							<td style="font-size: 8pt !important;">
								C. ERRONEA <br>
								C. CORRECTA
							</td>
							@foreach ($solicitud->Detalles->where('alumno_id',$detalles->first()->alumno_id) as $nota)
							<td align="center">{{ $nota->nota_anterior }}<br>{{ $nota->nota_nueva }}</td>
							@php
								$nota_anterior += $nota->nota_anterior;
								$nota_nueva += $nota->nota_nueva;
							@endphp
							@endforeach
							<td>
								{{ $nota_anterior }} <br>
								{{ $nota_nueva }}
							</td>
							<td>
								{{ $detalles->first()->Alumno->Escala($nota_anterior) }} <br>
								{{ $detalles->first()->Alumno->Escala($nota_nueva) }}
							</td>
						</tr>
					@endforeach
					{{-- @foreach($estudiantes as $key => $estudiante)

						<tr @if($estudiante->estatus == 15) style="background: yellow;" @endif>
							<td>{{ $key+1 }}</td>
							<td>{{ $estudiante->cedula_estudiante }}</td>
							<td style="text-transform: capitalize !important;">{{ ucfirst( mb_strtolower(@$estudiante->Alumno->apellidos,"UTF-8" )).', '.ucfirst( mb_strtolower(@$estudiante->Alumno->nombres,"UTF-8" )) }}</td>
							<td>{{ @$estudiante->nota .' '. @$estudiante->letras(@$estudiante->nota) }}</td>
						</tr>

					@endforeach --}}

				</tbody>
			</table>
		@endif

	</main>

</body>
</html>
