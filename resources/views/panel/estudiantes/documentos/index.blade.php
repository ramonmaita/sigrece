<x-app-layout>
    <x-slot name="header">
    	<div class="grid grid-cols-2 md:grid-cols-2">

	        <h2 class="text-xl font-semibold leading-tight text-gray-800">
	            {{ __('Inicio') }}
	        </h2>

	        <x-breadcrumb>
	        	<li class="flex items-center">
			      <a href="{{ route('panel.estudiante.index') }}">Inicio</a>
			      <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
			    </li>
			    <li>
			      <a  class="text-gray-500" aria-current="page">Documentos</a>
			    </li>
	        </x-breadcrumb>

    	</div>
    </x-slot>
	<div class="max-w-full pt-12 mx-auto sm:px-6 lg:px-8">
		<div class="overflow-hidden sm:rounded-lg">
			{{-- <x-jet-welcome /> --}}
			<div class="grid grid-cols-2 gap-2 bg-opacity-25 md:grid-cols-4">
			    @php
			        $cerrado = false;
			    @endphp
				@if (Auth::user()->Alumno)
					@if (Auth::user()->Alumno->InscritoActual() && $cerrado == false)
						<x-link href="{{ route('panel.estudiante.documentos.comprobante.pdf') }}" target="documento" color="blue" intensidad="700" class="py-5 show-documento">
							COMPROBANTE DE INSCRIPCION
						</x-link>
						<x-link color="blue" intensidad="500" class="py-5 show-documento">
						{{-- <x-link href="{{ route('panel.estudiante.documentos.constancia.pdf') }}" target="documento" color="blue" intensidad="700" class="py-5 show-documento"> --}}
							CONSTANCIA DE ESTUDIO
						</x-link>
						<x-link color="blue" intensidad="500" class="py-5 show-documento">
						{{-- <x-link href="{{ route('panel.estudiante.documentos.notas.pdf') }}" target="documento" color="blue" intensidad="700" class="py-5 show-documento"> --}}
							CONSTANCIA DE CALIFICACIONES
						</x-link>
						{{-- <x-link href="{{ route('panel.estudiante.documentos.notas.pdf') }}" target="documento" color="blue" intensidad="700" class="py-5 show-documento">
							CONSTANCIA DE CALIFICACIONES
						</x-link> --}}
						<x-link color="blue" intensidad="500" class="py-5 show-documento">
							CARNET ESTUDIANTIL
						</x-link>
					@else
						<x-link color="blue" intensidad="500" class="py-5 show-documento">
							COMPROBANTE DE INSCRIPCION
						</x-link>
						<x-link color="blue" intensidad="500" class="py-5 show-documento">
							CONSTANCIA DE ESTUDIO
						</x-link>
						<x-link href="{{ route('panel.estudiante.documentos.notas.pdf') }}" target="documento" color="blue" intensidad="700" class="py-5 show-documento">
							CONSTANCIA DE CALIFICACIONES
						</x-link>
						<x-link color="blue" intensidad="500" class="py-5 show-documento">
							CARNET ESTUDIANTIL
						</x-link>

					@endif
				@endif
			</div>
		</div>
	</div>
	<div class="max-w-xl py-2 mx-auto sm:px-6 lg:px-8">
		<div class="overflow-hidden sm:rounded-lg">
			<div class="items-center p-2" id="alerta">
				<div class="inline-flex items-center w-full p-2 text-sm leading-none text-red-600 bg-white rounded-full shadow text-teal">
					<span class="inline-flex items-center justify-center h-6 px-3 text-white bg-red-600 rounded-full">Error</span>
					<span class="inline-flex px-2">No es posible solicitar este documento por los momentos.</span>
				</div>
			</div>
		</div>
	</div>
    <div class="py-6" id="div-show-documento">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
					{{-- <div class="p-10">
						<h4 class="text-lg font-semibold leading-tight">
							Bienvenido(a) Estudiante {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
						</h4>
					</div> --}}
					<div class="">
						<iframe id="documento" name="documento" frameborder="0" width="100%"></iframe>
					</div>
				</div>
            </div>
        </div>
    </div>


	@section('scripts')
		<script>
			$(function () {
				$('#div-show-documento,#alerta').hide();
				$('.show-documento').click(function (e) {
					// e.preventDefault();
					var uri = $(this).attr('href');
					console.log(uri);
					if(uri){
						$('#alerta').hide();
						$('#documento').attr('height', '500px');
						$('#div-show-documento').show();
						$('#documento').show();
					}else{
						$('#documento').hide();
						$('#alerta').show();
						// $('#div-show-documento').hide();
						$('#documento').attr('height', '0px')
						$('#documento').attr('href', uri)
					}

				});

			});
		</script>
	@endsection
</x-app-layout>
