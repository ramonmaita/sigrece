<x-app-layout>
    {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
    {{-- <x-jet-validation-errors class="mb-4" /> --}}

	@if ($nuevo->Alumno)
		@livewire('web.estudiantes.datos',['alumno' => $nuevo->Alumno])
	@else
		@livewire('web.ingreso.form',['nuevo' => $nuevo])
	@endif
</x-app-layout>
