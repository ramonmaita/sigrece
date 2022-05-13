<div>
    <div class="row mb-3">
		<div class="col-md-4">
			<label>Fecha y Hora de la solicitud</label>
			<br>
			{{ \Carbon\Carbon::parse($solicitud->fecha)->format('d/m/Y h:i:s A') }}
		</div>
		<div class="col-md-4">
			<label>Solicitante</label>
			<br>
			{{ $solicitud->Solicitante->nombre }} {{ $solicitud->Solicitante->apellido }}
		</div>
		<div class="col-md-4">
			<label>Periodo</label>
			<br>
			{{ $solicitud->periodo }}
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-4">
			<label>Unidad Curricular</label>
			<br>
			{{ $solicitud->DesAsignatura->nombre }} {{ $solicitud->DesAsignatura->Asignatura->Plan->cohorte }}: {{ $solicitud->DesAsignatura->tri_semestre }}
		</div>
		<div class="col-md-2">
			<label>Sección</label>
			<br>
			{{ $solicitud->seccion }}
		</div>
		<div class="col-md-6">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-4">
						<label>ESTATUS PNF:</label>
						<br>{{ $solicitud->estatus_jefe }}
					</div>
					<div class="col-md-8">
						<label>ESTATUS DRCAA</label>
						<br>
						@if ($solicitud->estatus_admin == 'EN REVISION')
							<select required wire:model="estatus_admin" id="estatus_admin" class="form-control">
								<option id="admin-revision" value="EN REVISION" disabled selected>EN REVISION</option>
								<option id="admin-aprobado" value="APROBADO">APROBAR TODA LA SOLICITUD</option>
								<option id="admin-rechazado" value="RECHAZADO">RECHAZAR TODA LA SOLICITUD</option>
								<option id="admin-procesado" value="PROCESADO">PROCESAR INDIVIDUAL</option>
							</select>
						@else
							{{ $solicitud->estatus_admin }}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-6 text-justify">
			<label>Motivo</label>
			<br>
			{{ ($solicitud->motivo != null) ? $solicitud->motivo : 'SIN DESCRIPCION'  }}
		</div>
		<div class="col-md-6 text-justify">
			<label>Observación</label>
			<br>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						JEFE DE PNF: {{ ($solicitud->observacion != null) ? $solicitud->observacion : 'SIN OBSERVACIONES'  }}
					</div>
					<div class="col-md-6">
						@if ($solicitud->estatus_admin == 'EN REVISION')
							<input type="text" class="form-control" wire:model='observacion_admin'>
						@else
							DRCAA: {{ ($solicitud->observacion_admin != null) ? $solicitud->observacion_admin : 'SIN OBSERVACIONES'  }}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12 overflow-x-auto">
			<table class="table ">
				<thead>
					<tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
						<th class="px-6 py-3 text-center">N°</th>
						<th class="px-6 py-3 text-left">Cédula</th>
						<th class="px-6 py-3 text-right">Nombres y Apellidos</th>
						<th class="px-6 py-3 text-right">OBSERVACION</th>
						@foreach ($relacion->Actividades as $actividad)
							<th>{{ $actividad->actividad }} - <br> {{ $actividad->porcentaje }}%</th>
						@endforeach
						<th class="px-6 py-3 text-right">1-100</th>
						<th class="px-6 py-3 text-right">1-20</th>
						@if ($estatus_admin =='PROCESADO')
						<th class="px-6 py-3 text-right">Acciones</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@php
						$c = 0;
						$nota_anterior = 0;
						$nota_nueva = 0;
						$contador = 0;
					@endphp

					@foreach ($solicitud->Detalles->groupBy('alumno_id') as $key => $detalles)
					@php
						$nota_anterior = 0;
						$nota_nueva = 0;
					@endphp
						<tr>
							<td class="text-center">{{ $c+=1 }}</td>
							<td>{{ $detalles->first()->Alumno->cedula }}</td>
							<td>{{ $detalles->first()->Alumno->nombres }} {{ $detalles->first()->Alumno->apellidos }}</td>
							<td align="center" style="font-size: 8pt !important;">
								C. ERRONEA <br>
								C. CORRECTA
							</td>
							@foreach ($relacion->Actividades as $actividad)
								@forelse ($solicitud->Detalles->where('alumno_id',$detalles->first()->alumno_id)->where('actividad_id',$actividad->id) as $nota)
									{{-- @if ($nota->actividad_id == $actividad_id) --}}
										<td align="center">{{ $nota->nota_anterior }}<br>{{ $nota->nota_nueva }}</td>
										@php
											$nota_anterior += $nota->nota_anterior;
											$nota_nueva += $nota->nota_nueva;
											$contador++;
										@endphp
									{{-- @endif --}}
								@empty
									<td></td>
								@endforelse
							@endforeach
								{{-- @if ($contador < $relacion->Actividades->count())

									@for ($i = $contador; $i <= $relacion->Actividades->count() - $contador; $i++)
										<td></td>
									@endfor

								@endif --}}
							<td class="text-center">
								{{ $nota_anterior }} <br>
								{{ $nota_nueva }}
							</td>
							<td class="text-center">
								{{ $detalles->first()->Alumno->Escala($nota_anterior) }} <br>
								{{ $detalles->first()->Alumno->Escala($nota_nueva) }}
							</td>
							@if ($estatus_admin =='PROCESADO')
								<td>
									<x-select required wire:model.defer="estatus_alumno.{{$detalles->first()->Alumno->id}}" class="estatus_alumno">
										<option value="" class="seleccione" >SELECCIONE</option>
										<option value="APROBADO">APROBADO</option>
										<option value="RECHAZADO">RECHAZADO</option>
									</x-select>
								</td>
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<a href="{{ url()->previous() }}" class="btn btn-secondary btn-block">
				Atras
			</a>
		</div>
		<div class="col-md-4"></div>
		<div class="col-md-4">
			@if ($solicitud->estatus_admin == 'EN REVISION' &&  $solicitud->estatus_jefe == 'PROCESADO')
				<button class="btn btn-primary btn-block" wire:click='store'>
					Guardar
				</button>
			@endif
		</div>

	</div>


	<x-jet-dialog-modal wire:model.defer="confirmingPass">
		<x-slot name="title">
			{{ __('¿Esta seguro que desea guardar?') }}
		</x-slot>

		<x-slot name="content">
			{{ __('Ingrese su contraseña para confirmar que desea guardar.') }}

			<div class="mt-4" >
				<x-jet-input type="password" id="password" class="block w-full mt-1" placeholder="{{ __('Password') }}"
					x-ref="password" wire:model.defer="password" wire:keydown.enter="store" />

				<x-jet-input-error for="password" class="mt-2" />
			</div>
		</x-slot>

		<x-slot name="footer">
			<x-jet-secondary-button wire:click="$toggle('confirmingPass')" wire:loading.attr="disabled">
				{{ __('No') }}
			</x-jet-secondary-button>

			<x-jet-button class="ml-2" wire:click="store" wire:loading.attr="disabled">
				{{ __('Confirmar') }}
			</x-jet-button>
		</x-slot>
	</x-jet-dialog-modal>
</div>
