<x-guest-layout>
    {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
    {{-- <x-jet-validation-errors class="mb-4" /> --}}
    @php
        $inscrito = $estudiante->Inscrito->where('periodo_id', $periodo->id)->first();
        $fecha = \Carbon\Carbon::parse(@$inscrito->fecha)->format('d/m/Y');
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
                    {{ $estudiante->nacionalidad == 'V' ? $estudiante->nacionalidad . '-' . number_format($estudiante->cedula, 0, '', '.') : $estudiante->nacionalidad . '-' . $estudiante->cedula }}
                </div>
                <div class="md:text-center">
                    NOMBRES:
                    {{ $estudiante->nombres }}
                </div>
                <div class="md:text-right">
                    APELLIDOS:
                    {{ $estudiante->apellidos }}
                </div>
            </div>
            <hr class="my-3">
            <div class="grid md:grid-cols-2 sm:grid-cols-1">
                <div class="">
                    PROGRAMA NACIONAL DE FORMACION EN:
                    {{ $estudiante->Pnf->nombre }}
                </div>
                <div class="md:text-right">
                    FECHA DE INSCRIPCIÓN:
					@if ($estudiante->InscritoActual())
                    	{{ $fecha }}
					@else
						--/--/----
					@endif
                </div>
            </div>
        </div>

        @if ($estudiante->InscritoActual())
            <div class="w-8/12 px-6 py-4 mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg hover:shadow-lg">
                <h4 class="my-4 text-2xl font-semibold text-center uppercase text-gray">UNIDADES CURRICULARES INSCRITAS
                </h4>
                <hr>
				<div class="overflow-x-auto">

					<table class="w-full table-auto min-w-max">
						<thead>
							<tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
								<th class="px-6 py-3 text-left">Trayecto</th>
								<th class="px-6 py-3 text-left">{{ $estudiante->Plan->cohorte }}</th>
								<th class="px-6 py-3 text-center">Unidad Curricular</th>
								<th class="px-6 py-3 text-right w-96">Seccón</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($inscrito->Inscripcion as $uc)
								@if (@$uc->RelacionDocenteSeccion->DesAsignatura->Asignatura->plan_id == $estudiante->plan_id)
									<tr class="border-b border-gray-200 hover:bg-gray-100">
										<td class="px-6 py-3 text-left whitespace-nowrap" align="center">
											<div>
												{{ @$uc->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->nombre }}
											</div>
										</td>
										<td class="px-6 py-3 text-left whitespace-nowrap" align="center">
											<div>
												{{ @$uc->RelacionDocenteSeccion->DesAsignatura->tri_semestre }}
											</div>
										</td>


										<td class="px-6 py-3 text-left whitespace-nowrap">
											<div>
												{{ @$uc->RelacionDocenteSeccion->DesAsignatura->nombre }}
											</div>
										</td>

										<td class="px-6 py-3 text-right whitespace-nowrap" style=" font-size: 10pt;">
											<div style="text-transform: uppercase;">
												{{ @$uc->RelacionDocenteSeccion->Seccion->nombre }}
											</div>
										</td>


									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
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
