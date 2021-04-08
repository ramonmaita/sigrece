<x-guest-layout>
    {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
    {{-- <x-jet-validation-errors class="mb-4" /> --}}

	@livewire('web.estudiantes.datos',['alumno' => $alumno])
</x-guest-layout>
