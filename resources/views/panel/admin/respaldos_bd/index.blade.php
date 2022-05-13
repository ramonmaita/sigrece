{{-- @role('Admin') --}}


@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>Respaldos de Base de Datos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('panel.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Respaldos de Base de Datos</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    @include('alertas')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Respaldos de Base de Datos</h3>
            <div class="card-tools float-sm-right">
				<a href="{{ route('panel.comandos.respaldar-db') }}" class="btn btn-primary" >
				   Generar Respaldo
				</a>
			 </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table" id="example">
                <thead>
                    <tr>
                        <th>Archivo</th>
                        <th>Tamaño</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($files as $archivo)
                        @if ($archivo != '.gitignore')
                            <tr>
                                <td>{{ $archivo }}</td>
                                <td>{{ round(\Storage::disk('database')->size($archivo) / 1048576, 2) }} MB</td>
                                <td>


									@if($archivo == 'schemas/schema.sql')
                                    <a href="{{ route('panel.respaldos.descargar', ['archivo' => 'schema.sql']) }}"
                                        class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i></a>
									@else
                                    <a href="{{ route('panel.respaldos.descargar', ['archivo' => $archivo]) }}"
                                        class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i></a>
                                    <a href="javascript:void(0)" data-link="{{ route('panel.respaldos.borrar', ['archivo' => $archivo]) }}"
                                        class="btn btn-danger borrar"><i class="fa fa-trash" aria-hidden="true"></i></a>
									@endif
                                </td>
                            </tr>
                        @endif
                    @empty
                    @endforelse
                </tbody>
            </table>
            {{-- @dump($files) --}}
        </div>
        <!-- /.card-body -->

    </div>
    <!-- /.card -->
@stop

@section('css')
    {{--  --}}
@stop

@section('js')
    <script>
        $('.borrar').click(function(e) {
            e.preventDefault();
            Swal
                .fire({
                    title: "ELIMINAR ARCHIVO",
                    text: "¿Esta seguro?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar",
                })
                .then(resultado => {
                    if (resultado.value) {
                        window.location.href = $(this).data('link')
                        console.log("*se elimina la venta*");
                    } else {
                        // Dijeron que no
                        console.log("*NO se elimina la venta*");
                    }
                });
        });
    </script>
@stop



{{-- @else --}}

{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout> --}}


{{-- @endrole --}}
