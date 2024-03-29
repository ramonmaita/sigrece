@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>
                    Estudiantes
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
                        <a href="{{ route('panel.estudiantes.index') }}">
                            Estudiantes
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $alumno->nombres }} {{ $alumno->apellidos }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach ($trayectos as $key => $trayecto)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box bg-{{ $trayecto['porcentaje'] == 100 ? 'green' : 'red' }} ">
                            <span class="info-box-icon"><i class="fa fa-book"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ $trayecto['nombre'] }}</span>
                                <span class="info-box-number">Unidades Curriculares:
                                    {{ $trayecto['uc_totales'] }}</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $trayecto['porcentaje'] }}%"></div>
                                </div>
                                <span class="progress-description">
                                    {{ $trayecto['porcentaje'] }}%
                                    <b>Aprobadas: {{ $trayecto['uc_aprobadas'] }} - Pendientes:
                                        {{ $trayecto['uc_pendientes'] }} </b>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                @endforeach
            </div>
			@livewire('admin.alertas')
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($alumno->p_nombre . ' ' . $alumno->p_apellido) . '&color=7F9CF5&background=EBF4FF' }}"
                                    alt="{{ $alumno->nombres }}">
                            </div>

                            <h3 class="text-center profile-username">{{ $alumno->nombres }}
                                <br>{{ $alumno->apellidos }}
                            </h3>

                            <p class="text-center text-muted">
                                {{ $alumno->nacionalidad }}-{{ number_format($alumno->cedula, 0, ',', '.') }}<button onclick="copiar()" class="btn btn-default btn-sm"><i class="fas fa-copy    "></i></button></p>
								<input type="text" value="{{ $alumno->cedula }}" id="copy" style="display: none;">

                            {{-- <br> --}}
                            <center id="estatus">
                                @if ($alumno->InscritoActual())
                                    <span class="text-center badge badge-pill badge-success">ACTIVO</span>
                                @else
                                    <span class="text-center badge badge-pill badge-danger">INACTIVO</span>
                                @endif
                            </center>
							@if ($alumno->ActualizacionDatos)
								<br>
								<a href="{{ route('panel.documentos.expediente.pdf', [$alumno]) }}" target="documento" class="show-documento btn btn-primary btn-sm btn-block"><b>Expediente</b></a>
							@endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Datos</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="font-size: 11pt;">
                            <div class="row">
                                <div class="col-md-12">
                                    <strong><i class="mr-1 fas fa-book"></i> PNF</strong>

                                    <p class="text-muted">
                                        {{ $alumno->Pnf->nombre }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="mr-1 fas fa-book"></i> PLAN</strong>

                                    <p class="text-muted">
                                        {{ $alumno->Plan->codigo }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="mr-1 fas fa-book"></i> APRUEBA</strong>

                                    <p class="text-muted">
                                        {{ $alumno->tipo }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <strong><i class="mr-1 fas fa-venus-mars"></i> Sexo</strong>

                            <p class="text-muted">
                                @if ($alumno->sexo == 'M' || $alumno->sexo == 'MASCULINO')
                                    MASCULINO
                                @elseif($alumno->sexo == 'F' || $alumno->sexo == 'FEMENINO')
                                    FEMENINO
                                @else
                                    {{ $alumno->sexo }}
                                @endif
                            </p>
                            <hr>

                            <strong><i class="mr-1 fas fa-map-marker-alt"></i> Lugar de Nacimiento</strong>

                            <p class="text-muted"> {{ $alumno->lugarn }}</p>

                            <hr>

                            <strong><i class="mr-1 fas fa-map-marker-alt"></i> Fecha de Nacimiento</strong>

                            <p class="text-muted"> {{ \Carbon\Carbon::parse($alumno->fechan)->format('d/m/Y') }}</p>

                            <hr>

                            <strong><i class="mr-1 fas fa-graduation-cap"></i> Título</strong>

							@php
								$titulos_pnf = [];
							@endphp
                            <ul class="my-3 list-group list-group-unbordered">
                                @forelse ($titulos as $titulo)
                                    <li class="list-group-item">
                                        <b>
                                            @if ($titulo->titulo == 1 || $titulo->titulo == 3)
                                                TSU
                                            @else
                                                ING
                                            @endif
											@php
												$t = ($titulo->titulo == 1 || $titulo->titulo == 3) ? 'TSU' : 'ING';
												$titulos_pnf[] = $t."-".$titulo->codigo;
											@endphp
                                            {{ $titulo->acronimo }}
                                        </b>
                                        <a
                                            class="float-right">{{ \Carbon\Carbon::parse($titulo->egreso)->format('d/m/Y') }}</a>
                                    </li>
                                @empty
                                    <li class="list-group-item">
                                        <b>Sin Título</b>
                                    </li>
                                @endforelse
                                {{-- <li class="list-group-item">
								<b>Friends</b> <a class="float-right">13,287</a>
							</li> --}}
                            </ul>
							{{-- @dump($titulos_pnf) --}}

							@php
								// implode($titulos_pnf['TSU']);
								$pnf_activo = $alumno->Pnf->codigo;
								$a = array_search('TSU-'.$pnf_activo,$titulos_pnf,true);
							@endphp
							@if(count($trayectos) > 2)
                        @if ($alumno->Pnf->codigo == 40 && $alumno->plan_id == 5 || $alumno->Pnf->codigo == 60 && $alumno->plan_id == 21)

                            @if ((array_search('TSU-'.$pnf_activo,$titulos_pnf,true) === false) &&
                                    $trayectos[8]['porcentaje'] == 100 &&
                                    $trayectos[1]['porcentaje'] == 100 &&
                                    $trayectos[2]['porcentaje'] == 100 &&
                                    $trayectos[3]['porcentaje'] == 100

                                    || (empty($titulos)) &&
                                    $trayectos[8]['porcentaje'] == 100 &&
                                    $trayectos[1]['porcentaje'] == 100 &&
                                    $trayectos[2]['porcentaje'] == 100 &&
                                    $trayectos[3]['porcentaje'] == 100
                                )
								@can('aspirantes-grado.postular')
									<a href="#" target="documento" class="show-documento btn btn-primary btn-sm btn-block"><b>Agregar Aspirante a Grado TSU</b></a>
								@endcan
								@can('documentos.culminacion.pdf')
                                	<a href="{{ route('panel.documentos.culminacion.pdf',['alumno' => $alumno, 'titulo' => 'TSU']) }}" target="documento" class="show-documento btn btn-info btn-sm btn-block"><b>Constancia de Culminiación TSU</b></a>
								@endcan
                            @endif

                            @if (( (array_search('ING-'.$pnf_activo,$titulos_pnf,true) === false) && (array_search('TSU-'.$pnf_activo,$titulos_pnf,true) >= 0) &&
                                    $trayectos[8]['porcentaje'] == 100 &&
                                    $trayectos[1]['porcentaje'] == 100 &&
                                    $trayectos[2]['porcentaje'] == 100 &&
                                    $trayectos[3]['porcentaje'] == 100 &&
                                    $trayectos[4]['porcentaje'] == 100 &&
                                    $trayectos[5]['porcentaje'] == 100
                                ))
								@can('aspirantes-grado.postular')
                                	<a href="#" target="documento" class="show-documento btn btn-primary btn-sm btn-block"><b>Agregar Aspirante a Grado Ing</b></a>
                                @endcan
								@can('documentos.culminacion.pdf')
									<a href="{{ route('panel.documentos.culminacion.pdf',['alumno' => $alumno, 'titulo' => 'ING']) }}" target="documento" class="show-documento btn btn-info btn-sm btn-block"><b>Constancia de Culminiación Ing</b></a>
								@endcan
							@endif
                        @else
                            @if ((array_search('TSU-'.$pnf_activo,$titulos_pnf,true) === false) &&
                                    $trayectos[8]['porcentaje'] == 100 &&
                                    $trayectos[1]['porcentaje'] == 100 &&
                                    $trayectos[2]['porcentaje'] == 100

                                    || (empty($titulos)) && $trayectos[8]['porcentaje'] == 100 &&
                                    $trayectos[1]['porcentaje'] == 100 &&
                                    $trayectos[2]['porcentaje'] == 100
                                )
                                @can('aspirantes-grado.postular')
									<a href="#" target="documento" class="show-documento btn btn-primary btn-sm btn-block"><b>Agregar Aspirante a Grado TSU</b></a>
								@endcan
								@can('documentos.culminacion.pdf')
									<a href="{{ route('panel.documentos.culminacion.pdf',['alumno' => $alumno, 'titulo' => 'TSU']) }}" target="documento" class="show-documento btn btn-info btn-sm btn-block"><b>Constancia de Culminiación TSU</b></a>
								@endcan
                            @endif

                            @if (( (array_search('ING-'.$pnf_activo,$titulos_pnf,true) === false) && (array_search('TSU-'.$pnf_activo,$titulos_pnf,true) >= 0) &&
                                    $trayectos[8]['porcentaje'] == 100 &&
                                    $trayectos[1]['porcentaje'] == 100 &&
                                    $trayectos[2]['porcentaje'] == 100 &&
                                    $trayectos[3]['porcentaje'] == 100 &&
                                    $trayectos[4]['porcentaje'] == 100
                                ))
                                @can('aspirantes-grado.postular')
									<a href="#" target="documento" class="show-documento btn btn-primary btn-sm btn-block"><b>Agregar Aspirante a Grado Ing</b></a>
								@endcan
								@can('documentos.culminacion.pdf')
									<a href="{{ route('panel.documentos.culminacion.pdf',['alumno' => $alumno, 'titulo' => 'ING']) }}" target="documento" class="show-documento btn btn-info btn-sm btn-block"><b>Constancia de Culminiación Ing</b></a>
								@endcan
                            @endif

                        @endif
                    @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="p-2 card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#documentos" data-toggle="tab"
                                        id="link_documentos">Documentos</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Linea de Tiempo</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#datos" data-toggle="tab">Datos</a>
                                </li>
								@can('retiros.create')
                                @if ($alumno->InscritoActual())
                                    <li class="nav-item"><a class="nav-link ocultar" href="#retiro" data-toggle="tab">Retiro de UC</a>
                                    </li>
                                @endif
								@endcan
								@can('periodo.corregir')
									<li class="nav-item"><a class="nav-link" href="{{ route('panel.estudiantes.periodo.corregir', ['alumno'=>$alumno]) }}">Corregir Periodo</a>
									</li>
								@endcan

                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="documentos">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-primary card-outline">
                                                @php
                                                    // $inscrito = (@$alumno->InscritoActual()->count() > 0) ? true : false;
                                                    $inscrito = $alumno->InscritoActual() ? true : false;
                                                    // TODO: CAMBIAR LA VALARAIABLE INSCRITO == FALSE
                                                @endphp
                                                <div class="card-header">
                                                    <h4 class="card-title">COMPROBANTE DE INSCRIPCIÓN</h4>
                                                    @if ($inscrito == true)
                                                        <a href="{{ route('panel.documentos.comprobante.pdf', [$alumno]) }}"
                                                             class="float-right ocultar show-documento" target="documento" ><i class="fa fa-print"
                                                                aria-hidden="true"></i></a>
                                                    @endif
                                                </div>
                                                <div class="card-body">
                                                    @if ($inscrito == false)
                                                        <div class="callout callout-danger">
                                                            <h5>
                                                                El estudiante no se encuentra activo en el periodo
                                                                academico actual.
                                                            </h5>
                                                        </div>
                                                    @else
                                                        <iframe id="comprobante"
                                                            src="{{ route('panel.documentos.comprobante.pdf', [$alumno]) }}"
                                                            frameborder="0" width="100%" height="500px"></iframe>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-info card-outline">
                                                <div class="card-header">
                                                    <h4 class="card-title">CONSTANCIA DE ESTUDIOS</h4>
													@if ($inscrito == true)
														<a href="{{ route('panel.documentos.constancia.pdf', [$alumno]) }}"
															class="float-right ocultar show-documento" target="documento" ><i class="fa fa-print"
																aria-hidden="true"></i></a>
													@endif
                                                </div>
                                                <div class="card-body">
                                                    @if ($inscrito == false)
                                                        <div class="callout callout-danger">
                                                            <h5>
                                                                El estudiante no se encuentra activo en el periodo
                                                                academico actual.
                                                            </h5>
                                                        </div>
                                                    @else
														<iframe id="comprobante"
														src="{{ route('panel.documentos.constancia.pdf', [$alumno]) }}"
														frameborder="0" width="100%" height="500px"></iframe>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-navy card-outline">
                                                <div class="card-header">
                                                    <h4 class="card-title">CONSTANCIA DE NOTAS</h4>
                                                    <a href="{{ route('panel.documentos.notas.pdf', [$alumno]) }}"
                                                        class="float-right show-documento" target="documento" ><i class="fa fa-print"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                                <div class="card-body">
                                                    {{-- @if ($inscrito == false)
														<div class="callout callout-danger">
															<h5>
																El estudiante no se encuentra activo en el periodo academico actual.
															</h5>
														</div>
													@else --}}
                                                    <iframe id="notas"
                                                        src="{{ route('panel.documentos.notas.pdf', [$alumno]) }}"
                                                        frameborder="0" width="100%" height="500px"></iframe>
                                                    {{-- @endif --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-lightblue card-outline">
                                                <div class="card-header">
                                                    <h4 class="card-title">CARNET</h4>
                                                    <a href="#" class="float-right ocultar"><i class="fa fa-print"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                                <div class="card-body">
                                                    @if ($inscrito == true)
                                                        <div class="callout callout-danger">
                                                            <h5>
                                                                El estudiante no se encuentra activo en el periodo
                                                                academico actual.
                                                            </h5>
                                                        </div>
                                                    @else
                                                        {{-- <iframe src="#" frameborder="0" width="100%" height="500px"></iframe> --}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">

                                        @foreach ($alumno->Periodos as $periodo)
                                            <div class="time-label">
                                                <span class="bg-info">
                                                    {{ $periodo->periodo }}
                                                </span>
                                            </div>
                                            @forelse($alumno->TimeLine->where('nro_periodo',$periodo->nro_periodo)->groupBy('cod_asignatura')
                                                as $asig)
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-book bg-primary"></i>

                                                    <div class="timeline-item">
                                                        <span class="time"><i
                                                                class="far fa-bookmark-o"></i>{{ @$asig->first()->Asignatura->Trayecto->observacion }}</span>

                                                        <h3 class="timeline-header"><a
                                                                href="#">{{ @$asig->first()->Asignatura->nombre }}</a>
                                                        </h3>

                                                        <div class="timeline-body">
                                                            @foreach ($asig as $uc)
                                                                @if ($uc->Asignatura->Plan->observacion == 'ANUAL')
                                                                    AÑO:
                                                                @elseif($uc->Asignatura->Plan->observacion ==
                                                                    'SEMESTRAL')
                                                                    SEMESTRE:
                                                                @elseif($uc->Asignatura->Plan->observacion ==
                                                                    'TRIMESTRAL')
                                                                    TRIMESTRE:
                                                                @endif
                                                                <b>{{ $uc->DesAsignatura->tri_semestre }}</b>
                                                                <br>
                                                                <b>{{ $uc->DesAsignatura->nombre }}</b> Sección:
                                                                {{ $uc->seccion }} Nota: <b>{{ $uc->nota }}</b>
                                                                <br>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                        @endforelse
                                        @endforeach


                                        <!-- END timeline item -->
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="datos">
                                    @livewire('admin.alumnos.datos',['alumno' => $alumno])
                                </div>
                                <div class="tab-pane" id="retiro">
                                    @livewire('admin.retiros.create',['alumno' => $alumno])
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- @livewire('admin.alumnos.show-alumno',['alumno' => $alumno,'trayectos' => $trayectos]) --}}

	<div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">VER DOCUMENTO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
				<div id="loadingMessage">
					Loading...
				</div>
				<iframe frameborder="0" id="documento" name="documento" width="100%" height="500px"></iframe>
            </div>
            <div class="modal-footer ">
              <button type="button" class="float-right btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

@stop

@push('css')
<style>
	#loadingMessage {
		width: 100%;
		height: 100%;
		z-index: 1000;
		background: #fff;
		top: 0px;
		left: 0px;
		position: absolute;
	}
</style>
@endpush

@push('js')
    <script type="text/javascript">
			function copiar() {
			/* Get the text field */
			var copyText = document.getElementById("copy");

			/* Select the text field */
			copyText.select();
			copyText.setSelectionRange(0, 99999); /* For mobile devices */

			/* Copy the text inside the text field */
			navigator.clipboard.writeText(copyText.value);

			/* Alert the copied text */
			alert("Cédula: " + copyText.value+" copiada.");
			}
        $(function() {
			// $('#loadingMessage').css('display', 'none');
			$('.show-documento').click(function (e) {
				// e.preventDefault();
				var uri = $(this).attr('href');
				console.log(uri);
				if(uri){
					$('#documento').attr('height', '500px');
					$('#modal-xl').modal('show')
					$('.preloader').show();
				}

			});
			$("#documento").on("load",function () {
				$('#loadingMessage').css('display', 'none');
				$('.preloader').hide();

			})
            window.livewire.on('recargar_iframes', estaInscrito => {
                // alert('recargar')
                setTimeout(() => {
                    $("#link_documentos").click()
                }, 500);
                if (estaInscrito == false) {
					$('.ocultar').hide()
                    $("#comprobante").parent().html(
                        '<div class="callout callout-danger"><h5>El estudiante no se encuentra activo en el periodo academico actual. </h5></div>'
                        );
                    $("#constacia").parent().html(
                        '<div class="callout callout-danger"><h5>El estudiante no se encuentra activo en el periodo academico actual. </h5></div>'
                        );
                    $("#carnet").parent().html(
                        '<div class="callout callout-danger"><h5>El estudiante no se encuentra activo en el periodo academico actual. </h5></div>'
                        );
					$("#estatus").html('<span class="text-center badge badge-pill badge-danger">INACTIVO</span>');
                } else {
                    document.getElementById('comprobante').contentDocument.location.reload(true);
                    // document.getElementById('constacia').contentDocument.location.reload(true);
                    document.getElementById('notas').contentDocument.location.reload(true);
                    // document.getElementById('carnet').contentDocument.location.reload(true);
                }
            });
            window.livewire.on('cerrar_modal', () => {
                $('#exampleModal').modal('hide');
            });

        });

    </script>
@endpush
