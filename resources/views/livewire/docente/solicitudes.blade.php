<div>
    <div class="py-12">
        @include('alertas')
        {{-- <x-jet-validation-errors class="mb-4" /> --}}
        <div class="w-full mb-3 -m-2 text-center" wire:loading>
            <div class="p-2">
                <div
                    class="inline-flex items-center w-1/2 p-2 text-sm leading-none text-blue-600 bg-white rounded-full shadow text-teal">
                    <span
                        class="inline-flex items-center justify-center h-6 px-3 text-white bg-blue-600 rounded-full">Info</span>
                    <span class="inline-flex px-2"> Procesando informarción por favor espere...</span>
                </div>
            </div>
        </div>
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-1 p-6 bg-opacity-25 md:grid-cols-1">
                    <div class="grid grid-cols-4 gap-2">
                        <div class="px-3">
                            <x-jet-label for="tipo" value="{{ __('tipo de solicitud') }}"
                                class="block font-bold tracking-wide capitalize" />
                            <x-select class="block w-full mt-1" name="tipo" id="tipo" wire:model="tipo_solicitud"  wire:loading.attr="disabled">
                                <option value="">SELECCIONE</option>
                                <option value="CORRECCION">CORRECCIÓN DE NOTA</option>
                                <option value="INCORPORAR">AÑADIR A SECCIÓN</option>
                                <option value="RESET">RESETEAR SECCIÓN</option>
                            </x-select>
                            <x-jet-input-error for="tipo_solicitud" />
                        </div>
                        <div class="px-3">
                            <x-jet-label for="periodo" value="{{ __('periodo') }}"
                                class="block font-bold tracking-wide capitalize" />
                            <x-select class="block w-full mt-1" name="periodo" id="periodo" wire:model="periodo"  wire:loading.attr="disabled">

                                <option value="">Seleccione</option>
                                @if (!is_null($tipo_solicitud))
                                    @foreach ($periodos as $periodo_p)
                                        <option value="{{ $periodo_p->periodo }}">{{ $periodo_p->periodo }}</option>
                                    @endforeach
                                @endif
                            </x-select>
                            <x-jet-input-error for="periodo" />
                        </div>
                        <div class="px-3">
                            <x-jet-label for="uc" value="{{ __('unidad curricular') }}"
                                class="block font-bold tracking-wide capitalize" />
                            <x-select class="block w-full mt-1" name="uc" id="uc" wire:model="uc"  wire:loading.attr="disabled">
                                <option value="">Seleccione</option>
                                @if (!is_null($periodo))
                                    @foreach ($ucs as $uc_l)
                                        <option value="{{ $uc_l->cod_desasignatura }}">
                                            {{ $uc_l->nombre_asignatura }}
                                            T-S-A({{ $uc_l->DesAsignatura->tri_semestre }})</option>
                                    @endforeach
                                @endif
                            </x-select>
                            <x-jet-input-error for="uc" />
                        </div>
                        <div class="px-3">
                            <x-jet-label for="seccion" value="{{ __('seccion') }}"
                                class="block font-bold tracking-wide capitalize" />
                            <x-select class="block w-full mt-1" name="seccion" id="seccion" wire:model="seccion"  wire:loading.attr="disabled">
                                <option value="">Seleccione</option>
                                @if (!is_null($uc))
                                    @foreach ($secciones as $seccion_l)
                                        <option value="{{ $seccion_l->seccion }}">{{ $seccion_l->seccion }}
                                        </option>
                                    @endforeach
                                @endif
                            </x-select>
                            <x-jet-input-error for="seccion" />
                        </div>
                    </div>
                    <div class="my-4">
                        <div class="px-3">
                            <x-jet-label for="motivo" value="{{ __('motivo') }}"
                                class="block font-bold tracking-wide capitalize" />
                            <x-jet-input id="motivo" class="block w-full mt-1 SoloNumeros" type="text" name="motivo"
                                :value="old('motivo')" wire:model.defer="motivo" required  wire:loading.attr="disabled"/>
                            <x-jet-input-error for="motivo" />
                        </div>
                    </div>
					@if ($tipo_solicitud != 'RESET')
                    <div class="px-3">
                        <div class="" wire::ignore>

                            {{-- @dump( $estudiante ) --}}
                            <x-jet-label for="estudiante" value="{{ __('estudiante') }}"
                                class="block font-bold tracking-wide capitalize" />
                            <x-select class="block w-full mt-1 select2" name="estudiante" id="select2-alumnos"
                                wire:model="estudiante" multiple  wire:loading.attr="disabled">
                                <option value="">Seleccione</option>
                                @if (!is_null($seccion))
                                    @foreach ($estudiantes as $estudiante)
                                        @if ($tipo_solicitud == 'CORRECCION')
                                            <option value="{{ $estudiante->cedula }}">{{ $estudiante->cedula }} {{ $estudiante->nombres }}
                                                {{ $estudiante->apellidos }}</option>
                                        @else
                                            <option value="{{ $estudiante->cedula }}">{{ $estudiante->cedula }} {{ $estudiante->nombres }}
                                                {{ $estudiante->apellidos }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </x-select>
                            <x-jet-input-error for="estudiante" />
                        </div>
                    </div>
					@endif
                    <div class="p-6">
                        {{-- @dump( $correcciones ) --}}
                        {{-- @dump( $estudiantes_add ) --}}
                        {{-- {{ count($estudiantes_add) }} --}}
						@if ($tipo_solicitud != 'RESET')
							<table id="" class="min-w-full divide-y divide-gray-200"
								style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
								<thead>
									<tr>
										<th scope="col"
											class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"
											data-priority="5">N°</th>
										<th scope="col"
											class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"
											data-priority="1">Cedula</th>
										<th scope="col"
											class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"
											data-priority="2">Nombres</th>
										<th scope="col"
											class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"
											data-priority="3">Apellidos</th>
										<th scope="col"
											class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"
											data-priority="4">Acciones</th>
									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@if (!$errors->first('estudiante'))

										@foreach ($estudiantes_add as $key => $estudiante_a)
											@if ($tipo_solicitud == 'CORRECCION')
												<tr>
													<td class="px-6 py-4 whitespace-nowrap">{{ $key + 1 }}</td>
													<td class="px-6 py-4 whitespace-nowrap">
														{{ $estudiante_a->Alumno->cedula }}</td>
													<td class="px-6 py-4 whitespace-nowrap">
														{{ $estudiante_a->Alumno->nombres }}</td>
													<td class="px-6 py-4 whitespace-nowrap">
														{{ $estudiante_a->Alumno->apellidos }}</td>
													<td class="px-6 py-4 whitespace-nowrap">
														<div class="grid max-w-sm grid-cols-2">
															<div class="px-3">
																<x-jet-label for="nota_a" value="{{ __('nota actual') }}"
																	class="block font-bold tracking-wide capitalize" />
																<x-jet-input id="nota_a"
																	class="block w-full mt-1 SoloNumeros" type="text"
																	name="nota_a"
																	value="{{ $estudiante_a->Alumno->NotaUc(Auth::user()->cedula, $periodo, $seccion, $uc)->nota }}"
																	:disabled="true" required />
															</div>
															<div class="px-3">
																<x-jet-label for="nota_correccion"
																	value="{{ __('corrección') }}"
																	class="block font-bold tracking-wide capitalize" />
																<x-jet-input id="nota_correccion"
																	class="block w-full mt-1 SoloNumeros" type="number"
																	name="nota_correccion" :value="old('nota_correccion')"
																	wire:model.defer="correcciones.{{ $estudiante_a->Alumno->cedula }}"
																	required wire:loading.attr="disabled" />
																<x-jet-input-error
																	for="correcciones.{{ $estudiante_a->Alumno->cedula }}" />

															</div>
														</div>
													</td>
												</tr>
											@else
												<tr>
													<td class="px-6 py-4 whitespace-nowrap">{{ $key + 1 }}</td>
													<td class="px-6 py-4 whitespace-nowrap">{{ $estudiante_a->cedula }}
													</td>
													<td class="px-6 py-4 whitespace-nowrap">{{ $estudiante_a->nombres }}
													</td>
													<td class="px-6 py-4 whitespace-nowrap">
														{{ $estudiante_a->apellidos }}</td>
													<td class="px-6 py-4 whitespace-nowrap"></td>
												</tr>
											@endif
										@endforeach
									@endif

								</tbody>

							</table>
						@endif

                        {{-- <x-jet-button class="float-right" wire:click="store">
                            GUARDAR
                        </x-jet-button> --}}

						<x-jet-button wire:click="confirmPass"  class="float-right" wire:loading.attr="disabled">
							{{ __('GUARDAR') }}
						</x-jet-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--
	<x-jet-dialog-modal :id="true" maxWidth="md">
		<x-slot name="title">

		</x-slot>

		<x-slot name="content">

		</x-slot>

		<x-slot name="footer">

		</x-slot>
	</x-jet-dialog-modal> --}}
    <!-- Logout Other Devices Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingPass">
        <x-slot name="title">
            {{ __('¿Esta seguro que desea generar una nueva solicitud?') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Ingrese su contraseña para confirmar que desea generar una nueva solicitud.') }}

            <div class="mt-4" >
                <x-jet-input type="password" class="block w-full mt-1" placeholder="{{ __('Password') }}"
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

@section('scripts')
    <script>
        $(document).on('change', '#select2-alumnos', function(e) {
            var data = $('#select2-alumnos').select2("val");
            // data = $.trim(data);
            // if (data ==="" || 0 === data.length) {
            // 	console.log('esta vacio '+data);
            // 	data = [];
            // }else{
            // 	console.log('no esta vacio '+data);
            // }
            @this.set('estudiante', data);
        });

    </script>
@endsection
