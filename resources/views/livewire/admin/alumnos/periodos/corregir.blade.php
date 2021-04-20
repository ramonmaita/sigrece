<div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul class="list-group">
                                @foreach ($errors->all() as $error)
                                    <li class="">
                                        <strong>
                                            {{ $error }}
                                        </strong>

                                    </li>

                                @endforeach
                            </ul>
                        </div>
                        <script>
                            $(".alert").alert();

                        </script>
                    @endif
                    @include('alertas')
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            {{ $alumno->cedula }} {{ $alumno->nombres }} {{ $alumno->apellidos }}
                        </div>
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="float-right col-md-6">
                                    <div class="form-group">
                                        <div style="display: none;">
                                            {{-- @dump($uc_historico) --}}

                                        </div>
                                        <label for="">UC </label>
                                        <select class="form-control" name="" id="" wire:model="ucAnual">
                                            <option value="">Seleccione</option>
                                            @foreach ($uc_historico as $uc)
                                                <option value="{{ $uc->codigo }}">{{ $uc->nombre }} (TRAYECTO:
                                                    {{ $uc->Trayecto->nombre }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if ($ucAnual != '' || !empty($ucAnual))
                                <div style="display: none;">
                                    {{-- @dump($periodo_uc)
                                @dump($ucPeriodoNuevo) --}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-inverse datatable">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>N° Periodo</th>
                                                    <th>Periodo</th>
                                                    <th>Trayecto</th>
                                                    <th>{{ $alumno->Plan->cohorte }}</th>
                                                    <th>UC Anual</th>
                                                    <th>UC {{ $alumno->Plan->observacion }}</th>
                                                    <th>Seccion</th>
                                                    <th>Nota</th>
                                                    <th>Borrar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($ucs as $notas)

                                                    <tr>
                                                        {{-- <td scope="row"> {{ $notas->nro_periodo }}</td> --}}
                                                        <td>

                                                            <div class="form-group">
                                                                <label for=""> {{ $notas->nro_periodo }}</label>
                                                                <select class="form-control" name="" id=""
                                                                    wire:model="ucPeriodoNuevo.{{ $notas->id }}">
                                                                    <option value="">Seleccione</option>
                                                                    @foreach ($periodo_uc as $periodoUc)

                                                                        <option value="{{ $periodoUc->id }}">
                                                                            {{ $periodoUc->nro_periodo }}</option>
                                                                    @endforeach
                                                                    @error('ucPeriodoNuevo.{{ $notas->id }}')

                                                                    @enderror
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>

                                                            <div class="form-group">
                                                                <label for=""> {{ $notas->periodo }}</label>
                                                                <select class="form-control" name="" id=""
                                                                    wire:model="ucPeriodoNuevo.{{ $notas->id }}">
                                                                    <option value="">Seleccione</option>
                                                                    @foreach ($periodo_uc as $periodoUc)

                                                                        <option value="{{ $periodoUc->id }}">
                                                                            {{ $periodoUc->periodo }}</option>
                                                                    @endforeach
                                                                    @error("ucPeriodoNuevo.$notas->id")
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>{{ $notas->Asignatura->Trayecto->nombre }}</td>
                                                        <td>{{ $notas->DesAsignatura->tri_semestre }}</td>
                                                        <td>{{ $notas->Asignatura->nombre }}</td>
                                                        <td>{{ $notas->DesAsignatura->nombre }}</td>
                                                        <td>{{ $notas->seccion }}</td>
                                                        <td>{{ $notas->nota }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger"
                                                                wire:click="borrar({{ $notas->id }})">
                                                                <i class="fas fa-trash-alt "></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">No hay registros disponibles
                                                        </td>
                                                    </tr>
                           	 					@endforelse
                            				</tbody>
                            			</table>
                        			</div>
                    			</div>
								<div class="row">
									<div class="col-md-6">

									</div>
									<div class="col-md-6">
										<button type="button" name="" id="" class="btn btn-primary btn-block" wire:click='update'>
											CAMBIAR
										</button>
									</div>
								</div>
							@endif
                		</div>
            		</div>
        		</div>
			</div>
		</div>
	</section>

</div>
