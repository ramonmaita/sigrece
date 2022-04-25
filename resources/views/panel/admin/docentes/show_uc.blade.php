@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1>
                    {{ $unidades->first()->Seccion->nombre }}
                </h1>
            </div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('panel.index') }}">
                            Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('panel.docentes.index') }}">
                            Docentes
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('panel.docentes.show', [$docente->id]) }}">
                            {{ $docente->nacionalidad }}-{{ $docente->cedula }} {{ $docente->nombres }}
                            {{ $docente->apellidos }} - Secciones
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $unidades->first()->Seccion->nombre }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
	@include('alertas')
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="pt-2 px-3">
                    <h3 class="card-title">{{ $unidades->first()->DesAsignatura->Asignatura->nombre }}</h3>

                    {{-- <span
                        class="m-r-2 float-right ">{{ $unidades->first()->DesAsignatura->Asignatura->Plan->cohorte }}:</span> --}}
                </li>
                @foreach ($unidades as $key => $unidad)
                    @if ($loop->first)
                        {{-- This is the first iteration --}}
                        <li class="nav-item">
                            <a class="nav-link active" id="control-{{ $key + 1 }}" data-toggle="pill"
                                href="#t-{{ $key + 1 }}" role="tab" aria-controls="t-{{ $key + 1 }}"
                                aria-selected="false">{{ $unidades->first()->DesAsignatura->Asignatura->Plan->cohorte }}:
                                {{ $unidad->DesAsignatura->tri_semestre }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" id="control-{{ $key + 1 }}" data-toggle="pill"
                                href="#t-{{ $key + 1 }}" role="tab" aria-controls="t-{{ $key + 1 }}"
                                aria-selected="false">{{ $unidades->first()->DesAsignatura->Asignatura->Plan->cohorte }}:
                                {{ $unidad->DesAsignatura->tri_semestre }}</a>
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                @foreach ($unidades as $key => $unidad)
                    <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}" id="t-{{ $key + 1 }}"
                        role="tabpanel" aria-labelledby="control-{{ $key + 1 }}">
                        @if ($unidad->DesAsignatura->estatus_carga($unidad->Seccion->nombre, $unidad->Seccion->Periodo->nombre))
                            <div class="ribbon-wrapper ribbon-lg">
                                <div class="ribbon bg-success text-lg">
                                    CERRADO
                                </div>
                            </div>
                        @else
                            <div class="ribbon-wrapper ribbon-lg">
                                <div class="ribbon bg-secondary text-lg">
                                    POR CERRAR
                                </div>
                            </div>
                        @endif

                        {{ $unidad->DesAsignatura->nombre }} <br>
                        {{ $unidad->DesAsignatura->Asignatura->Plan->cohorte }}
                        {{ $unidad->DesAsignatura->tri_semestre }}
                        <br>

                        <div class=" float-right">

                            <a target="_blank"
                                href="{{ route('panel.docente.secciones.gestion.avance', [@$unidad->id]) }}" type='button'
                                class=" btn btn-primary">
                                Generar Avance de Calificaciones
                            </a>

                            @if ($unidad->DesAsignatura->estatus_carga($unidad->Seccion->nombre, $unidad->Seccion->Periodo->nombre))
                                <a target="_blank"
                                    href="{{ route('panel.docente.secciones.gestion.acta', [@$unidad->id]) }}"
                                    type='button' class=" btn btn-info">
                                    Generar Acta de Calificaciones
                                </a>

                                <a
                                    href="{{ route('panel.secciones.abrir', [@$unidad->id]) }}"
                                    type='button' class=" btn btn-danger">
                                    Aperturar Carga
                                </a>
                            @endif
                        </div>
                        <br>
                        <hr>
                        <table class="table table-collapse table-sm	" id="">
                            <thead>
                                <tr>
                                    <th>
                                        Cédula
                                    </th>
                                    <th>
                                        Nombres
                                    </th>
                                    <th>
                                        Apellidos
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unidad->Inscritos as $alumnos)
                                    <tr>
                                        <td>
                                            {{ $alumnos->Alumno->cedula }}
                                        </td>
                                        <td>
                                            {{ $alumnos->Alumno->nombres }}
                                        </td>
                                        <td>
                                            {{ $alumnos->Alumno->apellidos }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

            </div>
        </div>

    </div>



@stop

@section('css')

@stop

@section('js')
    <script type="text/javascript">
        window.livewire.on('cerrar_modal', () => {
            $('#exampleModal').modal('hide');
        });
    </script>
@stop
