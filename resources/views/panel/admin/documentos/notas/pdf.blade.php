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

	$creditos = 0;
	$creditos_totales = 0;
	$nota_promedio = 0;
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
				Ing. Dulce María José Pérez Suárez {{-- MsC.Yomely Josefina Pérez Fajardo --}}  <br /> Directora Encargada{{-- de la Dirección --}} De Registro Y Control De Actividades Académicas </p></td></tr>
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
		<h3 align="center"><u>Constancia de Calificaciones</u></h3>
		<p align="justify" class="parrafo">
			Quien suscribe, Directora (E) {{-- de la Dirección --}} De Registro Y Control De Actividades Académicas
			de la Universidad Politécnica Territorial Del Estado Bolívar, hace constar por medio de la presente que
			en esta casa de Estudios Universitarios reposa el Expediente de Estudios
			del Ciudadano: <span style="text-transform: uppercase;">{{ $alumno->nombres.' '.$alumno->apellidos }}</span>,
			titular de la cédula de identidad N°: <span> {{ number_format($alumno->cedula,0,'','.') }} </span>,
			En el Programa Nacional de Formación <span>{{ $alumno->Pnf->nombre }}</span> habiendo cursado las unidades
			curriculares que a continuación se especifican.
		</p>

		<table width="100%" border="0" cellspacing="0" cellpadding="3" id="asignaturas">
			<thead style="border-top: 3px solid #000; border-bottom: 3px solid #000; margin-bottom: 10px;">
				<tr>
					<th width="8%" style="padding-top: 10px; padding-bottom: 10px;" >PERÍODO</th>
					<th width="10%" style="padding-top: 10px; padding-bottom: 10px;" >TRAYECTO</th>
					<th width="55%" style="padding-top: 10px; padding-bottom: 10px;" >UNIDAD CURRICULAR</th>
					<th {{-- width="10%" --}} style="padding-top: 10px; padding-bottom: 10px;" >TRIM/SEM.
						<br>
						<center>
							I | II | III
						</center>
					</th>
					<th width="15%" style="padding-top: 10px; padding-bottom: 10px;" >CALIFICACIÓN</th>
					<th width="5%" style="padding-top: 10px; padding-bottom: 10px;" >UC.</th>
				</tr>
			</thead>
			<br>
			<tbody style="margin-top: 100px !important;">
				@php
					$c = 0;
				@endphp
				{{-- <td>{{ $calificaciones['1'] }}</td> --}}

				@if(isset($asig_faltante))

					@foreach($asig_faltante as $f)

						<tr>
						<td>2015-GCS</td>
						<td align="center">{{@$f->Trayecto->nombre}}</td>
						<td>{{@$f->nombre}}</td>
						<td

						>

							Aprobado

						</td>
						<td>
							APROBADO
						</td>
						<td>
							@php
								echo @$f->credito;
								$creditos_totales += @$f->credito;
							@endphp
						</td>
					</tr>

					@endforeach

				@endif

				@foreach ($asigs as $key => $asig)

					<tr>
						<td>{{$asig->periodo}}</td>
						<td align="center">{{@$asig->Asignatura->Trayecto->nombre}}</td>
						<td>{{@$asig->Asignatura->nombre}}</td>
						<td
							@php
								@$trim = $asig->asignatura(@$asig->cod_asignatura)->tri_semestre;
							@endphp
							@if(($trim == 01) || ($trim == 04) || ($trim == 07) || ($trim == 10))

								align="left"
							@elseif(($trim == 02) || ($trim == 05) || ($trim == '08') || ($trim == 11))
								align="center"
							@elseif(($trim == 03) || ($trim == 06) || ($trim == '09') || ($trim == 12))

								align="right"
							@elseif(($trim == 00))

								align="left"
							@else
								align="right"

							@endif

						>

							@php
							if($calificaciones[$key] == 30){
								echo "Aprobado";
							}else{
								echo $calificaciones[$key];
							}
							@endphp
						</td>
						<td>
							@php
							if($nota_final[$key] == 30){
								echo "APROBADO";
							}else{

								echo round($nota_final[$key]) .' '. $asig->letras(round($nota_final[$key]));
							}
							@endphp
						</td>
						<td>
							@php
								echo @$asig->Asig_anual()->credito;
							@endphp
						</td>
					</tr>
					@php

						if($nota_final[$key] != 30 && round($nota_final[$key]) >= $alumno->tipo ){
							if (@$alumno->tipo == 12 && @$asig->Asignatura->aprueba == 1 && round($nota_final[$key]) >= 16 || @$asig->Asignatura->aprueba != 1) {

								$nota_promedio = $nota_promedio + (round($nota_final[$key]) * @$asig->Asignatura->credito);
								$creditos += @$asig->Asignatura->credito;

							}if (@$alumno->tipo == 10 && @$asig->Asignatura->aprueba == 1 && round($nota_final[$key]) >= 10) {

								$nota_promedio = $nota_promedio + (round($nota_final[$key]) * @$asig->Asignatura->credito);
								$creditos += @$asig->Asignatura->credito;
							}else{
								// $nota_promedio = $nota_promedio + (round($nota_final[$key]) * @$asig->Asignatura->credito);
								// $creditos += @$asig->Asignatura->credito;
								// $creditos_totales += @$asig->Asignatura->credito;
							}


						}

							$creditos_totales += @$asig->Asignatura->credito;

					@endphp
				@endforeach
				{{-- {{ $alumno->Historico->groupBy('cod_asignatura') }} --}}

				@foreach ($alumno->Historico->where('estatus',0)->groupBy('cod_asignatura') as $key => $asig)

					@if($asig->first()->Asignatura->Plan->id == $alumno->plan_id)
						<tr>
							<td>{{ $alumno->ultimo_periodo($asig->first()->cod_asignatura)->periodo }}</td>
							<td align="center">{{@$asig->first()->Asignatura->Trayecto->nombre}}</td>
							<td>{{@$asig->first()->Asignatura->nombre}}</td>
							<td
								@php
									@$trim = $asig->first()->asignatura(@$asig->first()->cod_asignatura)->tri_semestre;
								@endphp
								@if(($trim == 01) || ($trim == 04) || ($trim == 07) || ($trim == 10))

									align="left"
								@elseif(($trim == 02) || ($trim == 05) || ($trim == '08') || ($trim == 11))
									align="center"
								@elseif(($trim == 03) || ($trim == 06) || ($trim == '09') || ($trim == 12))

									align="right"
								@elseif(($trim == 00))

									align="left"
								@else
									align="right"

								@endif

							>

								@php
								if($calificaciones[$key] == 30){
									echo "Aprobado";
								}else{
									echo $calificaciones[$key];
								}
								@endphp

								@foreach ($alumno->Notas($asig->first()->cod_asignatura,$alumno->ultimo_periodo($asig->first()->cod_asignatura)->nro_periodo) as $nota_trimestre)

									@if ($loop->first && $nota_trimestre->nota == 30)
										Aprobado
										@php break; @endphp
									@endif
								{{ $nota_trimestre->nota }}
								@endforeach
							</td>
							<td>
								{{-- @php
								if($nota_final[$key] == 30){
									echo "APROBADO";
								}else{

									echo round($nota_final[$key]) .' '. $asig->first()->letras(round($nota_final[$key]));
								}
								@endphp --}}

								@foreach ($alumno->Notas($asig->first()->cod_asignatura,$alumno->ultimo_periodo($asig->first()->cod_asignatura)->nro_periodo) as $nota_trimestre)

								{{-- @if ($loop->last)

								@endif --}}
								@php
									$nota_final_a += $nota_trimestre->nota;
									$nta = round($nota_final_a/count($asig->first()->Asignatura->DesAsignaturas));
								@endphp
								@endforeach
								{{-- {{ $nota_final_a }} --}}
								@if ($nta == 30)
									APROBADO
								@else
									{{ $nta }}
									{{ $asig->first()->letras($nta) }}
								@endif
							</td>
							<td>
								@php
									echo @$asig->first()->Asignatura->credito;
								@endphp
							</td>
						</tr>
						@php

							if($nta != 30 && round($nta) >= $alumno->tipo ){
								if (@$alumno->tipo == 12 && @$asig->first()->Asignatura->aprueba == 1 && round($nta) >= 16 || @$asig->first()->Asignatura->aprueba != 1) {

									$nota_promedio = $nota_promedio + (round($nta) * @$asig->first()->Asignatura->credito);
									$creditos += @$asig->first()->Asignatura->credito;

								}if (@$alumno->tipo == 10 && @$asig->first()->Asignatura->aprueba == 1 && round($nta) >= 10) {

									$nota_promedio = $nota_promedio + (round($nta) * @$asig->first()->Asignatura->credito);
									$creditos += @$asig->first()->Asignatura->credito;
								}else{
									// $nota_promedio = $nota_promedio + (round($nota_final[$key]) * @$asig->first()->Asignatura->credito);
									// $creditos += @$asig->first()->Asignatura->credito;
									// $creditos_totales += @$asig->first()->Asignatura->credito;
								}


							}

								$creditos_totales += @$asig->first()->Asignatura->credito;

						@endphp

						@php
							$nota_final_a = 0;
						@endphp
					@endif
				@endforeach
			</tbody>
		</table>

		@php
			if ($creditos != 0) {

				$promedio = $nota_promedio / $creditos_totales;
			}
			//$promedio = 0;
		@endphp
		<table width="100%" id="obeservaciones" border="0">
			<tr>
				<td>OBSERVACIONES:</td>
				<td align="right">Índice de Rendimiento Académico:</td>
				<td  align="right"  width="5%">{{ ($creditos_totales == 0) ? '' : round(@$promedio , 2)}}</td>
			</tr>
			<tr>
				<td>1.- La escala de calificaciones es del 1 al 20.</td>
				<td align="right">Índice de Desempeño Académico:</td>
				<td  align="right"  width="5%">{{-- {{@$nota_promedio}} --}}</td>
			</tr>
			<tr>
				<td rowspan="2" width="50%">2.- Calificacion mínima aprobatoria: {{($alumno->tipo == 10) ? 'Diez' : 'Doce'}} ({{$alumno->tipo}}) puntos y la unidad curricular Proyecto  ({{($alumno->tipo == 10) ? 10 : 16}}) puntos.</td>
				{{-- <td rowspan="2" width="50%"></td> --}}
				<td align="right">N° de Unidades de Créditos Cursadas: </td>
				<td  align="right"  width="5%">{{@$creditos_totales}}</td>
			</tr>
			<tr>
				<td align="right">N° de Unidades de Créditos Aprobadas: </td>
				<td  align="right"  width="5%">{{@$creditos}}</td>
			</tr>
		</table>

		<p>
			Constancia que se expide a solicitud de parte interesada, en Ciudad Bolívar a los <span class="linea">{{ Carbon::now()->format('d') }}</span> días del mes de <span class="linea">{{ $mes }}</span> de <span class="linea">{{ Carbon::now()->format('Y') }}</span>
		</p>
	</main>

</body>
</html>
