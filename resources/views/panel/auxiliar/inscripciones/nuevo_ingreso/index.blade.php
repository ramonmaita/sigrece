<x-app-layout>
    {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
    {{-- <x-jet-validation-errors class="mb-4" /> --}}

    <div class="flex flex-col items-center min-h-full pt-6 bg-gray-100 sm:justify-center sm:pt-0">
		<div class="w-11/12 pt-8">
			@include('alertas')
		</div>

		@php

			$inicio = \Carbon\Carbon::createFromFormat('H:i a', '08:00 AM');
			$fin = \Carbon\Carbon::createFromFormat('H:i a', '04:00 PM');
			$check_hora = \Carbon\Carbon::now()->between($inicio, $fin, true);
			$cerrado = true;
			if($check_hora || Auth::user()->hasRole('SupervisorNotas') || Auth::user()->hasRole('Admin')){
				$cerrado = false;
			}else{
				$cerrado = true;
			}
		@endphp

		@if($cerrado == false)
			<div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-sm sm:max-w-lg sm:rounded-lg hover:shadow-lg">
				<h4 class="my-4 text-2xl font-semibold text-center uppercase text-gray">Consultar Estudiante</h4>
				<form action="{{ route('panel.auxiliar.inscripciones.nuevo-ingreso.buscar_alumno') }}" method="post">
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
		@else
			<div class="w-11/12 pt-8">
				<div class="mb-3 -m-2 text-center ">

				<div class="p-2">
					<div
						class="inline-flex items-center w-1/2 p-2 text-sm leading-none text-yellow-600 bg-white rounded-full shadow text-teal">
						<span
							class="inline-flex items-center justify-center h-6 px-3 text-white bg-yellow-600 rounded-full">Alerta</span>
						<span class="inline-flex px-2">El proceso de inscripción se encuentra cerrado.
						</span>
					</div>
				</div>
			</div>
		</div>
		@endif
    </div>
</x-app-layout>
