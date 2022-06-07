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
                    <li class="breadcrumb-item"><a href="{{ route('panel.documentos.certificados.index') }}">Documentos Certificados</a></li>
                    <li class="breadcrumb-item active">Ver Documentos</li>
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
	@livewire('admin.documentos.certificados.documentos', ['graduando' => $graduando])


@stop

@section('css')
    {{--  --}}
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
