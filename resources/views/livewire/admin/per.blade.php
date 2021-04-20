<div>
    @include('alertas')
    <div class="card card-outline card-primary">
        <div class="card-header">
             @can('correcciones.create')
             {{-- wire:click="setTitulo('Nueva solicitud','crear')" --}}
			 <div class="card-tools float-sm-right">
				<button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button" >
				   Nueva solicitud
				</button>
			 </div>
		  @endcan
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
                            Periodo
                        </th>
                        <th>
                            Unidad Curricular
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
                                {{ \Carbon\Carbon::parse($solicitud->created_at)->format('d-m-Y H:s:i A') }}
                            </td>
                            <td>
								{{ $solicitud->periodo }}
                            </td>
                            <td>
								<b>{{ $solicitud->DesAsignatura->nombre }}</b>
								@if ($solicitud->DesAsignatura->Asignatura->Plan->observacion == 'TRIMESTRAL')
									TRIMESTRE:
								@elseif ($solicitud->DesAsignatura->Asignatura->Plan->observacion == 'SEMESTRAL')
									SEMESTRE:
								@else
									AÑO:
								@endif
								<b>{{ $solicitud->DesAsignatura->tri_semestre }}</b>
                            </td>

                            <td>
                                {{ $solicitud->estatus }}
                            </td>
                            <td>

								@can('correcciones.show')
									<button class="btn btn-success btn-sm" data-target="#exampleModal" data-toggle="modal"
											wire:click="show({{ $solicitud->id }})">
										<i class="fa fa-eye">
										</i>
									</button>
								@endcan
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
                        {{-- @if ($modo == 'editar')
							Evaluar Solicitud
                        @else
                            Ver Solicitud
                        @endif --}}
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							@if($errors->any())
							    @foreach ($errors->all() as $error)
							        <div>{{ $error }}</div>
							    @endforeach
							@endif
							<div wire:loading.delay="" style="width: 100%">
								<div class="callout callout-info">
								   <h5>
									  Procesando informarción por favor espere...
								   </h5>
								</div>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label for="">PNF</label>
							<select name="" id="" class="form-control" wire:model="pnf">
								<option value="">Seleccione</option>
								@foreach ($pnfs as $pnf)
									<option value="{{ $pnf->id }}">{{ $pnf->acronimo }}</option>
								@endforeach
							</select>
							@error('pnf')
								<small  class="form-text text-danger">{{ $message }}</small>
							@enderror
						</div>
						<div class="col-md-2">
							<label for="">Plan</label>
							<select name="" id="" class="form-control" wire:model="plan_id">
								<option value="">Seleccione</option>
								@if (!is_null($planes))
									@foreach ($planes as $plan)
										<option value="{{ $plan->id }}">{{ $plan->codigo }}</option>
									@endforeach
								@endif
							</select>
							@error('plan_id')
								<small  class="form-text text-danger">{{ $message }}</small>
							@enderror
						</div>
						<div class="col-md-2">
							<label for="">Trayecto</label>
							<select name="" id="" class="form-control" wire:model="trayecto">
								<option value="">Seleccione</option>
								@foreach ($trayectos as $trayecto)
									<option value="{{ $trayecto->id }}">{{ $trayecto->observacion }}</option>
								@endforeach
							</select>
							@error('trayecto')
								<small  class="form-text text-danger">{{ $message }}</small>
							@enderror
						</div>
						<div class="col-md-3">
							<label for="">UC</label>
							<select name="" id="" class="form-control" wire:model="uc">
								<option value="">Seleccione</option>
								@foreach ($ucs as $uca)
									<option value="{{ $uca->codigo }}">{{ $uca->nombre }}</option>
								@endforeach
							</select>
							@error('uc')
								<small  class="form-text text-danger">{{ $message }}</small>
							@enderror
						</div>
						<div class="col-md-2">
							<label for="">
								Cohorte
								{{-- {{ (!is_null($pnf) || !is_null($trayecto) || !empty($plan)) ? @$plan->observacion : 'f' }} --}}
								@if (!is_null($pnf) || !is_null($trayecto) || !empty($plan))
									@if (@$plan->observacion=='ANUAL')
										{{  $tri_sem_an = 'AÑO' }}
									@elseif(@$plan->observacion=='SEMESTRAL')
										{{  $tri_sem_an = 'SEMESTRE' }}
									@elseif(@$plan->observacion=='TRIMESTRAL')
										{{  $tri_sem_an = 'TRIMESTRE' }}
                                    @else
										{{  $tri_sem_an = '' }}
                                        {{-- <br> --}}
									@endif
								@else
									TRIMESTRE|SEMESTRE|AÑO
								@endif
							</label>
							<select name="" id="" class="form-control" multiple style="height: 70px;" wire:model="cohorte">
								{{-- <option value="">Seleccione</option> --}}
								@foreach ($desucs as $desuc)
									<option value="{{ $desuc->codigo }}">{{ $desuc->tri_semestre }}</option>
								@endforeach
							</select>
							@error('cohorte')
								<small  class="form-text text-danger">{{ $message }}</small>
							@enderror
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group" >
							  <label for="">Estudiantes</label>
							  <select name=""  class="form-control select2" wire:model="estudiantea"  id="select2-alumnos" multiple>
								  <option>
									selccione
								  </option>
								  	@foreach ($estudiantes as $estudiante)
										<option value="{{ @$estudiante->cedula_estudiante }}">{{ @$estudiante->Alumno->cedula }} {{ @$estudiante->Alumno->nombres }} {{ @$estudiante->Alumno->apellidos }}</option>
									@endforeach
							  </select>
							  {{-- <small id="helpId" class="text-muted">Help text</small> --}}
							  @error('estudiantea')
								<small  class="form-text text-danger">{{ $message }}</small>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						{{-- @dump($estudiantea)
						@dump($cohorte)
						@dump($estudiante_uc_nota) --}}
						<div class="col-md-12">
							<table class="table">
								<thead>
									<tr>
										<th>N°</th>
										<th>Cedula</th>
										<th>Nombres Y Apellidos</th>
										<th>Nota Obtenida</th>
										<th>Nota PER</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($estudiantes_ad as $key => $estudiante_ad)
										<tr>
											<td scope="row">{{ $key+1 }}</td>
											<td>{{ $estudiante_ad->Alumno->cedula }}</td>
											<td>{{ $estudiante_ad->Alumno->nombres }} {{ $estudiante_ad->Alumno->apellidos }}</td>
											<td>
												{{-- {{ $estudiante_ad->Alumno->Notas($uc,37)->whereIn('cod_desasignatura',$cohorte) }} --}}
												@foreach ($estudiante_ad->Alumno->Notas($uc,$estudiante_ad->nro_periodo)->whereIn('cod_desasignatura',$cohorte) as $nota)
													{{ $tri_sem_an }}: {{ $nota->DesAsignatura->tri_semestre }} Nota:{{ $nota->nota }}<br>
													{{-- <input type="number" class="form-control"  placeholder="" value="{{ $nota->nota }}" wire:model="estudiante_uc_nota.{{$estudiante_ad->Alumno->cedula}}.cod_desasignatura"> --}}
												@endforeach
											</td>
											<td>
												{{-- @foreach ($estudiante_ad->Alumno->Notas($uc,37)->whereIn('cod_desasignatura',$cohorte) as $nota)
                                                <div class="form-group">
                                                  <input type="number" class="form-control"  placeholder="">
                                                  <small  class="form-text text-muted">Esta Nota se aplica a los {{ $tri_sem_an }} seleccionados</small>
                                                </div>
												@endforeach --}}
												<div class="form-group">
													<input type="number" min="1" max="20" class="form-control"  placeholder="" wire:model.defer="estudiante_uc_nota.{{$estudiante_ad->Alumno->cedula}}">
													@error('estudiante_uc_nota.{{$estudiante_ad->cedula_estudiante}}')
													<small  class="form-text text-danger">{{ $message }}</small>
													@enderror
													<small  class="form-text text-muted">Esta Nota se aplica a los {{ $tri_sem_an }} seleccionados</small>
												</div>
											</td>
										</tr>
									@endforeach

								</tbody>
							</table>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    @if ($modo == 'crear')
                        {{-- <button class="btn btn-primary" type="button" wire:click="store">
                            Guardar
                        </button> --}}
						<button class="btn btn-primary" type="button" wire:click="confirmPass"  wire:loading.attr="disabled">
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

							<div wire:loading.delay="" style="width: 100%" wire:target="password">
								<div class="callout callout-info">
								   <h5>
									  Procesando informarción por favor espere...
								   </h5>
								</div>
							 </div>
						</div>
					</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Contraseña
                                </label>
								<input type="password" wire:model.defer="password" class="form-control"  wire:keydown.enter="store">
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
                        <button class="btn btn-primary" type="button" wire:click="store"  wire:loading.attr="disabled">
                            Guardar
                        </button>
					{{-- @elseif ($modo == 'editar' && $estatus == 'EN ESPERA' || $modo == 'editar' && $estatus == 'EN REVISION' )
                        <button class="btn btn-primary" type="button" wire:click="update({{$solicitud_id}})"  wire:loading.attr="disabled">
                            Actualizar
                        </button> --}}

                    @endif
                </div>
            </div>
        </div>
    </div>

	@section('js')
		<script>
			window.livewire.on('cerrar_modal', () => {
				$('#exampleModal').modal('hide');
			});
			window.livewire.on('open_modal_confirm', () => {
				$('#modalConfirm').modal('show');
			});
			window.livewire.on('close_modal_confirm', () => {
				$('#modalConfirm').modal('hide');
			});
			$(document).on('change', '#select2-alumnos', function(e) {
            var data = $('#select2-alumnos').select2("val");
            // data = $.trim(data);
            // if (data ==="" || 0 === data.length) {
            // 	console.log('esta vacio '+data);
            // 	data = [];
            // }else{
            // 	console.log('no esta vacio '+data);
            // }
            @this.set('estudiantea', data);
        });
		</script>
	@endsection
</div>
