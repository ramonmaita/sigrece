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
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            @include('alertas')
			{{-- @php
				$ci =[
					17163503,
					28736576,
					12600351,
					32070482,
					31543697

		];
				$saltar = array_search(Auth::user()->Alumno->cedula, $ci );
			@endphp --}}
            @if (Auth::user()->Alumno->InscritoActual())

                <div class="p-2">
                    <div
                        class="inline-flex items-center w-full p-2 text-sm leading-none text-green-600 bg-white rounded-full shadow text-teal">
                        <span
                            class="inline-flex items-center justify-center h-6 px-3 text-white bg-green-600 rounded-full">Exito</span>
                        <span class="inline-flex px-2"> Ya haz realizado el proceso de inscripción, ve al aparatado de
                            documentos para visualizar tu comprobante de inscripción</span>
                    </div>
                </div>
            @else
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    {{-- <x-jet-welcome /> --}}
                    <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 xl:grid-cols-1 ">
                        <x-jet-validation-errors class="py-2 mx-5 my-5 text-center text-white bg-red-200 rounded-xl" />

                        <div class="py-5">

                            <form
                                action="{{ route('panel.estudiante.inscripciones.nuevo-ingreso.seleccionar-seccion') }}"
                                method="post">
                                @csrf
                                @method('post')
                                {{-- <input type="hidden" name="alumno_id" value="{{ $alumno->id }}" readonly> --}}

                                <div class="px-3 ">
                                    <x-jet-label for="seccion" value="{{ __('Secciones') }}"
                                        class="block font-bold tracking-wide capitalize" />
                                    <x-select class="block w-full mt-1" name="seccion_id" id="seccion_id">
                                        @forelse($secciones as $seccion)
                                            <option value="{{ $seccion->id }}">{{ $seccion->nombre }}</option>
                                        @empty
                                            <option value="">NO HAY SECCIONES DISPONIBLES</option>
                                        @endempty
                                </x-select>
                            </div>


                            <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
                                {{-- <div class="w-full px-5 mt-6 overflow-hidden text-center sm:max-w-7xl sm:rounded-lg">
									<x-link href="{{ route('panel.estudiante.index') }}" color="gray" intensidad="700" class="w-full text-center">
										Cancelar
									</x-link>
								</div> --}}
                                <div
                                    class="w-full px-5 mt-6 overflow-hidden text-center sm:max-w-7xl sm:rounded-lg">
                                    @if (!isset($ocultar))
                                        <x-button color="gray" intensidad="900" class="w-full text-center">
                                            ver sección
                                        </x-button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        @endif
    </div>
</div>





@section('scripts')
    <script>
        $(function() {

        });
    </script>
@endsection
</x-app-layout>
