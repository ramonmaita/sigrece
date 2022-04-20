
<table>
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
</table>

<table>
	<thead>
		<tr>
			<th>
				N°
			</th>
			<th>
				Cédula
			</th>
			<th>
				Nombres
			</th>
			<th>
				Apellidos
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($relacion->Inscritos as $key => $inscritos)

			<tr>
				<td>
					{{ $key+1 }}
				</td>
				<td>
					{{ $inscritos->Alumno->nacionalidad }}-{{ $inscritos->Alumno->cedula }}
				</td>
				<td>
					{{ $inscritos->Alumno->nombres}}
				</td>
				<td>
					{{ $inscritos->Alumno->apellidos }}
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
