<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-2 md:grid-cols-2">

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Secciones') }}
            </h2>

            <x-breadcrumb>
                <li class="flex items-center">
                    <a href="{{ route('panel.coordinador.index') }}">Inicio</a>
                    <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('panel.coordinador.secciones.index') }}">Secciones</a>
                    <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </li>
                <li>
                    <a class="text-gray-500" aria-current="page">{{ $seccion->nombre }}</a>
                </li>
            </x-breadcrumb>

        </div>
    </x-slot>

    <div class="py-12">
        @include('alertas')
        @livewire('docente.alertas')
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
                    <div class="p-6 overflow-x-auto">
                        <table class="w-full table-auto min-w-max">
                            <thead>
                                <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                                    <th class="px-6 py-3 text-center">N°</th>
                                    <th class="px-6 py-3 text-left">Unidad Curricular</th>
                                    <th class="px-6 py-3 text-right">{{ $seccion->Plan->cohorte }}</th>
                                    <th class="px-6 py-3 text-right">Docente</th>
                                    <th class="px-6 py-3 text-right">estatus</th>
                                    <th class="px-6 py-3 text-right">acciones</th>
                                    {{-- <th></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php $n = 1; @endphp
                                @foreach ($seccion->Plan->Asignaturas->where('trayecto_id', $seccion->trayecto->id) as $asignatura)
                                    <tr class="bg-blue-800 text-white">
                                        <th colspan="6" style="text-align: center;" for="{{ $asignatura->codigo }}">
                                            {{-- <label for="{{  $asignatura->codigo }}" style="width: 95%; cursor: pointer; height: 100%;;" class="check-asignatura"> --}}
                                            {{ $asignatura->nombre }}
                                            {{-- </label> --}}
                                        </th>
                                        @forelse($asignatura->DesAsignaturas as $desasignatura)
                                    <tr class="py-6" style="padding-top: 10px;">
                                        <td class="text-center">

                                            {{ $n }}
                                            {{-- <input type="hidden" name="{{ $desasignatura->id }}" value="{{ $n }}"> --}}
                                        </td>
                                        <td>
                                            {{ $desasignatura->nombre }}
                                            {{-- <input type="hidden" name="codigo" value="{{ $desasignatura->codigo }}"> --}}
                                        </td>
                                        <td class="text-right">
                                            {{ $desasignatura->tri_semestre }}
                                            {{-- <input type="hidden" name="codigo_anual" value="{{ $desasignatura->asignatura_id }}"> --}}
                                        </td>
                                        <td class="text-right">
                                            {{ $seccion->Docente($desasignatura->id)->Docente->nombre_completo }}

                                        </td>
                                        <td class="text-center" align="center">
											<center>

												{{-- ACTIVIADES CARGADAS --}}
												@if ($seccion->Docente($desasignatura->id)->Actividades->count() > 0)
													<i class="mr-4 cursor-pointer fa fa-check-circle" aria-hidden="true" style="color: green" title="ACTIVIDADES CARGADAS"></i>
												@else
												<i class="mr-4 cursor-pointer fas fa-dot-circle " title="ACTIVIDADES CARGADAS"></i>
												@endif

												{{-- NOTAS DE ACTIVIADES CARGADAS --}}
												@if ($seccion->Docente($desasignatura->id)->NotasActividades()->count() > 0)
													<i class="mr-4 cursor-pointer fa fa-check-circle" aria-hidden="true" style="color: green" title="NOTAS DE ACTIVIDADES CARGADAS"></i>
												@else
												<i class="mr-4 cursor-pointer fas fa-dot-circle " title="NOTAS DE ACTIVIDADES CARGADAS"></i>
												@endif
												{{-- CARGA CERRADA --}}

												@if ($desasignatura->estatus_carga($seccion->nombre, $seccion->Periodo->nombre))
													<i class="mr-4 cursor-pointer fa fa-check-circle" aria-hidden="true" style="color: green" title="CARGA CERRADA"></i>
												@else
												<i class="mr-4 cursor-pointer fas fa-dot-circle " title="CARGA CERRADA"></i>
												@endif
											</center>
                                        </td>
                                        <td class="text-right py-2">
                                            <x-link
                                                href="{{ route('panel.coordinador.secciones.lista_esudiantes', [$seccion->id,$desasignatura->id]) }}"
                                                color="blue" intensidad="600">
                                                <i class="fas fa-eye"></i>
                                            </x-link>
											{{-- AVANCE DE NOTAS --}}
											@if ($seccion->Docente($desasignatura->id)->NotasActividades()->count() > 0)
												<x-link target="_blank"
													href="{{ route('panel.docente.secciones.gestion.avance', [$seccion->Docente($desasignatura->id)->id]) }}"
													color="yellow" intensidad="600">
													<i class="fas fa-file-pdf"></i>
												</x-link>
                                            @else
												<x-link
													href="javascript:void(0)"
													color="yellow" intensidad="400">
													<i class="fas fa-file-pdf"></i>
												</x-link>
                                            @endif

											{{-- ACTA DE CALIFICACIONES --}}
											@if ($desasignatura->estatus_carga($seccion->nombre, $seccion->Periodo->nombre))
												<x-link target="_blank"
													href="{{ route('panel.coordinador.secciones.acta', [$seccion->Docente($desasignatura->id)->id]) }}"
													color="red" intensidad="600">
													<i class="fas fa-file-pdf"></i>
												</x-link>
                                            @else
												<x-link
													href="javascript:void(0)"
													color="red" intensidad="400">
													<i class="fas fa-file-pdf"></i>
												</x-link>
                                            @endif

                                        </td>
                                    </tr>
                                    @php $n++; @endphp

                                @empty
                                @endforelse
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
