<div>
    @include('alertas')

    <form method="POST" wire:submit.prevent="store">
        @csrf
        <x-web-card>

            <h4 class="my-4 text-2xl font-semibold uppercase text-gray">información personal</h4>
            <div class="mb-6 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/2 md:mb-0">
                    <x-jet-label for="cedula" value="{{ __('Cédula') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="cedula" wire:model.defer="cedula" class="block w-full mt-1 " type="text" name="cedula"
					:value="old('cedula')" disabled  />
					<x-jet-input-error for="cedula" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="nacionalidad" value="{{ __('Nacionalidad') }}"
                        class="block font-bold tracking-wide capitalize" />
                    <x-select class="block w-full mt-1" name="nacionalidad" id="nacionalidad" wire:model.defer="nacionalidad">
                        <option value="V">Venezolano</option>
                        <option value="E">Extranjero</option>
                    </x-select>
					<x-jet-input-error for="nacionalidad" />
                </div>
            </div>

            <div class="mb-6 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/2 md:mb-0">
                    <x-jet-label for="p_nombre" value="{{ __('Primer Nombre') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="p_nombre" class="block w-full mt-1 " type="text" name="p_nombre"
					:value="old('p_nombre')"  wire:model.defer="p_nombre" />
					<x-jet-input-error for="p_nombre" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="s_nombre" value="{{ __('Segundo Nombre') }}"
					class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="s_nombre" class="block w-full mt-1 " type="text" name="s_nombre"
                        :value="old('s_nombre')"  wire:model.defer="s_nombre" />
					<x-jet-input-error for="s_nombre" />
                </div>
            </div>

            <div class="mb-6 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/2 md:mb-0">
                    <x-jet-label for="p_apellido" value="{{ __('Primer apellido') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="p_apellido" class="block w-full mt-1 " type="text" name="p_apellido"
					:value="old('p_apellido')"  wire:model.defer="p_apellido"/>
					<x-jet-input-error for="p_apellido" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="s_apellido" value="{{ __('Segundo apellido') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="s_apellido" class="block w-full mt-1 " type="text" name="s_apellido"
					:value="old('s_apellido')"  wire:model.defer="s_apellido"/>
					<x-jet-input-error for="s_apellido" />
                </div>
            </div>

            <div class="mb-6 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/2 md:mb-0">
                    <x-jet-label for="escivil" value="{{ __('Estado civil') }}"
                        class="block font-bold tracking-wide capitalize" />
                    <x-select class="block w-full mt-1" name="escivil" id="escivil" wire:model.defer="escivil">
                        <option value="SOLTERO">SOLTERO</option>
                        <option value="CASADO">CASADO</option>
                        <option value="DIVORCIADO">DIVORCIADO</option>
                        <option value="VIUDO">VIUDO</option>
                    </x-select>
					<x-jet-input-error for="escivil" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="sexo" value="{{ __('sexo') }}"
                        class="block font-bold tracking-wide capitalize" />
                    <x-select class="block w-full mt-1" name="sexo" id="sexo"  wire:model.defer="sexo">
                        <option value="F">Femenino</option>
                        <option value="M" selected="">Masculino</option>
                    </x-select>
					<x-jet-input-error for="sexo" />
                </div>
            </div>

            <div class="mb-6 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/2 md:mb-0">
                    <x-jet-label for="fechan" value="{{ __('fecha de nacimiento') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="fechan" class="block w-full mt-1 " type="date" name="fechan"
					:value="old('fechan')"   wire:model.defer="fechan"/>
					<x-jet-input-error for="fechan" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="lugarn" value="{{ __('lugar de nacimiento') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="lugarn" class="block w-full mt-1 " type="text" name="lugarn"
					:value="old('lugarn')"   wire:model.defer="lugarn"/>
					<small class="text-sm font-medium text-gray-400">Ciudad, Estado</small>
					<x-jet-input-error for="lugarn" />
                </div>
            </div>

        </x-web-card>

        <x-web-card>
            <h4 class="my-4 text-2xl font-semibold uppercase text-gray">información de contacto</h4>
            <div class="mb-1 -mx-3 md:flex">
                <div class="px-2 text-center md:w-full ">
                    <h4 class="my-4 text-lg font-semibold tracking-wide capitalize text-gray">Dirección</h4>
                </div>
            </div>
            <div class="mb-2 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/2 md:mb-0">
                    <x-jet-label for="estado" value="{{ __('Estado') }}"
                        class="block font-bold tracking-wide capitalize" />
                    <x-select class="block w-full mt-1" name="estado" id="estado" wire:model="estado">
						<option value="" >SELECCIONE</option>
						@foreach ($estados as $select_estado)
	                        <option value="{{ $select_estado->id }}">{{ $select_estado->estado }}</option>
						@endforeach
                    </x-select>
					<x-jet-input-error for="estado" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="municipio" value="{{ __('municipio') }}"
                        class="block font-bold tracking-wide capitalize" />
                    <x-select class="block w-full mt-1" name="municipio" id="municipio" wire:model="municipio">
						<option value="" >SELECCIONE</option>
						@if (!is_null($estado))
							@foreach ($municipios as $select_municipio)
								<option value="{{ $select_municipio->id }}">{{ $select_municipio->municipio }}</option>
							@endforeach
						@else
							<option value="" disabled>NO HAY MUNICIPIOS DISPONIBLES</option>
						@endif
                    </x-select>
					<x-jet-input-error for="municipio" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="parroquia" value="{{ __('parroquia') }}"
                        class="block font-bold tracking-wide capitalize" />
                    <x-select class="block w-full mt-1" name="parroquia" id="parroquia"  wire:model="parroquia">
						<option value="" >SELECCIONE</option>
                        @if (!is_null($municipio))
							@foreach ($parroquias as $select_parroquia)
								<option value="{{ $select_parroquia->id }}">{{ $select_parroquia->parroquia }}</option>
							@endforeach
						@else
							<option value="" disabled>NO HAY PARROQUIAS DISPONIBLES</option>
						@endif
					</x-select>
					<x-jet-input-error for="parroquia" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="direccion" value="{{ __('Dirección') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="direccion" class="block w-full mt-1 " type="text" name="direccion"
					:value="old('direccion')"  wire:model.defer="direccion" />
					<x-jet-input-error for="direccion" />
                </div>
            </div>

            <div class="mb-1 -mx-3 md:flex">
                <div class="px-2 text-center md:w-full ">
                    <h4 class="my-4 text-lg font-semibold tracking-wide capitalize text-gray">redes sociales</h4>
                </div>
            </div>
            <div class="mb-2 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/2 md:mb-0">
                    <x-jet-label for="twitter" value="{{ __('twitter') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="twitter" class="block w-full mt-1 " type="text" name="twitter"
					:value="old('twitter')"  wire:model.defer="twitter" placeholder="@usuario"/>
					<x-jet-input-error for="twitter" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="facebook" value="{{ __('facebook') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="facebook" class="block w-full mt-1 " type="text" name="facebook"
					:value="old('facebook')"  wire:model.defer="facebook"/>
					<x-jet-input-error for="facebook" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="instagram" value="{{ __('Instagram') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="instagram" class="block w-full mt-1 " type="text" name="instagram"
					:value="old('instagram')"  wire:model.defer="instagram" placeholder="@usuario"/>
					<x-jet-input-error for="instagram" />
                </div>
            </div>
            <div class="mb-2 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/2 md:mb-0">
                    <x-jet-label for="telefono" value="{{ __('telefono') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="telefono" class="block w-full mt-1 " type="text" name="telefono"
					:value="old('telefono')"  wire:model.defer="telefono"/>
					<x-jet-input-error for="telefono" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="correo" value="{{ __('correo') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="correo" class="block w-full mt-1" type="email" name="correo"
					:value="old('correo')"  wire:model.defer="correo"/>
					<small class="text-sm font-medium text-gray-400">Debe de estar activo, recibirá información</small>
					<x-jet-input-error for="correo" />
                </div>
                <div class="px-3 md:w-1/2">
                    <x-jet-label for="correo_alternativo" value="{{ __('correo alternativo') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="correo_alternativo" class="block w-full mt-1" type="email"
					name="correo_alternativo" :value="old('correo_alternativo')"  wire:model.defer="correo_alternativo"/>
					<x-jet-input-error for="correo_alternativo" />
                </div>
            </div>
        </x-web-card>

        <x-web-card>
            <h4 class="my-4 text-2xl font-semibold uppercase text-gray">información de medica</h4>
            <div class="mb-1 -mx-3 md:flex">
                <div class="px-2 text-center md:w-full ">
                    <h4 class="my-4 text-lg font-semibold tracking-wide capitalize text-gray">¿Posee alguna
                        discapacidad?</h4>
                </div>
            </div>
            <div class="mb-2 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/3 md:mb-0">
                    <x-select class="block w-full mt-1" name="posee_discapacidad" id="posee_discapacidad" wire:model="posee_discapacidad">
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </x-select>
					<x-jet-input-error for="posee_discapacidad" />
                </div>
                <div class="px-3 md:w-2/3">
					<x-jet-input id="discapacidad" class="block w-full mt-1 " type="text" name="discapacidad"
                        :value="old('discapacidad')"  placeholder="¿cual?"  wire:model="discapacidad" :disabled="$posee_discapacidad == 'NO'"/>
					<x-jet-input-error for="discapacidad" />
                </div>
            </div>

            <div class="mb-1 -mx-3 md:flex">
                <div class="px-2 text-center md:w-full ">
                    <h4 class="my-4 text-lg font-semibold tracking-wide capitalize text-gray">¿Posee alguna enfermedad
                        crónica?</h4>
                </div>
            </div>
            <div class="mb-2 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-1/3 md:mb-0">
                    <x-select class="block w-full mt-1" name="posee_enfermedad" id="posee_enfermedad" wire:model="posee_enfermedad">
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </x-select>
					<x-jet-input-error for="posee_enfermedad" />
                </div>
                <div class="px-3 md:w-2/3">
					<x-jet-input id="enfermedad" class="block w-full mt-1 " type="text" name="enfermedad"
                        :value="old('enfermedad')"  placeholder="¿cual?" wire:model="enfermedad" :disabled="$posee_enfermedad == 'NO'" />
					<x-jet-input-error for="enfermedad" />
                </div>
            </div>

            <div class="my-4 mb-1 -mx-3 md:flex">
                <div class="px-2 md:w-full">
                    <x-jet-label for="llamar_emergencia" value="{{ __('¿A quien llamar en caso de emergencia?') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="llamar_emergencia" class="block w-full mt-1 " type="text" name="llamar_emergencia"
					:value="old('llamar_emergencia')"  wire:model="llamar_emergencia" placeholder="Nombre, apellido y numero telefonico"/>
					<small class="text-sm font-medium text-gray-400">Nombre, apellido y numero telefonico</small>
					<x-jet-input-error for="llamar_emergencia" />
                </div>
            </div>
        </x-web-card>

        <x-web-card>
            <h4 class="my-4 text-2xl font-semibold uppercase text-gray">información laboral</h4>
            <div class="mb-2 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-full md:mb-0">
                    <x-jet-label for="trabaja" value="{{ __('¿Trabaja?') }}"
                        class="block font-bold tracking-wide capitalize" />
                    <x-select class="block w-full mt-1" name="" id="" wire:model="trabaja">
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </x-select>
					<x-jet-input-error for="trabaja" />
                </div>
                <div class="px-3 md:w-full">
                    <x-jet-label for="direccion_trabajo" value="{{ __('Dirección') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="direccion_trabajo" class="block w-full mt-1 " type="text" name="direccion_trabajo"
					:value="old('direccion_trabajo')"  wire:model.defer="direccion_trabajo" :disabled="$trabaja == 'NO'"/>
					<x-jet-input-error for="direccion_trabajo" />
                </div>
                <div class="px-3 md:w-full">
                    <x-jet-label for="telefono_trabajo" value="{{ __('Télefono') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="telefono_trabajo" class="block w-full mt-1 " type="text" name="telefono_trabajo"
					:value="old('telefono_trabajo')"  wire:model.defer="telefono_trabajo" :disabled="$trabaja == 'NO'"/>
					<x-jet-input-error for="telefono_trabajo" />
                </div>
            </div>

        </x-web-card>

        <x-web-card>
            <h4 class="my-4 text-2xl font-semibold uppercase text-gray">información complementaria</h4>
            <div class="mb-1 -mx-3 md:flex">
                <div class="px-2 md:w-full">
                    <x-jet-label for="carnet_patria" value="{{ __('Carnet de la patria') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="carnet_patria" class="block w-full mt-1" type="text" name="carnet_patria"
					:value="old('carnet_patria')"  wire:model.defer="carnet_patria"/>
					<x-jet-input-error for="carnet_patria" />
                </div>
            </div>

            <div class="mb-1 -mx-3 md:flex">
                <div class="px-2 text-center md:w-full ">
                    <h4 class="my-4 text-lg font-semibold tracking-wide capitalize text-gray">¿Pertenece a una etnia
                        indigena?</h4>
                </div>
            </div>

            <div class="mb-2 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-full md:mb-0">
                    {{-- <x-jet-label for="trabaja" value="{{ __('¿Trabaja?') }}" class="block font-bold tracking-wide capitalize" /> --}}
                    <x-select class="block w-full mt-1" name="pertenece_etnia" id="pertenece_etnia"  wire:model="pertenece_etnia">
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </x-select>
					<x-jet-input-error for="pertenece_etnia" />
                </div>
                <div class="px-3 md:w-full">
                    {{-- <x-jet-label for="direccion_t" value="{{ __('Dirección') }}" class="block font-bold tracking-wide capitalize" /> --}}
					<x-jet-input id="etnia" class="block w-full mt-1 " type="text" name="etnia"
                        :value="old('etnia')"  placeholder="¿cual?"  wire:model.defer="etnia" :disabled="$pertenece_etnia == 'NO'"/>
					<x-jet-input-error for="etnia" />
                </div>

            </div>

            <div class="mb-2 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-full md:mb-0">
                    <x-jet-label for="madre" value="{{ __('nombre y apellido de la madre') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="madre" class="block w-full mt-1 " type="text" name="madre"
					:value="old('madre')"  wire:model.defer="madre"/>
					<x-jet-input-error for="madre" />

                </div>
                <div class="px-3 md:w-full">
                    <x-jet-label for="tlf_madre" value="{{ __('Télefono') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="tlf_madre" class="block w-full mt-1 " type="text" name="tlf_madre"
					:value="old('tlf_madre')"  wire:model.defer="tlf_madre"/>
					<x-jet-input-error for="tlf_madre" />
                </div>
            </div>

            <div class="mb-2 -mx-3 md:flex">
                <div class="px-3 mb-6 md:w-full md:mb-0">
                    <x-jet-label for="padre" value="{{ __('nombre y apellido del padre') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="padre" class="block w-full mt-1 " type="text" name="padre"
					:value="old('padre')"  wire:model.defer="padre"/>
					<x-jet-input-error for="padre" />

                </div>
                <div class="px-3 md:w-full">
                    <x-jet-label for="tlf_padre" value="{{ __('Télefono') }}"
                        class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="tlf_padre" class="block w-full mt-1 " type="text" name="tlf_padre"
					:value="old('tlf_padre')"  wire:model.defer="tlf_padre"/>
					<x-jet-input-error for="tlf_padre" />
                </div>
            </div>

			<div class="mb-2 -mx-3 md:flex">
				<div class="px-3 mb-6 md:w-full md:mb-0">
					<x-jet-label for="ingreso" value="{{ __('año de Ingreso a la UPTBolivar antiguo IUTEB') }}"
						class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="ingreso" class="block w-full mt-1 " type="text" name="ingreso"
					:value="old('ingreso')"  wire:model.defer="ingreso" :disabled="$ingreso != null" />
					<x-jet-input-error for="ingreso" />

				</div>
				<div class="px-3 mb-6 md:w-full md:mb-0">
					<x-jet-label for="pnf" value="{{ __('PNF') }}"
						class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="pnf" class="block w-full mt-1 " type="text" name=""
					:disabled="true" wire:model.defer="pnf"/>
					<x-jet-input-error for="pnf" />

				</div>
				<div class="px-3 md:w-full">
					<x-jet-label for="nucleo" value="{{ __('Nucleo') }}"
						class="block font-bold tracking-wide capitalize" />
					<x-select class="block w-full mt-1" name="nucleo" id="nucleo"  wire:model="nucleo">
						@foreach ($nucleos as $key => $nucleo)
							<option value="{{ $key }}">{{ $nucleo }}</option>
						@endforeach
					</x-select>
					<x-jet-input-error for="nucleo" />
				</div>
			</div>
            <div class="mb-1 -mx-3 md:flex">
                <div class="px-2 text-center md:w-full ">
                    <h4 class="my-4 text-lg font-semibold tracking-wide capitalize text-gray">¿Posee equipos
                        electrónicos?</h4>
                </div>
            </div>
            <div class="mb-2 -mx-3 md:flex">
                <div class="px-2 text-center md:w-full ">
                    {{-- <h4 class="my-4 text-lg font-semibold tracking-wide capitalize text-gray">¿Posee equipos electrónicos?</h4> --}}
                    <label class="mr-5 font-bold custom-control custom-checkbox">
                        <input type="checkbox" name="equipos[]" value="TABLET"
                            class="custom-control-input" wire:model="equipos.TABLET">
                        <span class="custom-control-indicator">TABLET</span>
                    </label>
                    <label class="mr-5 font-bold custom-control custom-checkbox">
                        <input type="checkbox" name="equipos[]" value="TELEFONO INTELIGENTE"
                            class="custom-control-input" wire:model="equipos.TELEFONO INTELIGENTE">
                        <span class="custom-control-indicator">TELEFONO INTELIGENTE</span>
                    </label>
                    <label class="mr-5 font-bold custom-control custom-checkbox">
                        <input type="checkbox" name="equipos[]" value="COMPUTADORA DE ESCRITORIO"
                            class="custom-control-input" wire:model="equipos.COMPUTADORA DE ESCRITORIO">
                        <span class="custom-control-indicator">COMPUTADORA DE ESCRITORIO</span>
                    </label>
                    <label class="mr-5 font-bold custom-control custom-checkbox">
                        <input type="checkbox" name="equipos[]" value="LAPTOP"
                            class="custom-control-input" wire:model="equipos.LAPTOP">
                        <span class="custom-control-indicator">LAPTOP</span>
                    </label>
                </div>
            </div>
            <div class="mb-1 -mx-3 md:flex">
                <div class="px-2 text-center md:w-full ">
                    <h4 class="my-4 text-lg font-semibold tracking-wide capitalize text-gray">¿Tiene acceso a internet?
                    </h4>
                </div>
            </div>
            <div class="pb-5 mb-2 -mx-3 md:flex">
                <div class="px-2 text-center md:w-full ">
                    {{-- <h4 class="my-4 text-lg font-semibold tracking-wide capitalize text-gray">¿Posee equipos electrónicos?</h4> --}}
                    <label class="mr-5 font-bold custom-control custom-checkbox">
                        <input type="checkbox" name="internet[]" value="CANTV"
                            class="custom-control-input" wire:model="internet.CANTV">
                        <span class="custom-control-indicator">CANTV</span>
                    </label>
                    <label class="mr-5 font-bold custom-control custom-checkbox">
                        <input type="checkbox" name="internet[]" value="INTER CABLE"
                            class="custom-control-input" wire:model="internet.INTER CABLE">
                        <span class="custom-control-indicator">INTER CABLE</span>
                    </label>
                    <label class="mr-5 font-bold custom-control custom-checkbox">
                        <input type="checkbox" name="internet[]" value="DATOS MOVILES"
                            class="custom-control-input" wire:model="internet.DATOS MOVILES">
                        <span class="custom-control-indicator">DATOS MOVILES</span>
                    </label>
                    <label class="mr-5 font-bold custom-control custom-checkbox">
                        <input type="checkbox" name="internet[]" value="OTRO"
                            class="custom-control-input" wire:model="internet.OTRO">
                        <span class="custom-control-indicator">OTRO</span>
                    </label>
                </div>
            </div>

        </x-web-card>

        {{-- <x-web-card> --}}
        <div class="min-h-full flex flex-col {{-- sm:justify-center --}} items-center pt-6 sm:pt-0 mb-10">
            <div class="w-full mt-6 overflow-hidden text-center sm:max-w-7xl sm:rounded-lg">
                <x-button color="blue" intensidad="600" class="text-center w-50">
                    Guardar
                </x-button>
            </div>
        </div>
        {{-- </x-web-card> --}}
    </form>
</div>
