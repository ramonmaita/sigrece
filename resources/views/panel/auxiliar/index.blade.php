<x-app-layout>
    <x-slot name="header">
    	<div class="grid grid-cols-2 md:grid-cols-2">

	        <h2 class="text-xl font-semibold leading-tight text-gray-800">
	            {{ __('Inicio') }}
	        </h2>

	        <x-breadcrumb>

			    <li>
			      <a href="#" class="text-gray-500" aria-current="page">Inicio</a>
			    </li>
	        </x-breadcrumb>

    	</div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
					<div class="p-10">
						<h4 class="text-lg font-semibold leading-tight">
							Bienvenido(a) {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
						</h4>
					</div>
				</div>
            </div>
        </div>
    </div>
</x-app-layout>
