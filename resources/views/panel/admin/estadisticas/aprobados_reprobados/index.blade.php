@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>
                    Aprobados y Reprobados
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('panel.index') }}">
                            Inicio
                        </a>
                    </li>
                    {{-- <li class="breadcrumb-item">
                        <a href="{{ route('panel.secciones.lista') }}">
                            Secciones
                        </a>
                    </li> --}}
                    <li class="breadcrumb-item active">
                        Estadisticas
                    </li>
                    <li class="breadcrumb-item active">
                        Aprobados y Reprobados
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    @include('alertas')
	@livewire('admin.alertas')

	@livewire('admin.estadisticas.aprobados-reprobados.index')



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
