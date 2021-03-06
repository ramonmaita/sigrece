@php
	// dd($nota_final);
    // ini_set('max_execution_time', 90);
	// error_reporting(0);
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
	$nota_promedio = 0;
	$creditos_totales = 0;
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
    	footer { position: fixed; bottom: -40px; left: 0px; right: 0px; /*background-color: lightblue;*/ height: 50px;  }
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
			padding-right: 2px;
			padding-left: 2px;
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

		body{
			background-color:rgba(255, 255, 255, 0.9);
			background-image: url({{ asset('/img/fondo-notas.png') }});
		}
	</style>
</head>
<body>
	<header >
		<span>
			CONSTACIA DE:
			<span class="linea" style="text-transform: uppercase;">
					{{ $alumno->p_apellido.' '.$alumno->s_apellido.', '.$alumno->p_nombre.' '.$alumno->s_nombre }}
			</span>
		</span>

		<span style="float: right;" >
			N?? DE C??DULA:
			<span class="linea">
				{{ $alumno->cedula }}
			</span>
		</span>
		<br>
		<span>
			PROGRAMA NACIONAL DE FORMACI??N:
			<span class="linea">
				{{ $alumno->Pnf->nombre }}
			</span>
		</span>
	</header>
	<footer>
		<div style="position: absolute ; bottom: 40px; ">
			<table  border="0" style="width:100%;font-size:9pt;font-family:'Times New Roman', serif; /*margin-top-15px;*/ " align="center" cellspacing="0" cellpadding="0" >

				<tr>
					<th align="center" style="width: 33.33%">
						Dr. C. Willfor Rafael Goudeth Galindo <br>
						 <small>Rector</small>
					</th>
					<th align="center" style="width: 33.33%">
						MsC. Gabriela Betzabe Murillo Granados <br>
						<small>Secretaria</small>
					</th>
					<th align="center" style="width: 33.33%">
						Ing. Dulce Mar??a Jos?? P??rez Su??rez <br>
						{{-- MsC. Yomely Josefina P??rez Fajardo <br> --}}
						<small>Jefa (E) de la Direcci??n De Registro Y Control De Actividades Acad??micas</small>
					</th>
				</tr>
			</table>
			<span style="font-size: 10pt;">
				Va sin enmienda
			</span>
		</div>
	</footer>
	<main style="{{ ($graduando->titulo == 2) ? 'margin-bottom: 100px' : '' }} {{ ($graduando->titulo == 1 && $graduando->pnf== 55 || $graduando->titulo == 1 && $graduando->pnf== 40 || $graduando->titulo == 1 && $graduando->pnf== 60) ? 'margin-bottom: 100px' : '' }}   margin-top: -55px; ">


		<img src="{{ asset('/img/cintillo.png') }}" style='width:100%;'>
		{{-- <br> --}}
		<h3 align="center" style="text-transform: uppercase;"><u>CERTIFICACI??N DE CALIFICACIONES</u></h3>
		<p align="justify" class="parrafo">Quien suscribe, jefa (E) de la Direcci??n De Registro Y Control De Actividades Acad??micas de la Universidad Polit??cnica Territorial  del  Estado  Bol??var, hace constar por medio de la presente que esta casa de Estudios Universitarios reposa el Expediente de Estudios del Ciudadano: <span style="text-transform: uppercase;">{{ $alumno->p_apellido.' '.$alumno->s_apellido.' '.$alumno->p_nombre.' '.$alumno->s_nombre }} </span>, titular   de  la  C??dula de Identidad N??: <span> {{ $alumno->cedula }} </span>, en el Programa Nacional de Formaci??n  <span>{{ $alumno->Pnf->nombre }}</span>   habiendo cursado las asignaturas que a continuaci??n se especifican.</p>

		<table width="100%" border="0" cellspacing="0" cellpadding="3" id="asignaturas">
			<thead style="border-top: 3px solid #000; border-bottom: 3px solid #000; margin-bottom: 10px;">
				<tr>
					<th width="10%" style="padding-top: 10px; padding-bottom: 10px;" >TRAYECTO</th>
					<th {{-- width="10%" --}} style="padding-top: 10px; padding-bottom: 10px;" >C??DIGO
					<th width="55%" style="padding-top: 10px; padding-bottom: 10px;" >UNIDAD CURRICULAR</th>
					</th>
					<th width="15%" style="padding-top: 10px; padding-bottom: 10px;" >CALIFICAC??N</th>
					{{-- <td>trimeste</td> --}}
					<th width="5%" style="padding-top: 10px; padding-bottom: 10px;" >UC.</th>
				</tr>
			</thead>
			<br>
			<tbody style="">
				@php
					$c = 0;
				@endphp
				@if(isset($asig_faltante))

					@foreach($asig_faltante as $f)

						<tr>
						{{-- <td>2015-GCS</td> --}}
						<td align="center">{{@$f->Trayecto->nombre}}</td>
						<td>{{@$f->codigo}}</td>
						<td>{{@$f->nombre}}</td>
						{{-- <td>

							Aprobado

						</td> --}}
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
						{{-- <td>{{$asig->periodo}}</td> --}}
						<td align="center">{{@$asig->Trayecto->nombre}}</td>
						<td>{{@$asig->codigo}}</td>
						<td>{{@$asig->nombre}}</td>
						<td>
							@php
							if(@$nota_final[$key] == 30){
								echo "APROBADO". ' '.@$nota_final[$key];
							}else{

								echo round(@$nota_final[$key]) .' '. @$asig->letras(round(@$nota_final[$key]));
							}
							@endphp
						</td>
						<td>
							@php
								echo @$asig->credito;
							// echo round(@$nota_final[$key]).' ';
								// echo round(@$nota_final[$key]) * @$asig->credito;
							@endphp
						</td>
					</tr>
					@php

						// if(@$nota_final[$key] != 30 && @$nota_final[$key] >= $alumno->tipo){

						// 	$nota_promedio = $nota_promedio + (round(@$nota_final[$key]) * @$asig->credito);

						// 	$creditos += @$asig->credito;
						// }
						// 	$creditos_totales += @$asig->credito;

					if($nota_final[$key] != 30 && round($nota_final[$key]) >= $alumno->tipo ){
						if ($alumno->tipo == 12 && $asig->aprueba == 1 && round($nota_final[$key]) >= 16 || $asig->aprueba != 1) {
							$nota_promedio = $nota_promedio + (round($nota_final[$key]) * $asig->credito);
							$creditos += $asig->credito;
						}elseif ($alumno->tipo == 10 && $asig->aprueba == 1 && round($nota_final[$key]) >= 10) {

							$nota_promedio = $nota_promedio + (round($nota_final[$key]) * $asig->credito);
							$creditos += $asig->credito;
						}
					}
						$creditos_totales += $asig->credito

					@endphp
				@endforeach
			</tbody>
		</table>

		@php
			if ($creditos != 0) {

				$promedio = $nota_promedio / $creditos;
			}
			// $promedio = 0;
		@endphp
		<table width="100%" id="obeservaciones" border="0">
			<tr>
				<td>OBSERVACIONES:</td>
				<td align="right">??ndice de Rendimiento Acad??mico (IRA): </td>
				<td  align="right"  width="5%">{{ ($creditos_totales == 0) ? '' : round(@$promedio , 2)}}</td>
			</tr>
			<tr>
				<td>1.- La escala de Calificaciones es del 1 al 20.</td>
				<td align="right">Unidades de Cr??ditos para el de ??ndice Rendimiento Acad??mico (IRA): </td>
				<td  align="right"  width="5%">{{$creditos_totales}}</td>
			</tr>
			<tr>
				<td rowspan="2" width="50%">2.- Calificacion m??nima aprobatoria({{$alumno->tipo}}) puntos y la unidad curricular Proyecto  ({{($alumno->tipo == 10) ? 10 : 16}}) puntos.</td>
				<td align="right">{{-- N?? de Unidades de Cr??ditos Cursadas: --}} </td>
				<td  align="right"  width="5%">{{-- {{$creditos}} --}}</td>
			</tr>
			<tr>
				<td align="right">{{-- ??ndice de Desempe??o Acad??mico: --}}</td>
				<td  align="right"  width="5%">{{-- {{ ($creditos_totales == 0) ? '' : round(@$promedio , 2)}} --}}</td>
				{{-- <td align="right">N?? de Unidades de Cr??ditos para el ??ndice: </td>
				<td  align="right"  width="5%">{{$creditos_totales}}</td> --}}
			</tr>
		</table>

		<p style="font-size: 10pt">
			Constancia que se expide a solicitud de parte interesada, en Ciudad Bol??var a los <span class="linea">{{ Carbon::now()->format('d') }}</span> d??as del mes de <span class="linea">{{ $mes }}</span> de <span class="linea">{{ Carbon::now()->format('Y') }}</span>
		</p>
		{{-- <p style="font-size: 10pt">
			Constancia que se expide a solicitud de parte interesada, en Ciudad Bol??var a los <span class="linea">3</span> d??as del mes de <span class="linea">Agosto</span> de <span class="linea">2018</span>
		</p> --}}
	</main>

</body>
</html>
