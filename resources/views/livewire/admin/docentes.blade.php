<div>
    @include('alertas')
    <div class="card card-outline card-primary">
        <div class="card-header">
            @can('docentes.create')
                <div class="card-tools float-sm-right">
                    <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button"
                        wire:click="setTitulo('Nuevo Docente','crear')">
                        Nuevo Docente
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
                            Nacionalidad
                        </th>
                        <th>
                            Cédula
                        </th>
                        <th>
                            Nombres
                        </th>
                        <th>
                            Apellidos
                        </th>
                        <th>
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($docentes as $docente)
                        <tr>
                            <td>
                                {{ $docente->nacionalidad }}
                            </td>
                            <td>
                                {{ $docente->cedula }}
                            </td>
                            <td>
                                {{ $docente->nombres }}
                            </td>
                            <td>
                                {{ $docente->apellidos }}
                            </td>
                            <td>
                                @can('docentes.edit')
                                    <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal"
                                        wire:click="edit({{ $docente->id }})">
                                        <i class="fa fa-edit">
                                        </i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th class="text-center" colspan="5">
                                <smal class="text-muted">
                                    @if ($search == '')
                                        No hay registro para mostrar.
                                    @else
                                        No se encontraron resultados de la busqueda "{{ $search }}" en la pagina
                                        {{ $page }}.
                                    @endif
                                </smal>
                            </th>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="float-right">
                                {{ $docentes->links() }}
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
                    {{-- @if ($modo == 'crear') --}}
                    <div>
                        <div class="form-group">
                            <label for="">
                                Cedula
                            </label>
                            <input class="form-control @error('cedula') is-invalid @enderror SoloNumeros" maxlength="8"
                                minlength="6" type="text" wire:model="cedula" />
                            @error('cedula')
                                <smal class="text-danger">
                                    {{ $message }}
                                </smal>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">
                                Nombres
                            </label>
                            <input class="form-control @error('nombres') is-invalid @enderror SoloLetras" type="text"
                                wire:model="nombres" />
                            @error('nombres')
                                <smal class="text-danger">
                                    {{ $message }}
                                </smal>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">
                                Apellidos
                            </label>
                            <input class="form-control @error('apellidos') is-invalid @enderror SoloLetras" type="text"
                                wire:model="apellidos" />
                            @error('apellidos')
                                <smal class="text-danger">
                                    {{ $message }}
                                </smal>
                            @enderror
                        </div>
                        <div class="form-group" wire:ignore="">
                            <label for="">
                                Nacionalidad
                            </label>
                            <select class="form-control @error('nacionalidad') is-invalid @enderror" id="" name=""
                                wire:model="nacionalidad">
                                <option selected="selected">
                                    Seleccione
                                </option>
                                <option value="V">
                                    Venezolano
                                </option>
                                <option value="E">
                                    Extranjero
                                </option>
                            </select>
                            @error('apellidos')
                                <smal class="text-danger">
                                    {{ $message }}
                                </smal>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">
                                Fecha de Nacimiento
                            </label>
                            <input class="form-control @error('fechan') is-invalid @enderror" type="date"
                                wire:model="fechan" />
                            @error('fechan')
                                <smal class="text-danger">
                                    {{ $message }}
                                </smal>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">
                                Sexo {{ $sexo }}
                            </label>
                            <select class="form-control @error('sexo') is-invalid @enderror" id="" name=""
                                wire:model="sexo">
                                <option selected="selected">
                                    Seleccione
                                </option>
                                <option value="FEMENINO">
                                    FEMENINO
                                </option>
                                <option value="MASCULINO">
                                    MASCULINO
                                </option>
                            </select>
                            @error('sexo')
                                <smal class="text-danger">
                                    {{ $message }}
                                </smal>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">
                                Estatus
                            </label>
                            <select class="form-control @error('estatus') is-invalid @enderror" id="" name=""
                                wire:model="estatus">
                                <option selected="selected">
                                    Seleccione
                                </option>
                                <option value="ACTIVO">
                                    ACTIVO
                                </option>
                                <option value="INACTIVO">
                                    INACTIVO
                                </option>
                            </select>
                            @error('estatus')
                                <smal class="text-danger">
                                    {{ $message }}
                                </smal>
                            @enderror
                        </div>
                    </div>
                    {{-- @endif --}}
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
