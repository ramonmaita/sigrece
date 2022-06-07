<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-2 md:grid-cols-2">

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Secciones Asignadas') }}
            </h2>

            <x-breadcrumb>
                <li class="flex items-center">
                    <a href="{{ route('panel.docente.index') }}">Inicio</a>
                    <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('panel.docente.secciones.index') }}">Secciones Asignadas</a>
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
        <style>
            /* .body{background-color:white !important;} */

            .tab {
                opacity: 0;
                visibility: hidden;
                transform: translate(0, 50px);
            }

            .active-tab,
            .active-button {
                transition: transform 0.2s, background 0.2s, color 0.2s;
            }

            .active-tab {
                visibility: visible;
                opacity: 1;
                transform: translate(0, 0);
                z-index: 99;
            }

            .active-button {
                background: white !important;
                color: #3730a3;
            }

        </style>
        @include('alertas')
        @php
            $actual = \Carbon\Carbon::now()->toDateTimeString();
            // $actual = date('Y-m-d H:i:s', strtotime(\Carbon\Carbon::now()));
            // return dd($actual);
            $cerrado = true;
            $evento_solicitud_correccion = \App\Models\Evento::where('tipo', 'CARGA DE CALIFICACIONES')
                ->where('evento_padre', 0)
                ->where('inicio', '<=', $actual)
                ->where('fin', '>=', $actual)
                ->orderBy('id', 'desc')
                ->first();
            // return dd($evento_solicitud_correccion);
            if ($evento_solicitud_correccion) {
                $aplicable = json_decode($evento_solicitud_correccion->aplicable);
                if ($evento_solicitud_correccion->aplicar == 'TODOS') {
                    $cerrado = false;
                } elseif ($evento_solicitud_correccion->aplicar == 'ESPECIFICO' && array_search(Auth::user()->cedula, $aplicable[1]) !== false) {
                    $cerrado = false;
                }
            }

        @endphp
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @livewire('docente.alertas')

            <div class="m-10 mx-auto text-blue-800 tabs">
                <div class="flex overflow-hidden text-gray-100 top rounded-t-md">
                    <div class="w-full p-2 px-3 font-semibold uppercase bg-blue-800 header">
                        {{ $unidades->first()->DesAsignatura->Asignatura->nombre }}
                        <span
                            class="float-right ">{{ $unidades->first()->DesAsignatura->Asignatura->Plan->cohorte }}:</span>
                    </div>
                    <div class="flex my-auto ml-auto buttons">

                        @foreach ($unidades as $key => $unidad)
                            @if ($loop->first)
                                {{-- This is the first iteration --}}
                                <span tab="{{ $key + 1 }}"
                                    class="p-2 px-6 bg-blue-800 cursor-pointer btn active-button">{{ $unidad->DesAsignatura->tri_semestre }}</span>
                            @else
                                <span tab="{{ $key + 1 }}"
                                    class="p-2 px-6 bg-blue-800 cursor-pointer btn">{{ $unidad->DesAsignatura->tri_semestre }}</span>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="relative text-gray-800 center">
                    <!-- tab start -->
                    @foreach ($unidades as $key => $unidad)
                        <div
                            class="absolute top-0 w-full bg-white border border-t-0 tab rounded-b-md @if ($loop->first) active-tab @endif">
                            <p class="p-3 px-5 text-xl font-semibold">{{ $unidad->DesAsignatura->nombre }}
                                {{ $unidad->DesAsignatura->Asignatura->Plan->cohorte }}:
                                {{ $unidad->DesAsignatura->tri_semestre }}</p>
                            <div class=" p-3 grid grid-cols-4 gap-2">

								@if($cerrado == false)
                                <x-jet-button class="justify-center float-right w-full create-actividad"
                                    data-id="{{ $key }}">
                                    Agregar Actividad
                                </x-jet-button>

                                <x-jet-button class="justify-center float-right w-full edit-actividad"
                                    data-id="{{ $key }}">
                                    Editar Actividad
                                </x-jet-button>
								@endif
                                @if ($unidad->Actividades->count() > 0)
                                    <a target="_blank"
                                        href="{{ route('panel.docente.secciones.gestion.avance', [$unidad->id]) }}"
                                        type='button'
                                        class=" justify-center float-right w-full text-center items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400  active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:shadow-outline-$color disabled:opacity-25 transition ease-in-out duration-150">
                                        Generar Avance de Calificaciones
                                    </a>

                                    @if (@$unidad->Actividades->first()->Notas->where('estatus', 'CERRADO')->count() > 0)
                                        {{-- {{ (@$unidad->Nota($inscritos->Alumno->id)->nota) ? @$unidad->Nota($inscritos->Alumno->id)->nota : 0}} --}}
                                        <a target="_blank"
                                            href="{{ route('panel.docente.secciones.gestion.acta', [$unidad->id]) }}"
                                            type='button'
                                            class=" justify-center float-right w-full text-center items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400  active:bg-gray-600 focus:outline-none focus:border-gray-600 focus:shadow-outline-$color disabled:opacity-25 transition ease-in-out duration-150">
                                            Generar Acta de Calificaciones
                                        </a>
                                    @else
                                        {{-- abierto --}}
                                    @endif
                                @endif
                                {{-- <x-link  color="gray" target="_blank" intensidad="500" href="{{ route('panel.docente.secciones.gestion.avance',[$unidad->id]) }}" class="justify-center float-right w-full edit-actividad"  data-id="{{ $key }}">
									Generar Avance de Calificaciones
								</x-link> --}}
                            </div>
                            <div id="create-{{ $key }}" class="actividades" style="display: none;">
                                @livewire('docente.secciones.gestionar.actividades.create', ['relacion_id' => $unidad->id, 'desasignatura_id' => $unidad->DesAsignatura->id, 'seccion_id' => $unidad->Seccion->id])
                            </div>
                            <div id="edit-{{ $key }}" class="actividades" style="display: none;">
                                @livewire('docente.secciones.gestionar.actividades.edit', ['relacion_id' => $unidad->id, 'desasignatura_id' => $unidad->DesAsignatura->id, 'seccion_id' => $unidad->Seccion->id])
                            </div>

                            <div class="p-3 px-5">
                                {{-- <livewire:docente.secciones.gestionar.lista-estudiante params="1" searchable="name, id" model="App\Models\User"/> --}}
                                {{-- @livewire('docente.secciones.gestionar.lista-estudiante',['params'=>  [ 'desasignatura_id' => $unidad->DesAsignatura->id , 'seccion_id' => $unidad->Seccion->id] ]) --}}
                                @livewire('docente.secciones.gestionar.listado-estudiante', ['desasignatura_id' => $unidad->DesAsignatura->id, 'seccion_id' => $unidad->Seccion->id])

                            </div>

                        </div>
                    @endforeach



                </div>
            </div>

        </div>




        <script>
            const root = document.querySelector(".tabs"),
                tabs = root.querySelectorAll(".tab"),
                btns = root.querySelectorAll(".btn");
            root.onclick = function(e) {
                var t = e.target,
                    val = t.getAttribute("tab");
                if (val != null) {
                    tabs.forEach(each => {
                        each.classList.remove("active-tab");
                    });
                    btns.forEach(each => {
                        each.classList.remove("active-button");
                    });
                    tabs[val - 1].classList.add("active-tab");
                    btns[val - 1].classList.add("active-button");
                }
            }
        </script>
    </div>


    @section('scripts')
        <script>
            // $('.actividades').hide();

            $(function() {
                $('.create-actividad').click(function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $('#edit-' + id).hide(function() {
                        $('#create-' + id).show();
                    });
                    // alert('asa')
                });
                $('.edit-actividad').click(function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $('#create-' + id).hide(function() {
                        $('#edit-' + id).show();
                    });
                    // alert('asa')
                });
            });

            Livewire.on('recargar_pagina', () => {
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            })
        </script>
    @endsection
</x-app-layout>
