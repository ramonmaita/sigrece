@component('mail::message')
Estimando {{ $usuario->nombre }} {{ $usuario->apellido }} tiene una nueva solicitud de correccion de califiaciones


<table border="1" width="100%" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th>PERIODO</th>
			<th>SECCIÓN</th>
			<th>UNIDAD CURRICULAR</th>
			<th>{{ $solicitud->DesAsignatura->Asignatura->Plan->cohorte }}</th>
			<th>DOCENTE</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center">{{ $solicitud->periodo }}</td>
			<td align="center">{{ $solicitud->seccion }}</td>
			<td align="center">{{ $solicitud->DesAsignatura->nombre }}</td>
			<td align="center">{{ $solicitud->DesAsignatura->tri_semestre }}</td>
			<td align="center">{{ $solicitud->Solicitante->nombre }} {{ $solicitud->Solicitante->apellido }}</td>
		</tr>
	</tbody>
</table>


{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

<br>
{{ config('app.name') }}
@endcomponent
