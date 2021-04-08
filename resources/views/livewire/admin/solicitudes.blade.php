<div>
    @include('alertas')
    <div class="card card-outline card-primary">
        <div class="card-header">
            {{-- @can('solicitudes.create')
			 <div class="card-tools float-sm-right">
				<button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button" wire:click="setTitulo('Nueva solicitud','crear')">
				   Nueva solicitud
				</button>
			 </div>
		  @endcan --}}
        </div>
        <div class="card-body table-responsive">
            <div class="float-right mb-2 card-tools ">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input class="float-right form-control" placeholder="Buscar" type="text" wire:model="search" />
                    @if ($search != '')
                        <div class="input-group-append">
                            <button class="btn btn-default" wire:click="resetSearch">
                                <i class="fas fa-times-circle">
                                </i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>
                            Fecha
                        </th>
                        <th>
                            Solicitante
                        </th>
                        <th>
                            Periodo
                        </th>
                        <th>
                            Unidad Curricular
                        </th>
                        <th>
                            Tipo
                        </th>
                        <th>
                            Estatus
                        </th>
                        <th>
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                        <tr>
                            <td>
                                {{ $solicitud->created_at }}
                            </td>
                            <td>
                                {{ $solicitud->Solicitante->nombre }} {{ $solicitud->Solicitante->apellido }}
                            </td>
                            <td>
                                {{ $solicitud->periodo }}
                            </td>
                            <td>
                                {{ $solicitud->DesAsignatura->nombre }}
                            </td>
                            <td>
                                {{ $solicitud->tipo }}
                            </td>
                            <td>
                                {{ $solicitud->estatus }}
                            </td>
                            <td>
                                @if ($solicitud->estatus == 'EN ESPERA')

                                    <button class="btn btn-dark btn-sm" data-target="#exampleModal" data-toggle="modal"
                                        wire:click="edit({{ $solicitud->id }})">
                                        <i class="fa fa-edit">
                                        </i>
                                    </button>

                                @elseif ($solicitud->estatus == 'EN REVISION')

                                    <button class="btn btn-info btn-sm" data-target="#exampleModal" data-toggle="modal"
                                        wire:click="edit({{ $solicitud->id }})">
                                        <i class="fa fa-edit">
                                        </i>
                                    </button>

                                {{-- @else --}}


                                @endif
								<button class="btn btn-success btn-sm" data-target="#exampleModal" data-toggle="modal"
                                        wire:click="show({{ $solicitud->id }})">
									<i class="fa fa-eye">
									</i>
								</button>
                                {{-- @can('solicitudes.edit')
						 <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal" wire:click="edit({{ $solicitud->id }})">
							<i class="fa fa-edit">
							</i>
						 </button>
					  @endcan
					  @can('solicitudes.configurar')
					  <a href="{{ ($solicitud->DesAsignaturas->count() > 0)  ? route('panel.solicitudes.editar_config',['id' => $solicitud->id]) : route('panel.solicitudes.config',['id' => $solicitud->id]) }}" class="btn btn-{{($solicitud->DesAsignaturas->count() > 0)  ? 'warning' : 'info'}} btn-sm" ><i class="fa fa-cogs">
						 </i> </a>
					  @endcan --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th class="text-center" colspan="7">
                                <small class="text-muted">
                                    @if ($search == '')
                                        No hay registro para mostrar.
                                    @else
                                        No se encontraron resultados de la busqueda "{{ $search }}" en la pagina
                                        {{ $page }}.
                                    @endif
                                </small>
                            </th>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="float-right">
                                {{ $solicitudes->links() }}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal" role="dialog"
        tabindex="-1" wire:ignore.self="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @if ($modo == 'editar')
							Evaluar Solicitud
                        @else
                            Ver Solicitud
                        @endif
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">
                                    Fecha y Hora de Solicitud
                                </label>
                                <p>
                                    {{ $fecha }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">
                                    Solicitante
                                </label>
                                <p>
                                    {{ $solicitante }}
                                </p>
                            </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="">
									Tipo
								</label>
								<p>
									{{ $tipo }}
								</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="">
									Periodo
								</label>
								<p>
									{{ $periodo }}
								</p>
							</div>
						</div>
						<div class="col-md-4">
                            <div class="form-group">
                                <label for="">
                                    Unidad Curricular
                                </label>
                                <p>
                                    {{ $uc }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">
                                    Estatus
                                </label>
								@if ($tipo == 'RESET' && $modo == 'editar')
								<select name="" id="" wire:model="estatus" class="form-control">
									<option value="EN REVISION" disabled>EN REVISION</option>
									<option value="PROCESADO">PROCESADO</option>
									<option value="PROCESADO CON OBSERVACIONES">PROCESADO CON OBSERVACIONES</option>
									<option value="RECHAZADO">RECHAZADO</option>
								</select>
								@else
                                <p>
                                    {{ $estatus }}
                                </p>
								@endif
                            </div>
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="">
									Sección
								</label>
								<p>
									{{ $seccion }}
								</p>
							</div>
						</div>
						<div class="col-md-4">
                            <div class="form-group">
                                <label for="">
                                    Motivo
                                </label>
                                <p>
                                    {{ $motivo }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">
                                    Observaciones
                                </label>
								@if ($tipo == 'RESET' && $modo == 'editar')
									<input type="text" wire:model.defer="observacion" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
							 	 	{{-- <small id="helpId" class="form-text text-muted">Help text</small> --}}
								@else
                                <p>
                                    {{ $observacion }}
                                </p>
								@endif
                            </div>
                        </div>
                    </div>
					@if ($tipo != 'RESET')
						<div class="row">
							<div class="col-md-12 table-responsive">
								<table class="table table-striped table-inverse ">
									<thead class="thead-inverse">
										<tr>
											<th>N°</th>
											<th>Cédula</th>
											<th>Nombres y Apellido</th>
											@if($tipo == 'CORRECCION')
											<th>Nota Erronea</th>
											<th>Corrección</th>
											@endif
											<th>
												Acción
											</th>
											<th>
												Observación
											</th>
										</tr>
										</thead>
										<tbody>
											@foreach ($estudiantes as $key => $estudiante)
												<tr>
													<td scope="row">
														{{ $key+1 }}
													</td>
													<td>
														{{ $estudiante['cedula'] }}
													</td>
													<td>
														{{ $estudiante['nombres'] }} {{ $estudiante['apellidos'] }}
													</td>
													@if($tipo == 'CORRECCION')
													<td>{{ $estudiante['erronea'] }}</td>
													<td>
														{{ $estudiante['nota'] }}
													</td>
													@endif
													<td>
														@if ($modo != 'ver')
															@if ($estudiante['estatus'] == 'EN ESPERA' || $estudiante['estatus'] == 'EN REVISION')
																<select name="" id="" class="form-control" wire:model="detalle_estatus.{{$estudiante['cedula']}}">
																	@php
																		$es = ['EN ESPERA','EN REVISION','PROCESADO', 'PROCESADO CON OBSERVACIONES','RECHAZADO'];
																	@endphp
																	@foreach ($es as $e)
																		<option value="{{ $e }}" {{ ($e == $estudiante['estatus']) ? 'selected' : '' }}>{{ $e }}</option>
																	@endforeach
																</select>
															@else
																{{ $estudiante['estatus'] }}
															@endif
														@else
															{{ $estudiante['estatus'] }}
														@endif
													</td>
													<td>
														@if ($modo != 'ver')
															@if ($estudiante['estatus'] == 'EN ESPERA' || $estudiante['estatus'] == 'EN REVISION')
																<input type="text" wire:model.defer="detalle_observacion.{{$estudiante['cedula']}}" class="form-control" @if($detalle_estatus[$estudiante['cedula']] == 'EN ESPERA') disabled @endif>
															@else
																{{ $estudiante['observacion'] }}
															@endif
														@else
														{{ $estudiante['observacion'] }}
														@endif
													</td>
												</tr>
											@endforeach
										</tbody>
								</table>
							</div>
						</div>
					@endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    @if ($modo == 'crear')
                        <button class="btn btn-primary" type="button" wire:click="store">
                            Guardar
                        </button>
					@elseif ($modo == 'editar' && $estatus == 'EN ESPERA' || $modo == 'editar' && $estatus == 'EN REVISION' || $modo == 'editar' && $tipo == 'RESET')
                        <button class="btn btn-primary" type="button" wire:click="confirmPass"  wire:loading.attr="disabled">
                            Actualizar
                        </button>

                    @endif
                </div>
            </div>
        </div>
    </div>

	<!-- Modal -->
    <div aria-hidden="true" aria-labelledby="modal-confirm-label" class="modal fade" id="modalConfirm" role="dialog"
        tabindex="1" wire:ignore.self="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
					<div class="row">
						<div class="col-md-12">
							<h5 class="modal-title" id="modal-confirm-label">
								{{ __('¿Esta seguro que desea actualizar la solicitud?') }}
							</h5>
						</div>
						<div class="col-md-12">

							<small> {{ __('Ingrese su contraseña para confirmar que desea actualizar la solicitud.') }}</small>
						</div>
					</div>
					<br>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Contraseña
                                </label>
								<input type="password" wire:model.defer="password" class="form-control"  wire:keydown.enter="update({{$solicitud_id}})">
                                @error('password')
									<small class="text-danger">
										{{ $message }}
									</small>
								@enderror
                            </div>
                        </div>
					</div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    @if ($modo == 'crear')
                        <button class="btn btn-primary" type="button" wire:click="store">
                            Guardar
                        </button>
					@elseif ($modo == 'editar' && $estatus == 'EN ESPERA' || $modo == 'editar' && $estatus == 'EN REVISION' )
                        <button class="btn btn-primary" type="button" wire:click="update({{$solicitud_id}})"  wire:loading.attr="disabled">
                            Actualizar
                        </button>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
