<div>
    @if ($errors->any())
        <div class="callout callout-danger">
            <h5>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </h5>
        </div>
    @endif
    @include('alertas')
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Tipo de Cambio </label>
                    <select name="" id="" class="form-control" wire:model='cambio'>
                        <option value="">Seleccione</option>
                        <option value="CAMBIO DE SECCION">CAMBIO DE SECCION</option>
                        <option value="CAMBIO DE SECCION MUTUO" disabled>CAMBIO DE SECCION MUTUO</option>
                        <option value="CAMBIO DE PNF">CAMBIO DE PNF</option>
                        <option value="CAMBIO DE PLAN">CAMBIO DE PLAN DE ESTUDIO</option>
                    </select>
                </div>
                <div class="col-md-4">
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
                    {{-- @dump($seccion_id)
					@dump($seccion)
					@dump($trayecto_id) --}}
                </div>
            </div>
        </div>
    </div>

    @if (!is_null($estudiante) && $cambio == 'CAMBIO DE SECCION')
        <div class="card card-primary card-outline">
            <div class="card-header">
                {{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }}
                {{ $alumno->apellidos }}
                {{-- @if ($showAlumno == false) --}}
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" id="quitar"
                        wire:click="$emit('resetear')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                {{-- @endif --}}
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
                                        {{-- @if (array_key_exists($uc_inscrita->id, $uc_retirar) != false)
									@if ($uc_retirar[$uc_inscrita->id] != false)
										@php
											$danger = true;
										@endphp
									@endif
								@endif --}}
                                        @if ($trayecto != $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id)
                                            <tr>
                                                <th colspan="5" align="center">
                                                    <label class="ml-4 form-check-label"
                                                        for="{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->nombre }}"
                                                        style="cursor:pointer">
                                                        <input class="form-check-input check-asignatura" type="checkbox"
                                                            wire:model="trayecto_id"
                                                            id="{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->nombre }}"
                                                            value="{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id }}">
                                                        {{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->observacion }}
                                                    </label>
                                                </th>
                                                <td>
                                                    <select class="form-control form-control-sm" name=""
                                                        id=""
                                                        wire:model="seccion_id.{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id }}"
                                                        @if (array_search($uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id, $trayecto_id) ===
                                                            false) disabled="disabled" @endif>
                                                        <option value="0">Seleccione</option>
                                                        @forelse ($uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->RelacionSeccionDocente() as $relacion)
                                                            @if (@$relacion->Seccion->cupos > 0)
                                                                <option value="{{ @$relacion->Seccion->id }}">
                                                                    {{ @$relacion->Seccion->nombre }}</option>
                                                            @endif
                                                            {{-- @foreach ($relacion->Seccion as $seccion)
												  @endforeach --}}
                                                        @empty
                                                            <option selected disabled>NO HAY SECCIONES DISPONIBLES
                                                            </option>
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
                                                        @if (array_key_exists($uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id, $seccion) !=
                                                            false)
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
                                                @if (array_key_exists($uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->trayecto_id, $seccion) !=
                                                    false)
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
                            {{-- @if ($showAlumno == false) --}}
                            <a class="btn btn-dark btn-block" href="{{ route('panel.cambios.index') }}" role="button">
                                Cancelar
                            </a>
                            {{-- @endif --}}
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
    @endif

    @if (!is_null($estudiante) && $cambio == 'CAMBIO DE PNF')
        <div class="card card-primary card-outline">
            <div class="card-header">
                {{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }}
                {{ $alumno->apellidos }}
                {{-- @if ($showAlumno == false) --}}
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" id="quitar"
                        wire:click="$emit('resetear')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                {{-- @endif --}}
            </div>
            <div class="card-body table-responsive">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">PNF ACTUAL</label>
                            <input type="text" name="" id="" class="form-control" placeholder=""
                                disabled value="{{ $alumno->Pnf->nombre }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">PNF DESTINO</label>
                            <select name="" id="" class="form-control" wire:model='pnf_d'>
                                <option value="">SELECCIONE</option>
                                @foreach ($pnfs as $pnf)
                                    @if ($pnf->id != $alumno->pnf_id)
                                        <option value="{{ $pnf->id }}">{{ $pnf->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">PLAN</label>
                            <select name="" id="" class="form-control" wire:model='plan_id'>
                                <option value="">SELECCIONE</option>
                                @foreach ($plans as $plan)
                                    @if ($plan->id != $alumno->plan_id)
                                        <option value="{{ $plan->id }}">{{ $plan->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">NUCLEO</label>
                            <select name="" id="" class="form-control" wire:model='nucleo_d'>
                                <option value="">SELECCIONE</option>
                                @forelse ($nucleos as $nucleo)
                                    <option value="{{ $nucleo->id }}">{{ $nucleo->nucleo }}</option>
                                @empty
                                    <option value="">No hay nucleos disponibles</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        {{-- @if ($showAlumno == false) --}}
                        <a class="btn btn-dark btn-block" href="{{ route('panel.cambios.index') }}" role="button">
                            Cancelar
                        </a>
                        {{-- @endif --}}
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        @if (!is_null($nucleo_d))
                            <button type="button" name="" id="" class="btn btn-primary btn-block"
                                wire:click="cambiar_pnf">
                                Cambiar
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @endif

	@if (!is_null($estudiante) && $cambio == 'CAMBIO DE PLAN')
        <div class="card card-primary card-outline">
            <div class="card-header">
                {{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }}
                {{ $alumno->apellidos }}
                {{-- @if ($showAlumno == false) --}}
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" id="quitar"
                        wire:click="$emit('resetear')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                {{-- @endif --}}
            </div>
            <div class="card-body table-responsive">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">PNF ACTUAL</label>
                            <input type="text" name="" id="" class="form-control" placeholder=""
                                disabled value="{{ $alumno->Pnf->nombre }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">PLAN</label>
                            <select name="" id="" class="form-control" wire:model='plan_id'>
                                <option value="">SELECCIONE</option>
                                @foreach ($plans as $plan)
                                    @if ($plan->id != $alumno->plan_id)
                                        <option value="{{ $plan->id }}">{{ $plan->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        {{-- @if ($showAlumno == false) --}}
                        <a class="btn btn-dark btn-block" href="{{ route('panel.cambios.index') }}" role="button">
                            Cancelar
                        </a>
                        {{-- @endif --}}
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        @if (!is_null($plan_id))
                            <button type="button" name="" id="" class="btn btn-primary btn-block"
                                wire:click="cambiar_plan">
                                Cambiar
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @endif


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
