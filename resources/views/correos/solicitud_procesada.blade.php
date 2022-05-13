@component('mail::message')
Estimando {{ $usuario->nombre }} {{ $usuario->apellido }} su solicitud de corrección de califiaciones de fecha {{ \Carbon\Carbon::parse($solicitud->fecha)->format('d-m-Y h:i:s A') }} ha sido procesada


<table border="1" width="100%" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th>FECHA</th>
			<th>PERIODO</th>
			<th>SECCIÓN</th>
			<th>UNIDAD CURRICULAR</th>
			<th>{{ $solicitud->DesAsignatura->Asignatura->Plan->cohorte }}</th>
			<th>DOCENTE</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center">{{ \Carbon\Carbon::parse($solicitud->fecha)->format('d-m-Y h:i:s A') }}</td>
			<td align="center">{{ $solicitud->periodo }}</td>
			<td align="center">{{ $solicitud->seccion }}</td>
			<td align="center">{{ $solicitud->DesAsignatura->nombre }}</td>
			<td align="center">{{ $solicitud->DesAsignatura->tri_semestre }}</td>
			<td align="center">{{ $solicitud->Solicitante->nombre }} {{ $solicitud->Solicitante->apellido }}</td>
		</tr>
	</tbody>
</table>


@component('mail::button', ['url' =>route('panel.docente.solicitudes.show', [$solicitud])])
Ver Solicitud
@endcomponent

<br>
{{ config('app.name') }}
@endcomponent
