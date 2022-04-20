<div>
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
                                {{ $alumno->nacionalidad }}-{{ number_format($alumno->cedula, 0, ',', '.') }}</p>
                            {{-- <br> --}}
                            <center>
                                @if ($alumno->InscritoActual())
                                    <span class="text-center badge badge-pill badge-success">ACTIVO</span>
                                @else
                                    <span class="text-center badge badge-pill badge-danger">INACTIVO</span>
                                @endif
                            </center>
                            {{-- <ul class="mb-3 list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Followers</b> <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Following</b> <a class="float-right">543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Friends</b> <a class="float-right">13,287</a>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
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

                            <ul class="my-3 list-group list-group-unbordered">
                                @forelse ($titulos as $titulo)
                                    <li class="list-group-item">
                                        <b>
                                            @if ($titulo->titulo == 1 || $titulo->titulo == 3)
                                                TSU
                                            @else
                                                ING
                                            @endif
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

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="p-2 card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#documentos"
                                        data-toggle="tab">Documentos</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#datos" data-toggle="tab">Datos</a>
                                </li>
                                @if ($alumno->InscritoActual())
                                    <li class="nav-item"><a class="nav-link" href="#retiro" data-toggle="tab">Retiro</a>
                                    </li>
                                @endif
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
                                                            target="_blank" class="float-right"><i class="fa fa-print"
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
                                                    <a href="#" class="float-right"><i class="fa fa-print"
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-navy card-outline">
                                                <div class="card-header">
                                                    <h4 class="card-title">CONSTANCIA DE NOTAS</h4>
                                                    <a href="{{ route('panel.documentos.notas.pdf', [$alumno]) }}"
                                                        target="_blank" class="float-right"><i class="fa fa-print"
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
                                                    <a href="#" class="float-right"><i class="fa fa-print"
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
                                            @forelse($alumno->Historico->where('nro_periodo',$periodo->nro_periodo)->groupBy('cod_asignatura')
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
                                                                @if (@$uc->Asignatura->Plan->observacion == 'ANUAL')
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
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputName"
                                                    placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName2"
                                                    placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience"
                                                class="col-sm-2 col-form-label">Experience</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience"
                                                    placeholder="Experience"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputSkills"
                                                    placeholder="Skills">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> I agree to the <a href="#">terms and
                                                            conditions</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="retiro">
                                    @livewire('admin.retiros.create',['alumno' => $alumno])
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    @push('js')
	<!-- scriptps show-alumnos -->
        <script>
            $(function() {
                alert('kbkbhjb')
				window.addEventListener('recargar_iframes',()  => {
					// alert('Name updated to: ' + event.detail.newName);
					alert('adsasd')
				})
                window.livewire.on('as', () => {
                    console.log('recargar')
                    document.getElementById('comprobante').contentDocument.location.reload(true);
                    // document.getElementById('constacia').contentDocument.location.reload(true);
                    document.getElementById('notas').contentDocument.location.reload(true);
                    // document.getElementById('carnet').contentDocument.location.reload(true);
                    // $("#select2").select2("val", "0");
                });
            });

        </script>
    @endpush
</div>
