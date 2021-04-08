@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>
                    {{ $seccion->seccion }} - Asignar Docente
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('panel.index') }}">
                            Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('panel.secciones.lista') }}">
                            Secciones
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route('panel.secciones.ver-uc', ['periodo' => $seccion->periodo, 'seccion' => $seccion->seccion, 'pnf' => $seccion->especialidad]) }}">
                            {{ $seccion->seccion }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $seccion->seccion }} - Asignar Docente
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
@include('alertas')
    <div class="card card-outline card-primary">

        <div class="card-body">
            <h4 class="card-title" style="font-weight: 600">Asignar Docente</h4>
            <p class="card-text">A la UC: <b>{{ $seccion->DesAsignatura->nombre }}</b></p>

            <div class="row">

                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <form action="{{ route('panel.secciones.asignar_docente', ['seccion' => $seccion]) }}" method="POST">
                        @method('post')
                        @csrf


                        <div class="form-group">
                            <label for="">Docente</label>
                            <select class="form-control select2" name="docente_id" id="">

                                @forelse ($docentes as $docente)
                                    <option value="{{ $docente->id }}" @if ($docente->cedula  == $seccion->cedula_docente)
										selected
									@endif>
                                        {{ $docente->nacionalidad }}-{{ $docente->cedula }}
                                        {{ $docente->nombre_completo }}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-block btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
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

    $('.select2').select2({});

</script>
@stop
