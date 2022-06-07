<div>
    <div class="row">
		<div class="col-md-12">
			<div wire:loading.delay="" style="width: 100%">
				<div class="callout callout-info">
				   <h5>
					  Procesando informarción por favor espere...
				   </h5>
				</div>
			 </div>
		</div>
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">FILTROS</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Periodo</label>
                                <select name="" id="" class="form-control" wire:model.defer='periodo_id'>
                                    <option value="">Seleccione</option>
                                    @forelse ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                                    @empty
                                        <option disabled selected>NO HAY REGISTROS DISPONIBLES</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">PNF</label>
                                <select name="" id="" class="form-control" wire:model='pnf_id'>
                                    <option value="">Seleccione</option>
                                    @forelse ($pnfs as $pnf_select)
                                        <option value="{{ $pnf_select->id }}">{{ $pnf_select->nombre }}</option>
                                    @empty
                                        <option disabled selected>NO HAY REGISTROS DISPONIBLES</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Plan</label>
                                <select name="" id="" class="form-control" wire:model='plan_id'>
                                    <option value="">Seleccione</option>
                                    @forelse ($planes as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->nombre }}</option>
                                    @empty
                                        <option disabled selected>NO HAY REGISTROS DISPONIBLES</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tipo</label>
                                <select name="" id="" class="form-control" wire:model='tipo'>
                                    <option value="">Seleccione</option>
                                    <option value="TRAYECTO">TRAYECTO</option>
                                    {{-- <option value="COHORTE" disabled>COHORTE</option>
                                    <option value="SECCION" disabled>SECCION</option>
                                    <option value="UC" disabled>UC</option> --}}
                                </select>
                            </div>
                        </div>
                        @switch($tipo)
                            @case('TRAYECTO')
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Trayecto</label>
                                        <select name="" id="" class="form-control" wire:model='trayecto_id'>
											<option value="">Seleccione</option>
                                            @foreach ($trayectos as $trayecto_select)
                                                <option value="{{ $trayecto_select->id }}">{{ $trayecto_select->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @break

                            @case('COHORTE')
                            @break

                            @default
                        @endswitch
                        {{-- <div class="col-md-3">
							<div class="form-group">
								<label for="">Tipo</label>
								<select name="" id="" class="form-control">

								</select>
							</div>
						</div> --}}
                    </div>
					<div class="row">
						<div class="col-md-9"></div>
						<div class="col-md-3">
							<button class="btn btn-primary btn-block" wire:click='estadisticas'>CONSULTAR</button>
						</div>
					</div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
	@if ($datos)
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">RESULTADOS DEL {{ $trayecto->observacion }} - {{ $pnf->nombre }}</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    {{-- @dump($datos) --}}
                        @php
                            $aprobados = [];
                            $reprobados = [];
                        @endphp
                        <table class="table table-bordered">
                            <tr>
                                <th>cedula</th>
                                <th>Estudiante</th>
                                <th>UC</th>
                                <th>Nota Trayecto</th>
                                <th>Aprueba</th>
                                <th>Estatus</th>
                            </tr>
                            @forelse ($datos as $dato)
                                <tr>
                                    <td>
                                        {{ $dato->cedula_estudiante }}
                                    </td>
                                    <td>
                                        {{ $dato->Alumno->nombres }}
                                        {{ $dato->Alumno->apellidos }}
                                    </td>
                                    <td>
                                        {{ $dato->Asignatura->nombre }}
                                    </td>
                                    <td>
                                        {{ $nota = round($dato->nota_sumada / $dato->Asignatura->DesAsignaturas->count()) }}
                                    </td>
                                    <td>
                                        @if ($dato->Asignatura->aprueba == 1)
                                            {{ $tipo = $dato->Alumno->tipo == 1 || $dato->Alumno->tipo == 12 ? 16 : 10 }}
                                        @else
                                            {{ $tipo = $dato->Alumno->tipo == 1 || $dato->Alumno->tipo == 12 ? 12 : 10 }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (($dato->Asignatura->aprueba == 1 && $nota >= 16) || ($dato->Asignatura->aprueba == 0 && $nota >= 12))
                                            APROBADO
                                            @php
                                                array_push($aprobados, $dato->Asignatura->codigo);
                                            @endphp
                                        @else
                                            REPROBADO
                                            @php
                                                array_push($reprobados, $dato->Asignatura->codigo);
                                            @endphp
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </table>

					</div>
					<!-- /.card-body -->
				</div>
			</div>
		</div>
		@endif
    @if ($datos)
		@php
			$aprobados_uc = array_count_values($aprobados);
			$reprobados_uc = array_count_values($reprobados);
			$total_aprobados = 0;
			$total_reprobados = 0;
		@endphp
        <div class="row">
            <div class="col-md-12">
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title">RESUMEN DEL {{ $trayecto->observacion }} - {{ $pnf->nombre }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12  table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>
                                                N°
                                            </th>
                                            <th>
                                                UNIDAD CURRICULAR
                                            </th>
                                            <th>
                                                APROBADOS
                                            </th>
                                            <th>
                                                REPROBADOS
                                            </th>
											<th>
												CURSADOS
											</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($unidades_curriculares as $key =>  $unidad)
                                            <tr>
                                                <td>
                                                    {{ $key++ }}
                                                </td>
                                                <td>
                                                    {{ $unidad->nombre }}
                                                </td>
                                                <td>{{ $uc_aprobados = (@$aprobados_uc[$unidad->codigo]) ? $aprobados_uc[$unidad->codigo] : 0 }}</td>
                                                <td>{{ $uc_reprobados = (@$reprobados_uc[$unidad->codigo]) ? $reprobados_uc[$unidad->codigo] : 0 }}</td>
												@php
													$total_aprobados += $uc_aprobados;
													$total_reprobados += $uc_reprobados;
												@endphp
												<td>
													{{ ((@$aprobados_uc[$unidad->codigo]) ? $aprobados_uc[$unidad->codigo] : 0) + ((@$reprobados_uc[$unidad->codigo]) ? $reprobados_uc[$unidad->codigo] : 0) }}
												</td>
											</tr>
                                        @empty
                                        @endforelse
                                    </tbody>
									<tfoot>
										<tr>
											<th colspan="2"	align="right">TOTALES</th>
											<th>{{ $total_aprobados }}</th>
											<th>{{ $total_reprobados }}</th>
											<th>{{ $total_aprobados+$total_reprobados }}</th>
										</tr>
									</tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
