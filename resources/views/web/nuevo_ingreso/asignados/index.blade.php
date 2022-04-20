<x-guest-layout>
    {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
    {{-- <x-jet-validation-errors class="mb-4" /> --}}

    <div class="flex flex-col items-center min-h-full pt-6 bg-gray-100 sm:justify-center sm:pt-0">
		<div class="w-11/12 pt-8">
			@include('alertas')
		</div>


		<div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-sm sm:max-w-lg sm:rounded-lg hover:shadow-lg">
			<h4 class="my-4 text-2xl font-semibold text-center uppercase text-gray">Consultar Asignado</h4>
            <form action="{{ route('nuevo-ingreso.asignados.buscar') }}" method="post">
                <div class="mb-6 -mx-3 md:flex">
                    @csrf
                    @method('POST')
                    <div class="px-3 md:w-1/2">
                        <x-jet-label for="nacionalidad" value="{{ __('Nacionalidad') }}"
                            class="block font-bold tracking-wide capitalize" />
                        <x-select class="block w-full mt-1" name="nacionalidad" id="nacionalidad">
                            <option value="V">Venezolano</option>
                            <option value="E">Extranjero</option>
                            <option value="P">Pasaporte</option>
                        </x-select>
                    </div>
                    <div class="px-3 mb-6 md:w-1/2 md:mb-0">
                        <x-jet-label for="cedula" value="{{ __('Cédula') }}"
                            class="block font-bold tracking-wide capitalize" />
                        <x-jet-input id="cedula" class="block w-full mt-1 SoloNumeros" type="text" name="cedula"
                            :value="old('cedula')" required autofocus />
							<x-jet-input-error for="cedula" />
                    </div>
                </div>
                <x-button color="gray" intensidad="900" class="w-full text-center">
                    Consultar
                </x-button>
            </form>
        </div>
    </div>
</x-guest-layout>
