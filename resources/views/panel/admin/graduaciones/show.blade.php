@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>{{ $graduando->cedula }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('panel.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('panel.graduacion.index') }}">Graduaciones</a></li>
                    <li class="breadcrumb-item active">Ver Graduado</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    @include('alertas')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Título</h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
						{{-- {{ $graduando->id }} --}}
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">

					<embed src="{{route('panel.graduacion.documentos.titulo',[$graduando->id])}}" type="" width="100%" height="500px">
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>

        </div>

		<div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Acta</h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
						{{-- {{ $graduando->id }} --}}
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">

					<embed src="{{route('panel.graduacion.documentos.acta',[$graduando->id])}}" type="" width="100%" height="500px">
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>

        </div>

		<div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Notas</h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
						{{-- {{ $graduando->id }} --}}
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">

					<embed src="{{route('panel.graduacion.documentos.notas',[$graduando->id])}}" type="" width="100%" height="500px">
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>

        </div>
    </div>
@stop

@section('css')
    {{--  --}}
@stop

@section('js')
    <script>
        console.log('Hi!');

    </script>
@stop
