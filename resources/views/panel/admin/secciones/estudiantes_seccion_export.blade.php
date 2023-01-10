@php
	error_reporting(0);
	use Carbon\Carbon;
	Carbon::setLocale('America/Caracas');
@endphp
{{-- <table>
	<tr>
		<th>
			Seccion
		</th>
		<th>
			{{ $relacion->Seccion->nombre }}
		</th>
		<th>
			Docente
		</th>
		<th>
			{{ $relacion->Docente->nombres }} {{ $relacion->Docente->apellidos }}
		</th>
	</tr>
</table> --}}

<table>
	<thead>
		<tr>
			<th>N°</th>
			<th>Nacionalidad</th>
			<th>
				Cédula
			</th>
			<th>Primer Nombre</th>
			<th>Segundo Nombre</th>
			<th>Primer Apellido</th>
			<th>Segundo Apellido</th>
			<th>Fecha de Nacimiento</th>
			<th>Lugar de Nacimiento </th>
			<th>Edad</th>
			<th>Sexo</th>
			<th>ingreso</th>
			<th>nucleo</th>
			<th>pnf</th>
			<th>plan</th>
			<th>Estado</th>
			<th>Municipio</th>
			<th>Parroquia</th>
			<th>Dirección</th>
			<th>Telefono</th>
			<th>correo</th>
			<th>correo alternativo</th>
			<th>facebook</th>
			<th>instagram</th>
			<th>twitter</th>
			<th>¿posee alguna discapacidad?</th>
			<th>discapacidad</th>
			<th>¿posee alguna enfermedad cronica?</th>
			<th>enfermedad</th>
			<th>¿a quien llamar en en caso de emergencia?</th>
			<th>¿trabaja?</th>
			<th>direccion</th>
			<th>¿telefono de trabajo?</th>
			<th>carnet de la patria</th>
			<th>¿pertenece a una etnia indigena?</th>
			<th>etnia</th>
			<th>Madre</th>
			<th>Telefono</th>
			<th>padre</th>
			<th>Telefono</th>
			<th>equipos electronicos</th>
			<th>internet</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($alumnos as $key => $alumno)

			<tr>
				<td>
					{{ $key+1 }}
				</td>
				<td> {{ ($alumno->nacionalidad == 'P') ?'Pasaporte' : 'Cédula' }} </td>
				<td>
					{{ number_format($alumno->cedula,0,'','.') }}
				</td>
				<td>{{ $alumno->p_nombre }}</td>
				<td>{{ $alumno->s_nombre }}</td>
				<td>{{ $alumno->p_apellido }}</td>
				<td>{{ $alumno->s_apellido }}</td>
				<td>{{ Carbon::parse($alumno->fechan)->format('d-m-Y') }}</td>
				<td>{{ $alumno->lugarn }} </td>
				<td>{{ Carbon::now()->diffForHumans($alumno->fechan,Carbon::now()) }}</td>
				<td>{{ ($alumno->sexo == 'M' || $alumno->sexo == 'MASCULINO') ? 'MASCULINO' : 'FEMENINO' }}</td>
				<td>{{ $alumno->InfoComplementaria->ingreso }}</td>
				<td>{{ $alumno->Nucleo->nucleo }}</td>
				<td>{{ $alumno->Pnf->acronimo }}</td>
				<td>{{ $alumno->Plan->codigo }} - {{ $alumno->Plan->observacion }}</td>
				<td>{{ $alumno->InfoContacto->Estado->estado }}</td>
				<td>{{ $alumno->InfoContacto->Municipio->municipio }}</td>
				<td>{{ $alumno->InfoContacto->Parroquia->parroquia }}</td>
				<td>{{ $alumno->InfoContacto->direccion }}</td>
				<td>{{ $alumno->InfoContacto->telefono }}</td>
				<td>{{ $alumno->InfoContacto->correo }}</td>
				<td>{{ $alumno->InfoContacto->correo_alternativo }}</td>
				<td>{{ $alumno->InfoContacto->facebook }}</td>
				<td>{{ $alumno->InfoContacto->instagram }}</td>
				<td>{{ $alumno->InfoContacto->twitter }}</td>
				<td>{{ $alumno->InfoMedica->posee_discapacidad }}</td>
				<td>{{ $alumno->InfoMedica->discapacidad }}</td>
				<td>{{ $alumno->InfoMedica->posee_enfermedad }}</td>
				<td>{{ $alumno->InfoMedica->enfermedad }}</td>
				<td>{{ $alumno->InfoMedica->llamar_emergencia }}</td>
				<td>{{ $alumno->InfoLaboral->trabaja }}</td>
				<td>{{ $alumno->InfoLaboral->direccion }}</td>
				<td>{{ $alumno->InfoLaboral->telefono }}</td>
				<td>{{ $alumno->InfoComplementaria->carnet_patria }}</td>
				<td>{{ $alumno->InfoComplementaria->pertenece_etnia }}</td>
				<td>{{ $alumno->InfoComplementaria->etnia }}</td>
				<td>{{ $alumno->InfoComplementaria->madre }}</td>
				<td>{{ $alumno->InfoComplementaria->tlf_madre }}</td>
				<td>{{ $alumno->InfoComplementaria->padre }}</td>
				<td>{{ $alumno->InfoComplementaria->tlf_padre }}</td>
				<td>{{ $alumno->InfoComplementaria->equipos }}</td>
				<td>{{ $alumno->InfoComplementaria->internet }}</td>
			</tr>
			@endforeach
	</tbody>
</table>
