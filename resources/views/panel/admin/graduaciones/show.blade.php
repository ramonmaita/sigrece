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

		@if ($graduando->Alumno)
			<div class="col-md-4">
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle"
								src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($graduando->Alumno->p_nombre . ' ' . $graduando->Alumno->p_apellido) . '&color=7F9CF5&background=EBF4FF' }}"
								alt="{{ $graduando->Alumno->nombres }}">
						</div>

						<h3 class="text-center profile-username">{{ $graduando->Alumno->nombres }}
							<br>{{ $graduando->Alumno->apellidos }}
						</h3>

						<p class="text-center text-muted">
							{{ $graduando->Alumno->nacionalidad }}-{{ number_format($graduando->Alumno->cedula, 0, ',', '.') }}
						</p>

						<center id="estatus">
							@if ($graduando->Alumno->InscritoActual())
								<span class="text-center badge badge-pill badge-success">ACTIVO</span>
							@else
								<span class="text-center badge badge-pill badge-danger">INACTIVO</span>
							@endif
						</center>
						<hr>
						<strong><i class="mr-1 fas fa-venus-mars"></i> Sexo</strong>

						<p class="text-muted">
							@if ($graduando->Alumno->sexo == 'M' || $graduando->Alumno->sexo == 'MASCULINO')
								MASCULINO
							@elseif($graduando->Alumno->sexo == 'F' || $graduando->Alumno->sexo == 'FEMENINO')
								FEMENINO
							@else
								{{ $graduando->Alumno->sexo }}
							@endif
						</p>
						<hr>

						<strong><i class="mr-1 fas fa-map-marker-alt"></i> Lugar de Nacimiento</strong>

						<p class="text-muted"> {{ $graduando->Alumno->lugarn }}</p>

						<hr>

						<strong><i class="mr-1 fas fa-map-marker-alt"></i> Fecha de Nacimiento</strong>

						<p class="text-muted"> {{ \Carbon\Carbon::parse($graduando->Alumno->fechan)->format('d/m/Y') }}
						</p>

						<hr>
						{{-- <br> --}}
					</div>
					<!-- /.card-body -->
				</div>
			</div>
		@else
		<div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($graduando->nombres . ' ' . $graduando->apellidos) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="{{ $graduando->nombres }}">
                    </div>

                    <h3 class="text-center profile-username">{{ $graduando->nombres }}
                        <br>{{ $graduando->apellidos }}
                    </h3>

                    <p class="text-center text-muted">
                        {{ $graduando->nacionalidad }}-{{ number_format($graduando->cedula, 0, ',', '.') }}
                    </p>
                    <hr>
                    <strong><i class="mr-1 fas fa-venus-mars"></i> Sexo</strong>

                    <p class="text-muted">
                        @if ($graduando->sexo == 'M' || $graduando->sexo == 'MASCULINO')
                            MASCULINO
                        @elseif($graduando->sexo == 'F' || $graduando->sexo == 'FEMENINO')
                            FEMENINO
                        @else
                            {{ $graduando->sexo }}
                        @endif
                    </p>
                    <hr>

                    <strong><i class="mr-1 fas fa-map-marker-alt"></i> Lugar de Nacimiento</strong>

                    <p class="text-muted"> {{ $graduando->l_nacimiento }}</p>

                    <hr>

                    <strong><i class="mr-1 fas fa-map-marker-alt"></i> Fecha de Nacimiento</strong>

                    <p class="text-muted"> {{ \Carbon\Carbon::parse($graduando->f_nacimiento)->format('d/m/Y') }}
                    </p>

                    <hr>
                    {{-- <br> --}}
                </div>
                <!-- /.card-body -->
            </div>
        </div>
		@endif
        <div class="col-md-8">
			@livewire('admin.graduaciones.show', ['graduando' => $graduando])

        </div>
    </div>
    @if (Auth::user()->hasRole('Admin'))
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

                        <embed src="{{ route('panel.graduacion.documentos.titulo', [$graduando->id]) }}" type=""
                            width="100%" height="500px">
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

                        <embed src="{{ route('panel.graduacion.documentos.acta', [$graduando->id]) }}" type=""
                            width="100%" height="500px">
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

                        <embed src="{{ route('panel.graduacion.documentos.notas', [$graduando->id]) }}" type=""
                            width="100%" height="500px">
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>

            </div>
        </div>
    @endif

@stop

@section('css')
    {{--  --}}
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
