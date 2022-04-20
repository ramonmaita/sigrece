<div>


    <div class="row" wire:loading>
        <div class="col-md-12">

            <center>

                <div class="callout callout-info" style="width: 100%">
                    <h5>
                        Generando documentos por favor espere...
                    </h5>
                </div>
            </center>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Generar Documentos</h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            {{-- <form action="#" method="POST" autocomplete="off" wire:submit.prevent='buscar'> --}}
                            {{-- <form action="#" method="POST" autocomplete="off" > --}}
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="">Periodo</label>
                                <select name="" id="" class="form-control @error('periodo') is-invalid @enderror"
                                    wire:model='periodo'>
                                    <option value="">SELECCIONE</option>
                                    @foreach ($periodos as $periodo_id)
                                        <option value="{{ $periodo_id->periodo }}">{{ $periodo_id->periodo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('periodo')
                                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
								<label for="">Tipo</label>
								<select name="" id="" class="form-control @error('tipo') is-invalid @enderror"
									wire:model='tipo'>
									<option value="">SELECCIONE</option>
									<option value="1">PNF - UPT </option>
								</select>
								@error('tipo')
									<small id="helpId" class="form-text text-danger">{{ $message }}</small>
								@enderror
							</div> --}}
                            <div class="form-group">
                                <label for="">PNF | CARRERA</label>
                                <select name="" id="" class="form-control @error('especialidad') is-invalid @enderror"
                                    wire:model='especialidad'>
                                    <option value="">SELECCIONE</option>
                                    <optgroup label="MISIÓN SUCRE" id="mision">
                                        <option value="2">Geología y Minas</option>
                                        <option value="4">Electricidad</option>
                                        <option value="6">Sistemas e Informática</option>
                                        <option value="8">Mecánica</option>
                                        <option value="10">Tecnología de Producción Agroalimentaria</option>
                                    </optgroup>
                                    <optgroup label="PNF">
                                        @foreach ($pnfs as $pnf)
                                            <option value="{{ $pnf->codigo }}">
                                                {{ Str::ucfirst(Str::lower($pnf->nombre)) }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="IUT CARRERA">
                                        <option value="20">Electricidad</option>
                                        <option value="25">Geología y Minas</option>
                                        <option value="30">Mecánica</option>
                                        <option value="35">Sistemas Industriales</option>
                                    </optgroup>
                                </select>
                                @error('especialidad')
                                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Titulo</label>
                                <select name="" id="" class="form-control @error('titulo') is-invalid @enderror"
                                    wire:model='titulo'>
                                    <option value="">SELECCIONE</option>
                                    @if (!empty($especialidad))
                                        @if ($especialidad >= 20 && $especialidad <= 35)
                                            <option value="3">TSU</option>
                                        @else{
                                            <option value="1">TSU</option>
                                            <option value="2">ING.</option>
                                        @endif
                                    @endif
                                </select>
                                @error('titulo')
                                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{-- <input name="" id="" class="btn btn-primary btn-block" type="submit" value="Buscar"
									wire:click='buscar'> --}}
                                <button class="btn btn-primary btn-block" wire:click='buscar'
                                    wire:loading.attr="disabled">
                                    Buscar</button>
                                @can('graduacion.promedio')
                                    @if ($especialidad >= 40)
                                        <button class="btn btn-info btn-block" wire:click='promedios'
                                            wire:loading.attr="disabled">
                                            Generar
                                            Promedio</button>
                                    @endif
                                @endcan
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>



    @if (!empty($graduandos))
        {{-- <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Generar Documentos</h3>
            <div class="card-tools">

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
					<table class="table table-striped table-inverse table-responsive">
						<thead class="thead-inverse">
							<tr>
								<th>cedula</th>
								<th>pnf</th>
								<th>titulo</th>
							</tr>
							</thead>
							<tbody>
								@forelse ($graduandos as $graduando)
								<tr>
									<td scope="row">{{ $graduando->cedula }}</td>
									<td>{{ $graduando->pnf }}</td>
									<td>{{ $graduando->titulo }}</td>
								</tr>
								@empty

								<tr>
									<td scope="row" colspan="3">sin resultados</td>


								</tr>
								@endforelse

							</tbody>
					</table>
				</div>

            </div>
        </div>
    </div> --}}

        @if (count($graduandos) > 0)
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Documentos</h3>
                    <div class="card-tools">

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <embed
                                src="{{ route('panel.graduacion.documentos.titulos', ['pnf' => $especialidad, 'titulo' => $titulo, 'periodo' => $periodo]) }}"
                                type="" width="100%" height="500px">
                        </div>

                        <div class="col-md-6">
                            <embed
                                src="{{ route('panel.graduacion.documentos.actas', ['pnf' => $especialidad, 'titulo' => $titulo, 'periodo' => $periodo]) }}"
                                type="" width="100%" height="500px">

                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
