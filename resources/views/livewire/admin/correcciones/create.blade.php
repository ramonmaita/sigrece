<div>
    {{-- @if ($errors->any())
		<div class="callout callout-danger">
			<h5>
				@foreach ($errors->all() as $error)
					<div>{{ $error }}</div>
				@endforeach
			</h5>
		</div>
    @endif --}}
    @include('alertas')
    <div wire:loading.delay="200" style="width: 100%">
        <div class="callout callout-info">
            <h5>
                Procesando informarción por favor espere...
            </h5>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Tipo de Solicitud </label>
                    <select name="" id="" class="form-control" wire:model="tipo_solicitud">
                        <option value="">Seleccione</option>
                        <option value="CORRECCION DE CALIFICACION">CORRECCION DE CALIFICACION</option>
                        <option value="CAMBIO DE CALIFICACION">CAMBIO DE CALIFICACION</option>
                        <option value="ADICIONAR UC">ADICIONAR UC</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <div class="form-group" wire:ignore>
                        <label for="">Estudiante: </label>
                        <select name="" id="select2" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                        {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                    </div>
                    {{-- <div class="form-group">
						<button type="button" class="btn btn-primary btn-block" wire:click="agregar">
							Añadir
						</button>
					</div> --}}
                </div>
                <div class="col-md-4">
                    {{-- @dump($cohortes_actualizar) --}}
                    {{-- @dump($nota_cohorte) --}}
                    {{-- @dump($seccion)
					@dump($trayecto_id) --}}
                </div>
            </div>
        </div>
    </div>

    @if (!is_null($tipo_solicitud))
        @if ($tipo_solicitud == 'CORRECCION DE CALIFICACION')
            <div class="card card-primary card-outline">
                <div class="card-header">
                    {{-- {{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }} {{ $alumno->apellidos }} --}}
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" id="quitar"
                            wire:click="$emit('resetear')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Periodos Cursados</label>
                            <select name="" id="" class="form-control" wire:model="periodo_id">
                                <option value="">Selccione</option>
                                @if (!is_null($estudiante))
                                    @forelse ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}">({{ $periodo->nro_periodo }})
                                            {{ $periodo->periodo }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Unidad Curricular</label>
                            <select name="" id="" class="form-control" wire:model="cod_anual">
                                <option value="">Selccione</option>
                                @if (!is_null($periodo_id))
                                    @forelse ($ucs as $uc)
                                        <option value="{{ $uc->Asignatura->codigo }}">
                                            ({{ $uc->Asignatura->Trayecto->nombre }}) {{ $uc->Asignatura->nombre }}
                                        </option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Cohorte</label>

                            <select name="" id="" class="form-control" multiple wire:model="cohortes">
                                @if (!is_null($cod_anual))
                                    @forelse ($asignatura->DesAsignaturas as $cohorte)
                                        <option value="{{ $cohorte->codigo }}">{{ $cohorte->tri_semestre }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                        </div>
                    </div>

                    @if (!is_null($cohortes))
                        <hr>
                        @error('nota_cohorte')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @foreach ($unidades as $unidad)
                            <div class="row">
                                <div class="col-md-3">
                                    {{ $alumno->Plan->Cohorte }}: {{ $unidad->DesAsignatura->tri_semestre }}
                                </div>
                                <div class="col-md-3">
                                    Sección: {{ $unidad->seccion }}
                                </div>
                                <div class="col-md-3">
                                    Docente: <br>
                                    {{ $unidad->cedula_docente }} {{ $unidad->docente }}
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group form-group">
                                        <label for="" class="mr-4">Nota</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input type="checkbox" wire:model="cohortes_actualizar"
                                                    value="{{ $unidad->id }}">
                                            </span>
                                        </div>
                                        <input type="number" wire:model.defer="nota_cohorte.{{ $unidad->id }}"
                                            class="form-control"
                                            @if (array_search($unidad->id, $cohortes_actualizar) === false) disabled="disabled"  value="0" @endif
                                            min="1" max="20" placeholder="{{ $unidad->nota }}">
                                        @error("nota_cohorte.$unidad->id")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">

									  <input type="number"
										class="form-control" name="" id="" min="1" max="20" placeholder="" value="{{ $unidad->nota }}">
									</div> --}}
                                </div>
                            </div>
                        @endforeach
                        <hr>
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                @if (count($cohortes_actualizar) > 0)
                                    <button type="button" name="" id=""
                                        class="btn btn-primary btn-block" wire:click="update">
                                        Modificar
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if ($tipo_solicitud == 'CAMBIO DE CALIFICACION')
            <div class="card card-primary card-outline">
                <div class="card-header">
                    {{-- {{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }} {{ $alumno->apellidos }} --}}
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" id="quitar"
                            wire:click="$emit('resetear')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Periodos Cursados</label>
                            <select name="" id="" class="form-control" wire:model="periodo_id">
                                <option value="">Selccione</option>
                                @if (!is_null($estudiante))
                                    @forelse ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}">({{ $periodo->id }})
                                            {{ $periodo->nombre }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                        </div>
                        @if (!is_null($periodo_id))

                            {{-- {{ $ucs }} --}}
                            <div class="col-md-4">
                                <label for="">Unidad Curricular</label>
                                <select name="" id="" class="form-control" wire:model="cod_anual">
                                    <option value="">Selccione</option>
                                    @if (!is_null($periodo_id))
                                        @forelse ($ucs as $uc)
                                            <option value="{{ $uc->id_relacion }}">({{ $uc->trayecto }})
                                                {{ $uc->nombre }}</option>
                                        @empty
                                        @endforelse
                                    @endif
                                </select>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <label for="">Cohorte</label>

                            <select name="" id="" class="form-control" multiple
                                wire:model="cohortes">
                                @if (!is_null($cod_anual))
                                    @forelse ($cohortes_cambiar_nota as $cohorte)
                                        <option value="{{ $cohorte->id }}">
                                            {{ $cohorte->DesAsignatura->tri_semestre }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                        </div>

                    </div>


                </div>
            </div>
            @if (!is_null($cohortes))
                @forelse ($uc_cohortes as $uc_cohorte)
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            {{ $uc_cohorte->DesAsignatura->nombre }} {{ $uc_cohorte->DesAsignatura->Asignatura->Plan->cohorte }}: {{ $uc_cohorte->DesAsignatura->tri_semestre }}
							<br>
                            <small>Docente: {{ $uc_cohorte->Docente->nombres }} {{ $uc_cohorte->Docente->apellidos }}</small>
                            {{-- {{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }} {{ $alumno->apellidos }} --}}
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" id="quitar"
                                    wire:click="$emit('resetear')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Actividad</th>
                                                <th align="center">%</th>
                                                <th align="center">Nota Anterior</th>
                                                <th>Nota Nueva</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											@php
												$nota_acumulada = 0;
											@endphp
                                            @forelse ($uc_cohorte->Actividades as $actividad)
                                                <tr>
                                                    <td>{{ $actividad->actividad }}</td>
                                                    <td align="center">{{$porcentaje = $actividad->porcentaje }}</td>
                                                    <td align="center">{{$nota =  $actividad->Nota($estudiante) ? $actividad->Nota($estudiante)->nota : 0 }}
                                                    </td>
													@php
														$nota_acumulada += $nota;
													@endphp
                                                    <td>
														<div class="input-group form-group">
															<div class="input-group-prepend">
																<span class="input-group-text">
																	<input type="checkbox" wire:model="cohortes_actualizar"
																		value="{{ $actividad->id }}">
																</span>
															</div>
															<input type="number" wire:model.lazy="nota_cohorte.{{ $actividad->id }}"
																class="form-control"
																@if (array_search($actividad->id, $cohortes_actualizar) === false) disabled="disabled"  value="0" @endif
																step="0.01" min="0" max="{{ $actividad->porcentaje }}">
															@error("nota_cohorte.$actividad->id")
																<small class="text-danger">{{ $message }}</small>
															@enderror
														</div>
														{{-- <input type="number" class="form-control" step="0.01" min="0" max="{{ $porcentaje }}"> --}}
													</td>
                                                </tr>
											@empty
											@endforelse
										</tbody>
										<tfoot>
											<tr>
												<th></th>
												<th align="center">{{ $nota_acumulada }}</th>
												<th align="center">
													{{ $alumno->Escala($nota_acumulada) }}
												</th>
												<th>
													{{ $alumno->Escala(array_sum($nota_cohorte)) }}
													{{-- {{ array_sum($nota_cohorte) }} --}}
													{{-- @dump($nota_cohorte) --}}
												</th>
											</tr>
										</tfoot>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                @empty
                @endforelse

				<hr>
				<div class="row">
					<div class="col-md-9"></div>
					<div class="col-md-3">
						@if (count($cohortes_actualizar) > 0)
							<button type="button" name="" id=""
								class="btn btn-primary btn-block" wire:click="cambiar">
								Modificar
							</button>
						@endif
					</div>
				</div>
            @endif
        @endif

        @if ($tipo_solicitud == 'ADICIONAR UC')
            <div class="card card-primary card-outline">
                <div class="card-header">
                    {{-- {{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }} {{ $alumno->apellidos }} --}}
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" id="quitar"
                            wire:click="$emit('resetear')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Periodos Cursados</label>
                            <select name="" id="" class="form-control" wire:model="periodo_id">
                                <option value="">Selccione</option>
                                @if (!is_null($estudiante))
                                    @forelse ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}">({{ $periodo->nro_periodo }})
                                            {{ $periodo->periodo }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Unidad Curricular</label>
                            <select name="" id="" class="form-control" wire:model="cod_anual">
                                <option value="">Selccione</option>
                                @if (!is_null($periodo_id))
                                    @forelse ($alumno->Plan->Asignaturas as $uc)
                                        <option value="{{ $uc->id }}">({{ $uc->Trayecto->nombre }})
                                            {{ $uc->nombre }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Cohorte</label>

                            <select name="" id="" class="form-control" multiple
                                wire:model="cohortes">
                                @if (!is_null($cod_anual))
                                    @forelse ($asignatura->DesAsignaturas as $cohorte)
                                        <option value="{{ $cohorte->id }}">{{ $cohorte->tri_semestre }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                        </div>
                    </div>

                    @if (!is_null($cohortes))
                        <hr>


                        @foreach ($unidades as $unidad)
                            <div class="row">
                                <div class="col-md-3">
                                    {{ $alumno->Plan->Cohorte }}: {{ $unidad->tri_semestre }}
                                </div>
                                <div class="col-md-3">
                                    <label for="">Sección</label>
                                    <input type="text" maxlength="20" class="form-control"
                                        wire:model.defer="seccion.{{ $unidad->id }}">
                                    @error('seccion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @error("seccion.$unidad->id")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="">Docente</label>
                                    <select name="" id="" class="form-control"
                                        wire:model.defer="docente_id.{{ $unidad->id }}">
                                        <option value="">Seleccione</option>
                                        @foreach ($docentes as $docente)
                                            <option value="{{ $docente->id }}">{{ $docente->cedula }}
                                                {{ $docente->nombres }} {{ $docente->apellidos }}</option>
                                        @endforeach
                                    </select>
                                    @error('docente_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @error("docente_id.$unidad->id")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Nota</label>
                                        <input type="number" wire:model.defer="nota_cohorte.{{ $unidad->id }}"
                                            class="form-control" min="1" max="20" placeholder="">
                                        @error('nota_cohorte')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @error("nota_cohorte.$unidad->id")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <hr>
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                {{-- @if (count($cohortes_actualizar) > 0) --}}
                                <button type="button" name="" id=""
                                    class="btn btn-primary btn-block" wire:click="store">
                                    Agregar
                                </button>
                                {{-- @endif --}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @endif

    {{-- @if (!is_null($estudiante))
		<div class="card card-primary card-outline">
			<div class="card-header">
				{{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }}
				{{ $alumno->apellidos }}
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove" id="quitar"
							wire:click="$emit('resetear')">
							<i class="fas fa-times"></i>
						</button>
					</div>
			</div>
			<div class="card-body table-responsive">
				@if (@$alumno->InscritoActual())
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-inverse">
								<thead class="thead-inverse">
									<tr>
										<th>N°</th>
										<th>Trayecto</th>
										<th>{{ $alumno->Plan->cohorte }}</th>
										<th>UC</th>
										<th>Seccion</th>
										<th>Nueva Seccion</th>
									</tr>
								</thead>
								<tbody>
									@php
									$asignatura = 0;
									$indicador = 0;
									$danger = false;
									$trayecto = 9;
								@endphp
								@foreach ($alumno->InscritoActual()->Inscripcion as $key => $uc_inscrita)
									@if ($trayecto != $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id)
										<tr>
											<th colspan="5" align="center">
												<label class="ml-4 form-check-label" for="{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->nombre }}" style="cursor:pointer">
													<input class="form-check-input check-asignatura" type="checkbox" wire:model="trayecto_id" id="{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->nombre }}" value="{{$uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id}}">
													{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->observacion }}
												</label>
											</th>
											<td>
												<select class="form-control form-control-sm" name="" id="" wire:model="seccion_id.{{$uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id}}" @if (array_search($uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id, $trayecto_id) === false) disabled="disabled" @endif>
													<option value="0">Seleccione</option>
													@forelse ($uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->RelacionSeccionDocente() as $relacion)
													@if (@$relacion->Seccion->cupos > 0)

													<option value="{{ @$relacion->Seccion->id }}">{{ @$relacion->Seccion->nombre }}</option>
													@endif
													@empty
													<option selected disabled>NO HAY SECCIONES DISPONIBLES</option>
													@endforelse
												</select>
											</td>
										</tr>
									@endif

									@if ($alumno->Plan->cohorte != 'AÑO')
										@if ($asignatura != $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->codigo || $loop->first)
											@php
												$indicador++;
											@endphp
											<tr
												class="text-center bg-{{ $danger == true ? 'danger' : 'success' }}">
												<td scope="row" colspan="5">
													{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->nombre }}
												</td>
												<td class="">
													@if (array_key_exists($uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id, $seccion) != false)
													{{ $seccion[$uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id] }}
													@endif
												</td>
											</tr>
										@endif
									@endif
									<tr
										class="{{ $alumno->Plan->cohorte == 'AÑO' ? ($danger == true ? 'bg-danger' : 'bg-success') : '' }}">
										<td scope="row">{{ $key + 1 }}</td>
										<td>{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->nombre }}
										</td>
										<td>{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->tri_semestre }}
										</td>
										<td>{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->nombre }}
										</td>
										<td>{{ $uc_inscrita->RelacionDocenteSeccion->Seccion->nombre }}</td>
										<td class="">
											@if (array_key_exists($uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id, $seccion) != false)
											{{ $seccion[$uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id] }}

											@endif
										</td>
									</tr>
									@php
										$danger = false;
										$asignatura = $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->codigo;
										$trayecto = $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id;
									@endphp
								@endforeach
								</tbody>
							</table>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<a class="btn btn-dark btn-block" href="{{ route('panel.cambios.index') }}" role="button">
								Cancelar
							</a>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4">
							@if (count($trayecto_id) > 0)
								<button type="button" name="" id="" class="btn btn-primary btn-block"
										wire:click="cambiar">
										Cambiar
								</button>
							@endif
						</div>
					</div>
				@else
					<div class="callout callout-danger">
						<h5>Error!</h5>
						<p>El estudiante no se encuentra inscrito en el periodo actual.</p>
					</div>
				@endif
			</div>
		</div>
	@endif --}}


    @section('js')
        <!-- scriptps retiros-create -->
        <script>
            $(function() {
                $('#select2').select2({
                    minimumInputLength: 2,
                    ajax: {
                        dataType: 'json',
                        url: '{{ route('panel.inscripciones.regulares.data') }}',
                        delay: 250,
                        data: function(params) {
                            return {
                                term: params.term
                            }
                        },
                        processResults: function(data, page) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });
                $(document).on('change', '#select2', function(e) {
                    // Livewire.emit('resetear');
                    var data = $('#select2').select2("val");
                    data = $.trim(data);
                    if (data === "" || 0 === data.length) {
                        // console.log('esta vacio '+data);
                        data = [];
                    } else {
                        // console.log('no esta vacio '+data);
                        if (data != '0') {
                            @this.set('estudiante', data);
                        }
                    }
                });
                window.livewire.on('reset-select', () => {
                    // console.log('quitar')
                    $("#select2").select2("val", "0");
                });

            });
        </script>
    @endsection
</div>
