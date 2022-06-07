<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-2 md:grid-cols-2">

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Solicitudes') }}
            </h2>

            <x-breadcrumb>
                <li class="flex items-center">
                    <a href="{{ route('panel.docente.index') }}">Inicio</a>
                    <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('panel.docente.solicitudes.index') }}">Mis Solicitudes</a>
                    <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </li>
                <li>
                    <a class="text-gray-500" aria-current="page">Ver Solicitud</a>
                </li>
            </x-breadcrumb>

        </div>
    </x-slot>

    <div class="py-12">
        @include('alertas')
		@livewire('docente.alertas')
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
						<div class="grid grid-cols-2 gap-2">
							<div class="p-2 text-center">
								Estatus
								<div class="grid grid-cols-2 gap-2">
									<div class="p-2">
										PNF:


											{{ $solicitud->estatus_jefe }}

									</div>
									<div class="p-2">
										DRCAA:
										{{ $solicitud->estatus_admin }}
									</div>
								</div>
								<br>

							</div>
							<div class="p-2">
								Observación
								<br>

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
											{{-- @if ($solicitud->estatus_jefe =='PROCESADO')
											<th class="px-6 py-3 text-right">Acciones</th>
											@endif --}}
										</tr>
									</thead>
									<tbody>

										@php
										$c = 1;

										@endphp
										@foreach ($solicitud->Detalles->groupBy('alumno_id') as $key => $detalles)
										@php
											$nota_anterior = 0;
											$nota_nueva = 0;
											$contador = 0;
										@endphp
											<tr>
												<td class="text-center">{{ $c++ }}</td>
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
												{{-- @if ($solicitud->estatus_jefe =='PROCESADO')
													<td>
														{{ $detalles->first()->estatus_admin }}
													</td>
												@endif --}}
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

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>
	@section('scripts')
		<script>
			$(function () {
				$('#estatus_jefe').change(function (e) {
					e.preventDefault();
					if($(this).val() == 'APROBADO'){
						$('.estatus_alumno').val('APROBADO');
						$('.estatus_alumno').attr('disabled', 'true');
					}
					if($(this).val() == 'RECHAZADO'){
						$('.estatus_alumno').val('RECHAZADO');
						$('.estatus_alumno').attr('disabled', 'true');
					}
					if($(this).val() == 'PROCESADO'){
						$('.estatus_alumno').val('');
						$('.estatus_alumno').removeAttr('disabled');
					}
				});

				$('.estatus_alumno').change(function (e) {
					e.preventDefault();
					$('#estatus_jefe').val('PROCESADO');
					$('.seleccione').attr('disabled','true');
				});
			});
		</script>
	@endsection
</x-app-layout>
