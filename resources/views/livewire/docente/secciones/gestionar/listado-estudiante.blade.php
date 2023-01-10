 <div>
    <x-jet-validation-errors class="mb-4" />
    {{-- <a href="{{ route('panel.docente.secciones.gestion.lista_estudiantes',['seccion' => $relacion->seccion_id, 'desasignatura' => $relacion->des_asignatura_id]) }}" role="button" class="">IMPRIMIR</a> --}}
    <form wire:submit.prevent="store">
        @php
            $actual = \Carbon\Carbon::now()->toDateTimeString();
            // $actual = date('Y-m-d H:i:s', strtotime(\Carbon\Carbon::now()));
            // return dd($actual);
            $cerrado = true;
            $evento_solicitud_correccion = \App\Models\Evento::where('tipo', 'CARGA DE CALIFICACIONES')
                ->where('evento_padre', 0)
                ->where('inicio', '<=', $actual)
                ->where('fin', '>=', $actual)
                ->orderBy('id', 'desc')
                ->first();
            // return dd($evento_solicitud_correccion);
            if ($evento_solicitud_correccion) {
                $aplicable = json_decode($evento_solicitud_correccion->aplicable);
                if ($evento_solicitud_correccion->aplicar == 'TODOS') {
                    $cerrado = false;
                } elseif ($evento_solicitud_correccion->aplicar == 'ESPECIFICO' && array_search(Auth::user()->cedula, $aplicable[1]) !== false) {
                    $cerrado = false;
                }
            }

        @endphp
        @if ($cerrado == true)
            <div class="mb-3 -m-2 text-center ">

                <div class="p-2">
                    <div
                        class="inline-flex items-center w-1/2 p-2 text-sm leading-none text-yellow-600 bg-white rounded-full shadow text-teal">
                        <span
                            class="inline-flex items-center justify-center h-6 px-3 text-white bg-yellow-600 rounded-full">Alerta</span>
                        <span class="inline-flex px-2">El proceso de carga de calificaciones se encuentra cerrado.
                        </span>
                    </div>
                </div>
            </div>
        @endif
		<div class="overflow-x-auto">

			<table class="max-w-full table-auto min-w-max divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th scope="col" data-priority="1"
							class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
							cedula
						</th>
						<th scope="col" data-priority="2"
							class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
							nombres
						</th>
						<th scope="col" data-priority="3"
							class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
							apellidos
						</th>
						<th>
							<div class="overflow-x-auto">

								<table>
									<tr>
										@forelse ($relacion->Actividades as $key =>  $unidad)
											<th scope="col" data-priority="{{ $key + 4 }}"
												class="w-3 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
												{{ $unidad->actividad }} - {{ $unidad->porcentaje }}%
											</th>
										@empty
										@endforelse


									</tr>
								</table>
							</div>


						</th>
						@if (count($relacion->Actividades) > 0)
							<th scope="col" data-priority=""
								class="w-3 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
								Acum
								(0 - 100)
							</th>
							<th scope="col" data-priority=""
								class="w-3 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
								Acum
								(1 - 20)
							</th>
						@endif

					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					@foreach ($alumnos_inscritos as $inscritos)
						<tr>
							<td class="px-6 py-4 whitespace-nowrap">
								{{ $inscritos->nacionalidad }}-{{ $inscritos->cedula }}
							</td>
							<td class="px-6 py-4 whitespace-nowrap">
								{{ $inscritos->p_nombre }}
							</td>
							<td class="px-6 py-4 whitespace-nowrap">
								{{ $inscritos->p_apellido }}
							</td>
							<td>
								<div class="overflow-x-auto">

									<table>
										<tr>
											@forelse ($relacion->Actividades as $unidad)
											<td class="">
												{{-- {{ $unidad->Notas->where('estaus','CERRADO')->count() }} --}}
												@if ($unidad->Notas->where('estatus', 'CERRADO')->count() > 0 || $cerrado == true)
													@php
														$cerrado = true;
													@endphp
													{{ @$unidad->Nota($inscritos->id)->nota ? @$unidad->Nota($inscritos->id)->nota : 0 }}
												@else
													{{-- {{ @$unidad->Nota($inscritos->id)->nota }} --}}
													<x-jet-input id="nota.{{ $inscritos->id }}.{{ $unidad->id }}"
														class="block w-full mt-1 SoloNumeros" type="number" name="porcentaje" min="1" step="0.01"
														max="{{ $unidad->porcentaje }}" :value="@$unidad->Nota($inscritos->id)->nota"
														wire:model.defer="nota.{{ $inscritos->id }}.{{ $unidad->id }}"
														wire:loading.attr="disabled" size="4" />
													<x-jet-input-error for="nota.{{ $inscritos->id }}.{{ $unidad->id }}"
														:disabled="!empty($nota[$inscritos->id][$unidad->id]) ? true : true" />
													@error('nota.{{ $inscritos->id }}.{{ $unidad->id }}')
														{{ $message }}
													@enderror
													{{-- <input type="text" size="4"> --}}
												@endif
											</td>
											@empty
											@endforelse

										</tr>
									</table>
								</div>

							</td>
							@if (count($relacion->Actividades) > 0)
								<th>

									{{ $nota = $inscritos->NotasActividades($relacion->Actividades->pluck('id')) }}
								</th>
								<th>
									{{ $inscritos->Escala($nota) }}
								</th>
							@endif

						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

        <div class="grid grid-cols-{{ $cerrado != true && count($relacion->Actividades) > 0 ? '3' : '2' }} m-5">
            <div class="">
                <x-link href="{{ url()->previous() }}" color="gray" intensidad="500" class="justify-center w-1/2">
                    Atras
                </x-link>
            </div>
            <div class="">
                @php
                    $btn_cargar = $cerrado == true ? false : true;
                @endphp
                {{-- @switch($relacion->DesAsignatura->tri_semestre)
			@case(1)
			@php $btn_cargar = true; @endphp
			@break

			@case(4)
			@php $btn_cargar = true; @endphp
			@break

			@case(7)
			@php $btn_cargar = true; @endphp
			@break

			@case(9)
			@php $btn_cargar = true; @endphp
			@break

			@default
            @endswitch --}}
                @if ($btn_cargar == true && !isset($cerrar) && count($relacion->Actividades) > 0)
                    {{-- @if ($relacion->DesAsignatura->Asignatura->Plan->Cohorte == 'TRIMESTRE' && $btn_cargar == true && !isset($cerrar)) --}}
                    <center>

                        <x-jet-button
                            class="justify-center {{ $cerrado != true && count($relacion->Actividades) > 0 ? '' : 'float-right' }}   w-1/2">
                            Guardar
                        </x-jet-button>
                    </center>
                @endif

            </div>
            <div>
                @if (@$cerrado != true && count($relacion->Actividades) > 0)
                    <x-button type="button" class="justify-center  float-right w-1/2" role="button" color="red"
                        intensidad="500" wire:loading.attr="disabled" wire:click='confirmPass'
                        wire:submit.prevent="confirmPass">
                        CERRAR CARGA
                    </x-button>
                @endif
            </div>
        </div>
    </form>

    <x-jet-dialog-modal wire:model="confirmingPass">
        <x-slot name="title">
            {{ __('¿Esta seguro que desea cerrar el proceso de carga de calificaciones?') }}
        </x-slot>

        <x-slot name="content">
            @if ($confirmingPass)
                <script>
                    setTimeout(() => {

                        $('#password-{{ $desasignatura_id }}').focus();
                    }, 100);
                </script>
            @endif
            {{ __('Ingrese su contraseña para confirmar que desea el proceso de carga de calificaciones.') }}
            <span class=" text-red-600">UNA VEZ QUE SE CIERRA EL PROCESO DE CARGA DE CALIFICACIONES EN ESTE CORTE NO
                PODRA REALIZAR MODIFICACIONES SIN REALIZAR UN ACTA CORRECTIVA</span>

            <div class="mt-4">
                <x-jet-input type="password" id="password-{{ $desasignatura_id }}" class="block w-full mt-1"
                    placeholder="{{ __('Password') }}" x-ref="password" wire:model.defer="password"
                    wire:keydown.enter="cerrar" />

                <x-jet-input-error for="password" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingPass')" wire:loading.attr="disabled">
                {{ __('No') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="cerrar" wire:loading.attr="disabled">
                {{ __('Confirmar') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
