<div>
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
		<div class="grid overflow-hidden bg-white shadow-xl sm:rounded-lg">
			{{-- <x-jet-welcome /> --}}
			{{-- <div class="grid-cols-1 p-6 bg-gray-200 bg-opacity-25">
				<x-link class="float-right" href="{{ route('panel.docente.solicitudes.create') }}" :disabled="false" color="gray" intensidad="900">
					Nueva Solicitud
				</x-link>
			</div> --}}
			<div class="grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
				<form wire:submit.prevent="confirmPass">
					<input type="hidden" value="{{ $solicitud->id }}">
					<div class="grid grid-cols-3 gap-2">
						<div class="p-2">
							Fecha y Hora de la solicitud
							<br>
							{{ \Carbon\Carbon::parse($solicitud->fecha)->format('d/m/Y h:i:s A') }}
						</div>
						<div class="p-2">
							Solicitante
							<br>
							{{ $solicitud->Solicitante->nombre }} {{ $solicitud->Solicitante->apellido }}
						</div>
						<div class="p-2">
							Periodo
							<br>
							{{ $solicitud->periodo }}
						</div>
						<div class="p-2">
							   Unidad Curricular
							<br>
							{{ $solicitud->DesAsignatura->nombre }} {{ $solicitud->DesAsignatura->Asignatura->Plan->cohorte }}: {{ $solicitud->DesAsignatura->tri_semestre }}
						</div>
						<div class="p-2">
							Sección
							<br>
							{{ $solicitud->seccion }}
						</div>
						<div class="p-2">
							Motivo
							<br>
							{{ $solicitud->motivo }}
						</div>

					</div>
					<div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
						<div class="p-2 text-center">
							Estatus
							<div class="p-2">
								PNF:

								@if ($solicitud->estatus_jefe == 'EN REVISION')
									<x-select required wire:model="estatus_jefe" id="estatus_jefe">
										<option id="jefe-revision" value="EN REVISION" disabled >EN REVISION</option>
										<option id="jefe-aprobado" value="APROBADO">APROBAR TODA LA SOLICITUD</option>
										<option id="jefe-rechazado" value="RECHAZADO">RECHAZAR TODA LA SOLICITUD</option>
										<option id="jefe-procesado" value="PROCESADO">PROCESAR INDIVIDUAL</option>
									</x-select>
								@else
									{{ $solicitud->estatus_jefe }}
								@endif
								DRCAA:
								{{ $solicitud->estatus_admin }}
							</div>
							{{-- <div class="p-2">
							</div> --}}
							{{-- <div class="grid grid-cols-2 gap-2">
							</div> --}}
							{{-- <br> --}}

						</div>
						<div class="p-2">
							Observación
							<br>
							@if ($solicitud->estatus_jefe == 'EN REVISION')
							<x-jet-input type="text" id="" class="block w-full mt-1" wire:model="observacion"   autocomplete="off"  value="{{ $solicitud->observacion }}"	/>
							@endif
							{{ $solicitud->observacion }}
						</div>
					</div>

					<hr>

					<div class="grid grid-cols-1 gap-2">
						<div class="py-2 px-2 overflow-x-auto">
							<table class="w-full table-auto min-w-max" border="1">
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
										@if ($estatus_jefe =='PROCESADO')
										<th class="px-6 py-3 text-right">Acciones</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@php
										$c = 0;
										$nota_anterior = 0;
										$nota_nueva = 0;
									@endphp

									@foreach ($solicitud->Detalles->groupBy('alumno_id') as $key => $detalles)
										<tr>
											<td class="text-center">{{ $c+1 }}</td>
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
											@if ($estatus_jefe =='PROCESADO')
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

					<div class="grid grid-cols-2 m-5 mt-6">
						<div class="">
							<x-link href="{{ url()->previous() }}" color="gray" intensidad="500" class="justify-center w-1/2">
								Atras
							</x-link>
						</div>
						<div class="">
							@if ($solicitud->estatus_jefe == 'EN REVISION')
								<x-jet-button class="justify-center float-right w-1/2">
									Guardar
								</x-jet-button>
							@endif
						</div>
					</div>
				</form>
			</div>
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
