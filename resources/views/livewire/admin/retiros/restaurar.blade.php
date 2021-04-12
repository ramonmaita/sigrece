<div>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
    @include('alertas')
    <div class="card card-primary card-outline">
        <div class="card-header">
            {{ $solicitud->Solicitante->cedula }} {{ $solicitud->Solicitante->nombre }}
            {{ $solicitud->Solicitante->apellido }}
        </div>
        <div class="card-body table-responsive">
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
								<th>Restaurar</th>
							</tr>
						</thead>
						<tbody>
							@php
								$asignatura = 0;
								$indicador = 0;
								$success = false;
							@endphp
							@foreach ($retiros as $key => $retiro)
								@if (array_key_exists($retiro->id, $uc_restaurar) != false)
									@if ($uc_restaurar[$retiro->id] != false)
										@php
											$success = true;
										@endphp
									@endif
								@endif
								@if ($alumno->Plan->cohorte != 'AÑO')
									@if ($asignatura != $retiro->RelacionDocenteSeccion->DesAsignatura->Asignatura->codigo || $loop->first)
										@php
											$indicador++;
										@endphp
										<tr class="text-center bg-{{ $success == true ? 'success' : 'danger' }}">
											<td scope="row" colspan="5">
												{{ $retiro->RelacionDocenteSeccion->DesAsignatura->Asignatura->nombre }}</td>
											<td class="">
												<div class="form-check">
													<label class="form-check-label" sytle="cursor:pointer !important;">
														<input type="checkbox" class="select-all form-check-input " id=""
															value="{{ $indicador }}">
														SI RESTAURAR
													</label>
												</div>
											</td>
										</tr>
									@endif
								@endif
								<tr
									class="{{ $alumno->Plan->cohorte == 'AÑO' ? ($success == true ? 'bg-success' : 'bg-danger') : '' }}">
									<td scope="row">{{ $key + 1 }}</td>
									<td>{{ $retiro->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->nombre }}
									</td>
									<td>{{ $retiro->RelacionDocenteSeccion->DesAsignatura->tri_semestre }}</td>
									<td>{{ $retiro->RelacionDocenteSeccion->DesAsignatura->nombre }}</td>
									<td>{{ $retiro->RelacionDocenteSeccion->Seccion->nombre }}</td>
									<td class="">
										@if ($alumno->Plan->cohorte == 'AÑO')
											@php $indicador++; @endphp
											<div class="form-check">
												<label class="form-check-label label-{{ $indicador }}"
													sytle="cursor:pointer !important;">
													<input type="checkbox"
														class="form-check-input {{ $indicador }} select-all" id=""
														value="{{ $retiro->id }}"
														wire:model="uc_restaurar.{{ $retiro->id }}">
													SI RESTAURAR
												</label>
											</div>
										@else
											<input type="checkbox" style="display:none;"
												class="form-check-input {{ $indicador }}" id="" value="{{ $retiro->id }}"
												wire:model="uc_restaurar.{{ $retiro->id }}">
											<div class="form-check">
												<label class="form-check-label label-{{ $indicador }}"
													sytle="cursor:pointer !important;">
													@if ($success == true)
														<small class="text-success text-capitalize">Para restaurar</small>
													@endif

												</label>
											</div>

										@endif
									</td>
								</tr>
								@php
									$success = false;
									$asignatura = $retiro->RelacionDocenteSeccion->DesAsignatura->Asignatura->codigo;
								@endphp
							@endforeach
						</tbody>

					</table>
				</div>
			</div>

            <div class="row">
                <div class="col-md-4">
                    <a class="btn btn-dark btn-block" href="{{ route('panel.retiros.index') }}" role="button">
                        Cancelar
                    </a>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    @if ($contadorRestaurar != null || $contadorRestaurar > 0)
                        <button type="button" name="" id="" class="btn btn-primary btn-block" wire:click="restaurar">
                            Restaurar ({{ $contadorRestaurar }}) UC
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @section('css')
        <style>
            .form-check-label,
            .form-check-input {
                cursor: pointer !important;
            }

        </style>
    @endsection
    @section('js')
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
