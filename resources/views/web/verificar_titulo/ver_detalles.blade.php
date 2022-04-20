<x-guest-layout>
    {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
    {{-- <x-jet-validation-errors class="mb-4" /> --}}


	@php
		function pnf($cod_pnf,$titulo)
		{
			$pnf = '';
			switch ($cod_pnf) {
				// CARRERAS
				case 25:
					return $pnf = 'Geología y Minas';
					break;
				case 30:
					return $pnf = 'Mecánica' ;
					break;
				case 35:
					return $pnf = 'Sistemas Industriales' ;
					break;
				// PNF
				case 40:
					return $pnf = ($titulo == 1) ? 'Electricidad' : 'Electricista' ;
					break;
				case 45:
					return $pnf = 'Geociencias' ;
					break;
				case 50:
					return $pnf = 'Informática' ;
					break;
				case 55:
					return $pnf = ($titulo == 1) ? 'Mantenimiento Industrial' : 'Mantenimiento' ;
					break;
				case 60:
					return $pnf = ($titulo == 1) ? 'Mecánica' : $retVal = ($graduando->Alumno->sexo == 'M') ? 'Mecánico' : 'Mecánica' ;
					break;
				case 65:
					return $pnf = 'Sistemas de Calidad y Ambiente' ;
					break;

				default:
					# code...
					break;
			}
		}
	@endphp
    <div class="flex flex-col items-center min-h-full pt-6 bg-gray-100 sm:justify-center sm:pt-0">
		<div class="w-11/12 pt-8">
			@include('alertas')
		</div>


		<div class="w-8/12 px-6 py-4 mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg hover:shadow-lg">
			<h4 class="my-4 text-2xl font-semibold text-center uppercase text-gray">Datos Del Graduado</h4>
            <div class="grid md:grid-cols-3 sm:grid-cols-1">
				{{-- <div class="">
					NACIONALIDAD: {{ $graduando->nacionalidad }}
				</div> --}}
				<div class="uppercase ">
					@if ($graduando->Alumno)
					{{ ($graduando->Alumno->nacionalidad == 'V' ||$graduando->Alumno->nacionalidad == 'E' ) ? 'C.I.' : 'Pasaporte'  }} Número: {{ ($graduando->Alumno->nacionalidad == 'V') ? $graduando->Alumno->nacionalidad.'-'.$graduando->Alumno->cedula : $graduando->Alumno->nacionalidad.'-'.$graduando->Alumno->cedula  }}
					@else
					{{ ($graduando->nacionalidad == 'V' ||$graduando->nacionalidad == 'E' ) ? 'C.I.' : 'Pasaporte'  }} Número: {{ ($graduando->nacionalidad == 'V') ? $graduando->nacionalidad.'-'.$graduando->cedula : $graduando->nacionalidad.'-'.$graduando->cedula  }}
					@endif
				</div>
				<div class="">
					NOMBRES:
					@if ($graduando->Alumno)
					{{  $graduando->Alumno->nombres }}
					@else
					{{  $graduando->nombres }}
					@endif
				</div>
				<div class="">
					APELLIDOS:
					@if ($graduando->Alumno)
					{{  $graduando->Alumno->apellidos }}
					@else
					{{  $graduando->apellidos }}
					@endif
				</div>
			</div>
        </div>

		<div class="w-8/12 px-6 py-4 mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg hover:shadow-lg">
			<h4 class="my-4 text-2xl font-semibold text-center uppercase text-gray">Titulos Obtenidos</h4>
			<hr>
			@forelse ($titulos as $titulo)
			<h4 class="my-4 text-lg font-semibold text-center uppercase text-gray">
				@if ($graduando->Alumno)
					@if ($titulo->titulo == 1)
						{{ $retVal = ($graduando->Alumno->sexo == 'M') ? 'Técnico Superior  Universitario' : ' Técnica Superior  Universitaria'  }}
					@elseif ($titulo->titulo == 3)
						Técnico Superior  Universitario
					@else
						{{ $retVal = ($graduando->Alumno->sexo == 'M') ? 'Ingeniero' : 'Ingeniera'  }}
					@endif

					@if ($titulo->titulo != 1)
						@if ($graduando->pnf != 40 && $graduando->pnf != 60)
							en
						@endif
					@else
						en
					@endif

					{{ pnf($graduando->pnf,$graduando->titulo) }}
				@else
					@if ($titulo->titulo == 1)
						{{ $retVal = ($alumno->sexo == 'M') ? 'Técnico Superior  Universitario' : ' Técnica Superior  Universitaria'  }}
					@elseif ($titulo->titulo == 3)
						Técnico Superior  Universitario
					@else
						{{ $retVal = ($alumno->sexo == 'M') ? 'Ingeniero' : 'Ingeniera'  }}
					@endif

					@if ($titulo->titulo != 1)
						@if ($graduando->pnf != 40 && $graduando->pnf != 60)
							en
						@endif
					@else
						en
					@endif
				@endif
			</h4>
			<div class="grid md:grid-cols-4 sm:grid-cols-1">
				<div class="">
					N° de Titulo: {{ $titulo->nro_titulo }}
				</div>
				<div class="">
					N° de Acta: {{ $titulo->nro_acta }}
				</div>
				<div class="">
					N° de Libro: {{ $titulo->libro }}
				</div>
				<div class="">
					Egreso: {{ \Carbon\Carbon::parse($titulo->egreso)->format('d/m/Y') }}
				</div>
			</div>
			<hr>
			@empty

			@endforelse

        </div>
    </div>
</x-guest-layout>
