<div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
    @include('alertas')
	@if($showAlumno == false)
		<div class="card card-primary card-outline">
			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						{{-- {{ $estudiante }} @dump($uc_retirar) --}}
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
						{{-- @dump($contadorRetirar) --}}
					</div>
				</div>
			</div>
		</div>
	@endif
    @if (!is_null($estudiante))
        <div class="card card-primary card-outline">
            <div class="card-header">
                {{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }}
                {{ $alumno->apellidos }}
				@if($showAlumno == false)
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove" id="quitar"
							wire:click="$emit('resetear')">
							<i class="fas fa-times"></i>
						</button>
					</div>
				@endif
            </div>
            <div class="card-body table-responsive">
                @if ($alumno->InscritoActual())
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
                                        <th>Retirar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $asignatura = 0;
                                        // $indicador = 0;
                                        $danger = false;
                                    @endphp
                                    @foreach ($alumno->InscritoActual()->Inscripcion as $key => $uc_inscrita)
                                        @if (array_key_exists($uc_inscrita->id, $uc_retirar) != false)
                                            @if ($uc_retirar[$uc_inscrita->id] != false)
                                                @php
                                                    $danger = true;
                                                @endphp
                                            @endif
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
                                                        <div class="form-check">
                                                            <label class="form-check-label" sytle="cursor:pointer;">
                                                                <input type="checkbox"
                                                                    class="select-all form-check-input " id=""
                                                                    value="{{ $indicador }}">
                                                                SI RETIRAR
                                                            </label>
                                                        </div>
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
                                                @if ($alumno->Plan->cohorte == 'AÑO')
                                                    @php $indicador++; @endphp
                                                    <div class="form-check">
                                                        <label class="form-check-label label-{{ $indicador }}"
                                                            sytle="cursor:pointer;">
                                                            <input type="checkbox"
                                                                class="form-check-input {{ $indicador }} select-all"
                                                                id="" value="{{ $uc_inscrita->id }}"
                                                                wire:model="uc_retirar.{{ $uc_inscrita->id }}">
                                                            SI RETIRAR
                                                        </label>
                                                    </div>
                                                @else
                                                    <input type="checkbox" style="display:none;"
                                                        class="form-check-input {{ $indicador }}" id=""
                                                        value="{{ $uc_inscrita->id }}"
                                                        wire:model="uc_retirar.{{ $uc_inscrita->id }}">
                                                    <div class="form-check">
                                                        <label class="form-check-label label-{{ $indicador }}"
                                                            sytle="cursor:pointer;">
                                                            @if ($danger == true)
                                                                <small class="text-danger text-capitalize">Para
                                                                    retirar</small>
                                                            @endif

                                                        </label>
                                                    </div>

                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            $danger = false;
                                            $asignatura = $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->codigo;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
							@if($showAlumno == false)
                            <a class="btn btn-dark btn-block" href="{{ route('panel.retiros.index') }}" role="button">
                                Cancelar
                            </a>
							@endif
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            @if ($contadorRetirar != null || $contadorRetirar > 0)
                                <button type="button" name="" id="" class="btn btn-primary btn-block"
                                    wire:click="retirar">
                                    Retirar ({{ $contadorRetirar }}) UC
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

    @section('css')
        <style>
            .form-check-label,
            .form-check-input {
                cursor: pointer !important;
            }

        </style>
    @endsection
    @section('js')
	<!-- scriptps retiros-create -->
        <script>
            $(function() {
                $(document).on('click', '.select-all', function() {
                    var value = $(this).val();
                    if ($(this).prop('checked') == false) {
                        $('.' + value).click();
                        Livewire.emit('disminuir');
                    } else {
                        $('.' + value).click();
                        Livewire.emit('incrementar');
                    }
                });
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
