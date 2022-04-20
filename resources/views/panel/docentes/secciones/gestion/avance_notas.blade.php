@php
	use Carbon\Carbon;
	Carbon::setLocale('America/Caracas');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Avance de Notas</title>
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
			border: 1px dashed lightgrey;
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
						DOCENTE: {{ @$relacion->Docente->nombres }} {{ @$relacion->Docente->apellidos }}
						<br>
						CÉDULA: {{ @$relacion->Docente->nacionalidad }}-{{ @$relacion->Docente->cedula }}
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
	<main style="margin-bottom: 80px; margin-top: -50px;">

		<center><img src="{{ asset('/img/cintillo.png') }}" width="70%"></center>
		<h5 align="center">AVANCE DE CALIFICACIONES <br>PROGRAMA NACIONAL DE FORMACIÓN <br> PERÍODO ACADÉMICO: <u>{{ @$relacion->Seccion->Periodo->nombre }}</u> </h5>

		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="asignaturas">
			<thead style="border-top: 3px solid #000; border-bottom: 3px solid #000; margin-bottom: 10px;">

				<tr>
					<td width="80%">
						UNIDAD CURRICULAR: <u>{{ @$relacion->DesAsignatura->Asignatura->nombre }}</u>
						<br>
						TRAYECTO: <u> {{ @$relacion->DesAsignatura->Asignatura->Trayecto->nombre }}</u>  {{ @$relacion->DesAsignatura->Asignatura->Plan->cohorte }}: <u>{{ @$relacion->DesAsignatura->tri_semestre }}</u>

					</td>
					<td width="20%" align="right">
						SECCIÓN: <u>{{ @$relacion->Seccion->nombre }}</u>
						<br>
						FECHA: <u>{{ Carbon::parse(@$fecha->created_at)->format('d/m/Y') }}</u>
					</td>
				</tr>
			</thead>

		</table>

		<br>


		<table width="100%" border="0" cellspacing="0" cellpadding="3" id="asignaturas">
			<thead style="border-top: 3px solid #000; border-bottom: 3px solid #000; margin-bottom: 10px;">
				<tr>
					<th width="5%" style="padding-top: 10px; padding-bottom: 10px;" >N°</th>
					<th width="10%" style="padding-top: 10px; padding-bottom: 10px;" >CÉDULA</th>
					<th width="37%" style="padding-top: 10px; padding-bottom: 10px;" >APELLIDOS Y NOMBRES</th>
					<th width="5%">Aprueba</th>
					{{-- <th width="15%" style="padding-top: 10px; padding-bottom: 10px;" >CALIFICACIÓN</th> --}}
					@forelse ($relacion->Actividades as $key =>  $unidad)
                    <th >
                        {{ $unidad->actividad }} - {{ $unidad->porcentaje }}%
                    </th>

                @empty
                @endforelse
				@if (count($relacion->Actividades) > 0)
                <th>
                    Acum
                    (0 - 100)
                </th>
                <th>
                    Acum
                    (1 - 20)
                </th>
				@endif
				</tr>
			</thead>
			<br>
			<tbody style="margin-top: 100px !important;">
				@php
					$c = 1;
				@endphp
				@foreach ($relacion->Inscritos as $inscritos)
                <tr>
					<td>
						{{ $c++ }}
					</td>
                    <td>
                        {{ $inscritos->Alumno->nacionalidad }}-{{ $inscritos->Alumno->cedula }}
                    </td>
                    <td>
                        {{ $inscritos->Alumno->nombres }} {{ $inscritos->Alumno->apellidos }}
                    </td>
                    <td>
                        {{ ($inscritos->Alumno->tipo == 0 || $inscritos->Alumno->tipo == 10) ? 10 : 12 }}
                    </td>

                    @forelse ($relacion->Actividades as $unidad)
                        <td align="center"">
							{{ (@$unidad->Nota($inscritos->Alumno->id)->nota) ? @$unidad->Nota($inscritos->Alumno->id)->nota : 0}}
                            {{-- {{ @$unidad->Nota($inscritos->Alumno->id)->nota }} --}}
                            {{-- <x-jet-input-error for="nota.{{$inscritos->Alumno->id}}.{{$unidad->id}}"
                                :disabled="(!empty($nota[$inscritos->Alumno->id][$unidad->id])) ? true : true" /> --}}

                            {{-- <input type="text" size="4"> --}}
                        </td>
                    @empty
                    @endforelse
					@if (count($relacion->Actividades) > 0)
                        <td align="center">

                            {{ $nota = $inscritos->Alumno->NotasActividades($relacion->Actividades->pluck('id')) }}
                        </td>
                        <td align="right"  style="background: lightgray">
                            {{ $inscritos->Alumno->Escala($nota) }}
                        </td>
                    @endif
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

	</main>

</body>
</html>
