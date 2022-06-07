<x-guest-layout>

		<x-jet-authentication-card>
			<x-slot name="logo">
				<x-jet-authentication-card-logo />
			</x-slot>

			{{-- <x-jet-validation-errors class="mb-4" /> --}}
			 <div class="p-2">
				<div class="inline-flex items-center w-full p-2 text-sm leading-none text-yellow-600 bg-white rounded-full shadow text-teal">
					<span class="inline-flex items-center justify-center h-6 px-3 text-white bg-yellow-600 rounded-full">Alerta</span>
					<span class="inline-flex px-2"><h1>EL SISTEMA SE ENCUENTRA EN MANTENIMIENTO.</h1> </span>
				</div>
			</div>

		</x-jet-authentication-card>

	</x-guest-layout>
