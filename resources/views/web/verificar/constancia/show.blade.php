<x-guest-layout>
    {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
    {{-- <x-jet-validation-errors class="mb-4" /> --}}
    @php
        $inscrito = $estudiante->Inscrito->where('periodo_id', $periodo->id)->first();
        $fecha = \Carbon\Carbon::parse(@$inscrito->fecha)->format('d/m/Y');
		switch ($trayecto) {
                case 0:
                    $trayecto = 'TRAYECTO INICIAL';
                    break;
                case 1:
                    $trayecto = 'PRIMER TRAYECTO';
                    break;
                case 2:
                    $trayecto = 'SEGUNDO TRAYECTO';
                    break;
                case 3:
                    $trayecto = 'TERCER TRAYECTO';
                    break;
                case 4:
                    $trayecto = 'CUARTO TRAYECTO';
                    break;
                case 5:
                    $trayecto = 'QUINTO TRAYECTO';
                    break;

                default:
                    # code...
                    break;
            }
    @endphp

    <div class="flex flex-col items-center min-h-full pt-6 bg-gray-100 sm:justify-center sm:pt-0">
        <div class="w-11/12 pt-8">
            @include('alertas')
        </div>


        <div class="w-8/12 px-6 py-4 mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg hover:shadow-lg">
            <h4 class="my-4 text-2xl font-semibold text-center uppercase text-gray">Datos Del Estudiante</h4>
            <div class="grid md:grid-cols-3 sm:grid-cols-1">
                {{-- <div class=""F>
					NACIONALIDAD: {{ $graduando->nacionalidad }}
				</div> --}}
                <div class="uppercase ">
                    {{ $estudiante->nacionalidad == 'V' || $estudiante->nacionalidad == 'E' ? 'C.I.' : 'Pasaporte' }}
                    Número:
                    <b>{{ $estudiante->nacionalidad == 'V' ? $estudiante->nacionalidad . '-' . number_format($estudiante->cedula, 0, '', '.') : $estudiante->nacionalidad . '-' . $estudiante->cedula }}</b>
                </div>
                <div class="md:text-center">
                    NOMBRES:
                    <b>{{ $estudiante->nombres }}</b>
                </div>
                <div class="md:text-right">
                    APELLIDOS:
                    <b>{{ $estudiante->apellidos }}</b>
                </div>
            </div>
            <hr class="my-3">
            <div class="grid md:grid-cols-2 sm:grid-cols-1">
                <div class="">
                    PROGRAMA NACIONAL DE FORMACION EN:
                    <b>{{ $estudiante->Pnf->nombre }}</b>
                </div>
                <div class="md:text-right">
                    FECHA DE INSCRIPCIÓN:
					@if ($estudiante->InscritoActual())
						<b>{{ $fecha }}</b>
					@else
						<b>--/--/----</b>
					@endif
                </div>
            </div>
        </div>

        @if ($estudiante->InscritoActual())
            <div class="w-8/12 px-6 py-4 mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg hover:shadow-lg">
                <h4 class="my-4 text-2xl font-semibold text-center uppercase text-gray">DATOS DE LA CONSTANCIA DE ESTUDIOS
                </h4>
                <hr>
				<div class="grid md:grid-cols-3 sm:grid-cols-1">
					{{-- <div class=""F>
						NACIONALIDAD: {{ $graduando->nacionalidad }}
					</div> --}}
					<div class="uppercase ">
						EMITIDA:
						<b>{{ \Carbon\Carbon::now()->dayOfYear($dia)->format('d/m/Y'); }}</b>
					</div>
					<div class="md:text-center">
						TRAYECTO:
						<b>{{ $trayecto }}</b>
					</div>
					<div class="md:text-right">
						DURACIÓN:
						 <u style=" "><b>Desde Septiembre del 2022 hasta Julio 2023.</b></u>
					</div>
				</div>

            </div>
        @else
            <div class="mb-3 -m-2 text-center w-full mt-4">

                <div class="p-2">
                    <div
                        class="inline-flex items-center w-1/2 p-2 text-sm leading-none text-red-600 bg-white rounded-full shadow text-teal">
                        <span
                            class="inline-flex items-center justify-center h-6 px-3 text-white bg-red-600 rounded-full">Error</span>
                        <span class="inline-flex px-2">  El estudiante no se encuentra activo en el periodo
							academico actual. </span>
                    </div>
                </div>

            </div>
        @endif
        <br>
        <br>
    </div>
</x-guest-layout>
