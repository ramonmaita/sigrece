<x-app-layout>
    {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
    {{-- <x-jet-validation-errors class="mb-4" /> --}}
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
			@livewire('web.ingreso.form')
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
</x-app-layout>
