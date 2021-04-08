<div>
   @include('alertas')
   <div class="card">
      <div class="card-header">
         <h3 class="card-title">
            Periodos
         </h3>
         @can('periodos.create')
            <div class="card-tools float-right">
               <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button" wire:click="setModo('crear')">
                  Crear Periodo
               </button>
            </div>
         @endcan
         <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive">
         <div class="card-tools float-right mb-2 ">
            <div class="input-group input-group-sm" style="width: 200px;">
               <input class="form-control float-right" placeholder="Buscar" type="text" wire:model="search">
                  <div class="input-group-append">
                     <button class="btn btn-default" type="submit">
                        <i class="fas fa-search">
                        </i>
                     </button>
                  </div>
               </input>
            </div>
         </div>
         <table class="table table-hove table-striped">
            <thead>
               <tr>
                  <th>
                     Periodo
                  </th>
                  <th>
                     Obvservacion
                  </th>
                  <th>
                     Acciones
                  </th>
               </tr>
            </thead>
            <tbody>
               @forelse ($periodos as $periodo)
               <tr>
                  <td>
                     {{ $periodo->nombre }}
                  </td>
                  <td>
                     {{ $periodo->observacion }}
                  </td>
                  <td>
                     @can('periodos.edit')
                        <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal" wire:click="edit({{ $periodo->id }})">
                           <i class="fa fa-edit">
                           </i>
                        </button>
                     @endcan
                     {{--
                     <a class="btn btn-success" href="{{ route('panel.periodos.show',['usuario' => $usuario]) }}">
                        <i class="fa fa-eye">
                        </i>
                     </a>
                     --}}
                  </td>
               </tr>
               @empty
               <tr>
                  <td class="text-center text-muted" colspan="3">
                     @if($search =='')
                          No hay registros disponibles.
                      @else
                          No se encontraron resultados de la busqueda "{{$search}}" en la página {{$page}}.
                      @endif
                  </td>
               </tr>
               @endforelse
            </tbody>
         </table>
         <div class="float-right">
            {{ $periodos->links() }}
         </div>
      </div>
   </div>
   <!-- Modal -->
   <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal" role="dialog" tabindex="-1" wire:ignore.self="">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">
                  @if ($modo == 'crear')
                    Crear Nuevo Periodo
                @else
                    Editar Periodo
                @endif
               </h5>
               <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                  <span aria-hidden="true">
                     ×
                  </span>
               </button>
            </div>
            <div class="modal-body">
               {{--
               <form action="">
                  --}}
                  <div class="form-group">
                     <label for="">
                        Nombre
                     </label>
                     <input class="form-control @error('nombre') is-invalid @enderror" type="text" wire:model.defer="nombre">
                        @error('nombre')
                        <small class="text-danger">
                           {{ $message }}
                        </small>
                        @enderror
                     </input>
                  </div>
                  <div class="form-group">
                     <label for="">
                        Descripción
                     </label>
                     <input class="form-control @error('observacion') is-invalid @enderror" type="text" wire:model="observacion">
                        @error('observacion')
                        <small class="text-danger">
                           {{ $message }}
                        </small>
                        @enderror
                     </input>
                  </div>
                  <div class="form-group">
                     <label for="">
                        Estatus
                     </label>
                     <select class="form-control" id="" name="" wire:model="estatus">
                        <option value="0">
                           Activo
                        </option>
                        <option value="1">
                           Inactivo
                        </option>
                     </select>
                  </div>
                  {{--
               </form>
               --}}
            </div>
            <div class="modal-footer">
               <button class="btn btn-secondary" data-dismiss="modal" type="button" wire:click="cancelar">
                  Cerrar
               </button>
               @if ($modo == 'crear')
               <button class="btn btn-primary btn-flat" type="button" wire:click="store">
                  Guardar
               </button>
               @else
               <button class="btn btn-primary btn-flat" type="button" wire:click="update">
                  Actualizar
               </button>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
