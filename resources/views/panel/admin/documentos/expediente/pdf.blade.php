@php
	error_reporting(0);
	use Carbon\Carbon;
	Carbon::setLocale('America/Caracas');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Expediente</title>
	<style>
		@page {
			margin-top: 120px;
			margin-bottom: 60px;
			margin-right: 50px;
			margin-left: 50px;

		}
   		header {  position: fixed; top: -120px; left: 0px; right: 0px; /*background-color: lightblue;*/ height: 120px; background-size: 80%; font-size: 10pt; font-family: 'Times New Roman'; padding-bottom:100px;}
    	footer { position: fixed; bottom: -80px; left: 0px; right: 0px;/* background-color: lightblue;*/ height: 50px;  }
    	/* @page :first{
    		margin-top: 50px;
			margin-bottom: 60px;
			margin-right: 50px;
			margin-left: 50px;
		} */

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
		.encabezados {
			background: lightgray;
		}

		main {
			text-transform: uppercase;
		}
		.salto-pagina {
			page-break-after: always;
		}
	</style>
</head>
<body>
	<header >
		<img src="{{ asset('/img/cintillo.png') }}" style='width:100%;'>
	</header>
	<footer>
		<div style="position: absolute ; bottom: 5px;">
			<table  border="0" style="width: 70%;font-size:10pt;font-family:'Times New Roman', serif;margin-top-15px;" align="center" cellspacing="0" cellpadding="0" >


			<tr>
				<td><p align="center" class="Estilo3">Revolucionado La educación Universitaria<br style="margin-top: 0px;" />
				 _____________________________________________________________________________________________________<br />
				Calle Igualdad, entre Calle Progreso y Rosario, Nº 28, Edif IUTEB, Casco Historico de <br />
				Ciudad Bolivar - Estado Bolivar - Venezuela  - Telefono (0285) 6340339, Email: iuteb.rrpp@gmail.com </p></td>

			</tr>

			</table>
		</div>
	</footer>
	<main style="margin-bottom: 80px;/*140px*/ margin-top: 0px; position: absolute;">

		<table width="100%">
			<tr>
				<td width="25%">
					<small style="font-size: 9.5pt;">
						Generado:
						<br>
						{{ Carbon::now()->format('d-m-Y') }}
					</small>
				</td>
				<td width="50%">
					<h3 align="center">
						Expediente Digital
					</h3>
				</td>
				<td width="25%" align="right">
					<small style="font-size: 9.5pt;">
						Ultima Actializacion:
						<br>{{ Carbon::parse($alumno->ActualizacionDatos->updated_at)->format('d-m-Y') }}
					</small>
				</td>
			</tr>
		</table>

		{{-- <hr> --}}
		<table class="" border="1" width="100%" cellspacing="0" cellpadding="3" style="margin-top: 10px;">
			<thead>
				<tr class="encabezados">
					<th colspan="4">DATOS ACADEMICOS</th>
				</tr>
			</thead>
			<tbody  style="font-size: 10pt;">
				<tr class="encabezados">
					<th>ingreso</th>
					<th>nucleo</th>
					<th>pnf</th>
					<th>plan</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->InfoComplementaria->ingreso }}</td>
					<td>{{ $alumno->Nucleo->nucleo }}</td>
					<td>{{ $alumno->Pnf->acronimo }}</td>
					<td>{{ $alumno->Plan->codigo }} - {{ $alumno->Plan->observacion }}</td>
				</tr>
			</tbody>
		</table>

		<table class="" border="1" width="100%" cellspacing="0" cellpadding="3"  style="margin-top: 10px;">
			<thead>
				<tr class="encabezados">
					<th colspan="4">DATOS PERSONALES</th>
				</tr>
			</thead>
			<tbody style="font-size: 10pt;">
				<tr class="encabezados">
					<th>Primer Nombre</th>
					<th>Segundo Nombre</th>
					<th>Primer Apellido</th>
					<th>Segundo Apellido</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->p_nombre }}</td>
					<td>{{ $alumno->s_nombre }}</td>
					<td>{{ $alumno->p_apellido }}</td>
					<td>{{ $alumno->s_apellido }}</td>
				</tr>
				<tr class="encabezados">
					<th>Nacionalidad</th>
					<th> {{ ($alumno->nacionalidad == 'P') ?'Pasaporte' : 'Cédula' }} </th>
					<th>Fecha de Nacimiento</th>
					<th>Edad</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->nacionalidad }}</td>
					<td>{{ number_format($alumno->cedula,0,'','.') }}</td>
					<td>{{ Carbon::parse($alumno->fechan)->format('d-m-Y') }}</td>
					<td>{{ Carbon::now()->diffForHumans($alumno->fechan,Carbon::now()) }}</td>
				</tr>
				<tr class="encabezados">
					<th colspan="3">Lugar de Nacimiento </th>
					<th colspan="">Sexo</th>
				</tr>
				<tr>
					<td colspan="3">{{ $alumno->lugarn }} </td>
					<td colspan="">{{ ($alumno->sexo == 'M' || $alumno->sexo == 'MASCULINO') ? 'MASCULINO' : 'FEMENINO' }}</td>
				</tr>
			</tbody>
		</table>


		<table class="" border="1" width="100%" cellspacing="0" cellpadding="3" style="margin-top: 10px;">
			<thead>
				<tr class="encabezados">
					<th colspan="3">DATOS DE CONTACTO</th>
				</tr>
			</thead>
			<tbody  style="font-size: 10pt;">
				<tr class="encabezados">
					<th>Estado</th>
					<th>Municipio</th>
					<th>Parroquia</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->InfoContacto->Estado->estado }}</td>
					<td>{{ $alumno->InfoContacto->Municipio->municipio }}</td>
					<td>{{ $alumno->InfoContacto->Parroquia->parroquia }}</td>
				</tr>
				<tr class="encabezados">
					<th colspan="3">Dirección</th>
				</tr>
				<tr>
					<td  colspan="3">{{ $alumno->InfoContacto->direccion }}</td>
				</tr>
				<tr class="encabezados">
					<th>Telefono</th>
					<th>correo</th>
					<th>correo alternativo</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->InfoContacto->telefono }}</td>
					<td>{{ $alumno->InfoContacto->correo }}</td>
					<td>{{ $alumno->InfoContacto->correo_alternativo }}</td>
				</tr>
				<tr class="encabezados">
					<th colspan="3">redes sociales</th>
				</tr>
				<tr class="encabezados">
					<th>facebook</th>
					<th>instagram</th>
					<th>twitter</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->InfoContacto->facebook }}</td>
					<td>{{ $alumno->InfoContacto->instagram }}</td>
					<td>{{ $alumno->InfoContacto->twitter }}</td>
				</tr>
			</tbody>
		</table>

		<table class="" border="1" width="100%" cellspacing="0" cellpadding="3" style="margin-top: 10px;">
			<thead>
				<tr class="encabezados">
					<th colspan="4">DATOS MEDICOS</th>
				</tr>
			</thead>
			<tbody  style="font-size: 10pt;">
				<tr class="encabezados">
					<th>¿posee alguna discapacidad?</th>
					<th>discapacidad</th>
					<th>¿posee alguna enfermedad cronica?</th>
					<th>enfermedad</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->InfoMedica->posee_discapacidad }}</td>
					<td>{{ $alumno->InfoMedica->discapacidad }}</td>
					<td>{{ $alumno->InfoMedica->posee_enfermedad }}</td>
					<td>{{ $alumno->InfoMedica->enfermedad }}</td>
				</tr>
				<tr class="encabezados">
					<th colspan="4">¿a quien llamar en en caso de emergencia?</th>
				</tr>
				<tr>
					<td  colspan="4">{{ $alumno->InfoMedica->llamar_emergencia }}</td>
				</tr>
			</tbody>
		</table>

		<table class="" border="1" width="100%" cellspacing="0" cellpadding="3" style="margin-top: 10px;">
			<thead>
				<tr class="encabezados">
					<th colspan="3">DATOS LABORALES</th>
				</tr>
			</thead>
			<tbody  style="font-size: 10pt;">
				<tr class="encabezados">
					<th>¿trabaja?</th>
					<th>direccion</th>
					<th>¿telefono?</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->InfoLaboral->trabaja }}</td>
					<td>{{ $alumno->InfoLaboral->direccion }}</td>
					<td>{{ $alumno->InfoLaboral->telefono }}</td>
				</tr>
			</tbody>
		</table>

		<div class="salto-pagina"></div>

		<table class="" border="1" width="100%" cellspacing="0" cellpadding="3" style="margin-top: 10px;">
			<thead>
				<tr class="encabezados">
					<th colspan="3">DATOS COMPLEMENTARIOS</th>
				</tr>
			</thead>
			<tbody  style="font-size: 10pt;">
				<tr class="encabezados">
					<th>carnet de la patria</th>
					<th>¿pertenece a una etnia indigena?</th>
					<th>etnia</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->InfoComplementaria->carnet_patria }}</td>
					<td>{{ $alumno->InfoComplementaria->pertenece_etnia }}</td>
					<td>{{ $alumno->InfoComplementaria->etnia }}</td>
				</tr>
			</tbody>
		</table>
		<table class="" border="1" width="100%" cellspacing="0" cellpadding="3" style="margin-top: -2px;">
			<tbody  style="font-size: 10pt;">
				<tr class="encabezados">
					<th>Madre</th>
					<th>Telefono</th>
					<th>padre</th>
					<th>Telefono</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->InfoComplementaria->madre }}</td>
					<td>{{ $alumno->InfoComplementaria->tlf_madre }}</td>
					<td scope="row">{{ $alumno->InfoComplementaria->padre }}</td>
					<td>{{ $alumno->InfoComplementaria->tlf_padre }}</td>
				</tr>
			</tbody>
		</table>

		<table class="" border="1" width="100%" cellspacing="0" cellpadding="3" style="margin-top: -2px;">
			<tbody  style="font-size: 10pt;">
				<tr class="encabezados">
					<th>equipos electronicos</th>
					<th>internet</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->InfoComplementaria->equipos }}</td>
					<td>{{ $alumno->InfoComplementaria->internet }}</td>
				</tr>
			</tbody>
		</table>

		<table class="" border="1" width="100%" cellspacing="0" cellpadding="3" style="margin-top: 10px;">
			<tbody  style="font-size: 10pt;">
				<tr class="encabezados">
					<th>usuario SIGRECE</th>
				</tr>
				<tr>
					<td scope="row">{{ $alumno->Usuario->email }}</td>
				</tr>
			</tbody>
		</table>

	</main>

</body>
</html>
