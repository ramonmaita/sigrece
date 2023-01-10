<div>
	@include('alertas')
    <div class="card card-primary card-outline">
        <div class="card-header">
            @can('usuarios.create')
                <div class="card-tools float-sm-right">
                    <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button"
                        wire:click="setTitulo('Nuevo Usuario','crear')">
                        Nuevo Usuario
                    </button>
                </div>
            @endcan
        </div>
        <!-- /.card-header -->


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
            <table class="table table-hove table-striped">
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->cedula }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->apellido }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @can('usuarios.show')
                                    <a href="{{ route('panel.usuarios.show', ['usuario' => $usuario]) }}"
                                    class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                @endcan

                                @can('usuarios.loginId')
								    <a href="{{ route('panel.usuarios.edit', ['usuario' => $usuario]) }}"
										class="btn btn-warning btn-sm">
                                        <i class="fas fa-user-secret"></i>
                                    </a>
                                @endcan

                                @can('usuarios.edit')
    								<button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal"
                                        wire:click="edit({{ $usuario->id }})">
                                        <i class="fa fa-edit">
                                        </i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

    </div>

	<!-- Modal -->
    <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal" role="dialog"
        tabindex="-1" wire:ignore.self="">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ $titulo }}
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
					<div wire:loading.delay="" wire:target="store,update,tipo,user_id" style="width: 100% !important">
						<div class="callout callout-info">
						   <h5>
							  Procesando informarción por favor espere...
						   </h5>
						</div>
					 </div>
					 <form>
                    @if ($modo == 'crear')
                    <div>
						<div class="form-group">
                            <label for="">
                                Tipo
                            </label>
                            <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name=""
                                wire:model="tipo" >
                                <option selected="selected">
                                    Seleccione
                                </option>
                                <option value="DOCENTE">
                                    DOCENTE
                                </option>
                                <option value="USUARIO">
                                    USUARIO
                                </option>
								<option value="ALUMNO">
                                    ALUMNO
                                </option>
                            </select>
                            @error('tipo')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

						@if($tipo == 'DOCENTE')
						<div class="form-group select-docente" >
                            <label for="">
                                Docentes
                            </label>
                            <select class="form-control"  id="select2-docentess" name="" wire:model='user_id'
                                >
                                @forelse ($docentes as $docente)

									@if (!$docente->User)
										<option value="{{ $docente->id }}">{{ $docente->nacionalidad }}-{{ $docente->cedula }} {{ $docente->nombre_completo }}</option>
									@endif
								@empty
									<option>No hay docentes para crear usuario</option>
								@endforelse
                            </select>
                        </div>
						@endif

						@if($tipo == 'ALUMNO')
						<div class="form-group select-alumno">
                            <label for="">
                                Alumnos
                            </label>
                            <select class="form-control select2"  id="" name=""
                                >
                                @forelse ($alumnos as $alumno)
									@if (!$alumno->User)
										<option value="{{ $alumno->id }}">{{ $alumno->nacionalidad }}-{{ $alumno->cedula }} {{ $alumno->nombres }} {{ $alumno->apellidos }}</option>
									@endif
								@empty
									<option>No hay alumnos para crear usuario</option>
								@endforelse
                            </select>
                        </div>
						@endif
						@if($tipo == 'USUARIO')
							<div class="form-group">
								<label for="">
									Cedula
								</label>
								<input class="form-control @error('cedula_usuario') is-invalid @enderror" maxlength="40"
									minlength="2" type="numeric" wire:model.defer="cedula_usuario"  />
								@error('cedula_usuario')
									<small class="text-danger">
										{{ $message }}
									</small>
								@enderror
							</div>
							<div class="form-group">
								<label for="">
									Nombres
								</label>
								<input class="form-control @error('nombres') is-invalid @enderror" maxlength="40"
									minlength="3" type="text" wire:model.defer="nombres"  />
								@error('nombres')
									<small class="text-danger">
										{{ $message }}
									</small>
								@enderror
							</div>
							<div class="form-group">
								<label for="">
									Apellidos
								</label>
								<input class="form-control @error('apellidos') is-invalid @enderror" maxlength="40"
									minlength="3" type="text" wire:model.defer="apellidos"  />
								@error('apellidos')
									<small class="text-danger">
										{{ $message }}
									</small>
								@enderror
							</div>
						@endif
						<div class="form-group">
                            <label for="">
                                Correo Electronico
                            </label>
                            <input class="form-control @error('correo') is-invalid @enderror" maxlength="40"
                                minlength="6" type="email" wire:model.defer="correo"  />
                            @error('correo')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
						@if($tipo == 'USUARIO')
							<div class="form-group">
								<label for="">
									Contraseña
								</label>
								<input class="form-control @error('clave') is-invalid @enderror" maxlength="40"
									minlength="6" type="password" wire:model.defer="clave"  />
								@error('clave')
									<small class="text-danger">
										{{ $message }}
									</small>
								@enderror
							</div>
						@endif
                        {{-- <div class="form-group">
                            <label for="">
                                Nombres
                            </label>
                            <input class="form-control @error('nombres') is-invalid @enderror SoloLetras" type="text"
                                wire:model="nombres" />
                            @error('nombres')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div> --}}

                    </div>
                    @endif

					@if ($modo == 'editar')
						{{-- <div> --}}
							<div class="form-group">
								<label for="">
									Nombre
								</label>
								<input class="form-control SoloLetras @error('nombre') is-invalid @enderror" maxlength="40"
									minlength="2" type="nombre" wire:model="nombre"  />
								@error('nombre')
									<small class="text-danger">
										{{ $message }}
									</small>
								@enderror
							</div>
							<div class="form-group">
								<label for="">
									Apellido
								</label>
								<input class="form-control SoloLetras @error('apellido') is-invalid @enderror" maxlength="40"
									minlength="2" type="apellido" wire:model="apellido"  />
								@error('apellido')
									<small class="text-danger">
										{{ $message }}
									</small>
								@enderror
							</div>
							<div class="form-group">
								<label for="">
									Correo Electronico
								</label>
								<input class="form-control @error('correo') is-invalid @enderror" maxlength="40"
									minlength="6" type="email" wire:model="correo"  />
								@error('correo')
									<small class="text-danger">
										{{ $message }}
									</small>
								@enderror
							</div>
						{{-- </div> --}}
					@endif
					 </form>
					{{-- {{ $user }} --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">
                        Cancelar
                    </button>
                    @if ($modo == 'crear')
                        <button class="btn btn-primary" type="button" wire:click="store">
                            Guardar
                        </button>
                    @elseif($modo == 'editar')
                        <button class="btn btn-primary" type="button" wire:click="update">
                            Actualizar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

	@section('js')

		<script type="text/javascript">
			window.livewire.on('select2', () => {
				$('.select2,#select2-docente').select2({});
			 });
		 </script>
		<script>
			$(function () {
				window.livewire.on('cerrar_modal', () => {
					$('#exampleModal').modal('hide');
				});

				// $('#select2-docente').select2();

				// $('#select2-docente').on('change', function (e) {
				$(document).on('change', '#select2-docente', function (e) {
					var data = $('#select2-docente').select2("val");
					@this.set('user_id', data);
				});

				// $('.select2').select2({});
				// $(".select-alumno").hide();
				// $(".select-usuario").hide();
				// $(".select-docente").hide();
				$("#tipo").change(function (e) {
					e.preventDefault();
					if($(this).val() == 'DOCENTE'){
						console.log('asdasds')
						$(".select-docente").show();
						$(".select-alumno").hide();
						$(".select-usuario").hide();
					}else if($(this).val() == 'USUARIO'){
						$(".select-usuario").show();
						$(".select-docente").hide();
						$(".select-alumno").hide();
					}else if($(this).val() == 'ALUMNO'){
						$(".select-alumno").show();
						$(".select-usuario").hide();
						$(".select-docente").hide();
					}else{
						$(".select-alumno").hide();
						$(".select-usuario").hide();
						$(".select-docente").hide();
					}
				});

				$('#select2-docente').select2({
                    minimumInputLength: 2,
                    ajax: {
                        dataType: 'json',
                        url: '{{ route('panel.usuarios.dataDocente') }}',
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
                $(document).on('change', '#select2-docente', function(e) {
                    // Livewire.emit('resetear');
                    var data = $('#select2-docente').select2("val");
                    data = $.trim(data);
                    if (data === "" || 0 === data.length) {
                        console.log('esta vacio '+data);
                        data = [];
                    } else {
                        console.log('no esta vacio '+data);
                        if (data != '0') {
                            @this.set('user_id', data);
                        }
                    }
                });
			});
		</script>
	@endsection
