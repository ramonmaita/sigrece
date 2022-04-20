@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>Graduaciones</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('panel.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Graduaciones</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    @include('alertas')
	@livewire('admin.alertas')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Graduaciones</h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="{{ route('panel.graduacion.buscar') }}" method="POST" autocomplete="off">
						@csrf
						@method('POST')
                        <div class="form-group">
                            <label for="">Cédula</label>
                            <input type="text" class="form-control SoloNumeros @error('cedula') is-invalid @enderror" name="cedula" id="" aria-describedby="helpId"
                                placeholder="12345678">
							@error('cedula')
								<small id="helpId" class="form-text text-danger">{{ $message }}</small>
							@enderror
                            <small id="helpId" class="form-text text-muted">Escribir número de cédula sin puntos</small>
                        </div>
                        <div class="form-group">
                            <input name="" id="" class="btn btn-primary btn-block" type="submit" value="Buscar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

    </div>

	@livewire('admin.graduaciones.lote')
    <!-- /.card -->
@stop

@section('css')
    {{--  --}}
@stop

@section('js')
    <script>
        console.log('Hi!');

    </script>
@stop
