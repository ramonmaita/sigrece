<div>
    <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button">
        Nuevo Evento
    </button>

    <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal" role="dialog"
        tabindex="-1" wire:ignore.self="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
						Nuevo Evento
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
							@include('alertas')
                            {{-- @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            @endif --}}
                            {{-- <div wire:loading.delay="" style="width: 100%">
                                <div class="callout callout-info">
                                    <h5>
                                        Procesando informarción por favor espere...
                                    </h5>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="periodo">Periodo</label>
                                <input type="text" class="form-control" name="periodo" id="periodo"
                                    aria-describedby="helpId" placeholder="" wire:model="n_periodo" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control @error('nombre')is-invalid @enderror"
                                    wire:model="nombre" id="nombre" aria-describedby="helpId" placeholder="">
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="evento_o">Evento Origen</label>
                                <select class="form-control @error('evento_o')is-invalid @enderror" wire:model="evento_o"
                                    id="evento_o">
                                    <option value="0">Sin Evento de Origen</option>
                                </select>
                                @error('evento_o')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input type="text" class="form-control @error('descripcion')is-invalid @enderror"
                                    wire:model="descripcion" id="descripcion" aria-describedby="" placeholder="">
                                @error('descripcion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inicio">Inicio</label>
                                <input type="datetime-local" class="form-control @error('inicio')is-invalid @enderror"
                                    wire:model="inicio" id="inicio" aria-describedby="" placeholder="">
                                @error('inicio')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fin">Fin</label>
                                <input type="datetime-local" class="form-control @error('fin')is-invalid @enderror"
                                    wire:model="fin" id="fin" min="{{$inicio}}" aria-describedby="" placeholder="">
                                @error('fin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
					</div>

					<div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select class="form-control @error('tipo')is-invalid @enderror" wire:model="tipo"
                                    id="tipo">
                                    <option>SELECCIONE</option>
                                    <option value="GRADUACION">GRADUACION</option>
                                    <option value="INSCRIPCION">INSCRIPCION</option>
                                    <option value="CARGA DE CALIFICACIONES">CARGA DE CALIFICACIONES</option>
                                    <option value="SOLICITUD DE CORRECCION">SOLICITUD DE CORRECCION</option>
                                    <option value="ACTUALIZACION DE DATOS">ACTUALIZACION DE DATOS</option>
                                    <option value="ASIGNAR DOCENTES">ASIGNAR DOCENTES</option>
                                </select>
                                @error('tipo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
						</div>
						<div class="col-md-3">
                            <div class="form-group">
                                <label for="aplicar">Aplicar</label>
                                <select class="form-control @error('aplicar')is-invalid @enderror" name="aplicar"
                                    id="aplicar" wire:model='aplicar'>
                                    <option>SELECCIONE</option>
                                    @if ($tipo == 'GRADUACION')
                                        <optgroup label="GRADUACION">
                                            <option value="MISION SUCRE">MISION SUCRE</option>
                                            <option value="UPT Bolivar">UPT Bolívar</option>
                                        </optgroup>
                                    @endif
                                    @if ($tipo == 'INSCRIPCION')
                                        <optgroup label="INSCRIPCION">
                                            <option value="REGULARES">REGULARES</option>
                                            <option value="NUEVO INGRESO">NUEVO INGRESO</option>
                                            <option value="CIU">CIU</option>
                                        </optgroup>
                                    @endif
                                    @if ($tipo == 'CARGA DE CALIFICACIONES')
                                        <optgroup label="CARGA DE CALIFICACIONES">
                                            <option value="REGULARES">REGULARES</option>
                                            <option value="NUEVO INGRESO">NUEVO INGRESO</option>
                                            <option value="CIU">CIU</option>
                                            <option value="PER">PER</option>
											<option value="ESPECIFICO">ESPECIFICO</option>
                                            <option value="TODOS">TODOS</option>
                                        </optgroup>
                                    @endif
                                    @if ($tipo == 'SOLICITUD DE CORRECCION' || $tipo == 'ACTUALIZACION DE DATOS' || $tipo == 'ASIGNAR DOCENTES')
                                        <optgroup label="{{ $tipo }}">
                                            <option value="TODOS">TODOS</option>
                                            <option value="ESPECIFICO">ESPECIFICO</option>
                                        </optgroup>
                                    @endif
                                </select>
                                @error('aplicar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
						<div class="col-md-6" @if($tipo == 'SOLICITUD DE CORRECCION' && $aplicar == 'ESPECIFICO' || $tipo == 'CARGA DE CALIFICACIONES' && $aplicar == 'ESPECIFICO' || $tipo == 'ASIGNAR DOCENTES' && $aplicar == 'ESPECIFICO') style="display: block;" @else style="display: none;" @endif>
							<div class="form-group"  wire:ignore  >
								<label for="aplicable">Aplicable</label>
								<br>
								<select class="block w-full select2-usuarios form-control @error('aplicable')is-invalid @enderror " wire:model="aplicable"
									id="select2-usuarios" multiple>
									@forelse ($usuarios as $usuario)
										<option value="{{ $usuario->cedula }}">{{ $usuario->cedula }} {{ $usuario->nombre_completo }}</option>
									@empty
									@endforelse
								</select>
								@error('aplicable')
									<small class="text-danger">{{ $message }}</small>
								@enderror
							</div>
						</div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">
                        Cerrar
                    </button>
                    <button class="btn btn-primary" wire:click='store'>
                        Guardar
                    </button>

                </div>
            </div>
        </div>
    </div>
	@push('css')
		<style>
			.select2{
				width: 100% !important;
			}
		</style>
	@endpush
	@push('js')
	<script>
		// $('#select2-usuarios').select2({})
		$(document).on('change', '#select2-usuarios', function(e) {
			var data = $('#select2-usuarios').select2("val");
			// data = $.trim(data);
			// if (data ==="" || 0 === data.length) {
			// 	console.log('esta vacio '+data);
			// 	data = [];
			// }else{
			// 	console.log('no esta vacio '+data);
			// }
			@this.set('aplicable', data);
		});
		$(document).on('change', '#select2-pnfs', function(e) {
			var data = $('#select2-pnfs').select2("val");
			// data = $.trim(data);
			// if (data ==="" || 0 === data.length) {
			// 	console.log('esta vacio '+data);
			// 	data = [];
			// }else{
			// 	console.log('no esta vacio '+data);
			// }
			@this.set('aplicable', data);
		});

	</script>
	@endpush
</div>
