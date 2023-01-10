
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
			<th>
				Correo
			</th>
			<th>
				Telefono
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($estudiantes as $key => $inscrito)

			<tr>
				<td>
					{{ $key+1 }}
				</td>
				<td>
					{{ $inscrito->nacionalidad }}-{{ $inscrito->cedula }}
				</td>
				<td>
					{{ $inscrito->nombres}}
				</td>
				<td>
					{{ $inscrito->apellidos }}
				</td>
				<td>
					{{ ($inscrito->InfoContacto) ? $inscrito->InfoContacto->correo : ''}}
				</td>
				<td>
					{{ ($inscrito->InfoContacto) ? $inscritos->InfoContacto->telefono : '' }}
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
