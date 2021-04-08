<div>
   @include('alertas')
   <div class="card card-outline card-primary">
      <div class="card-header">
         @can('nucleos.create')
            <div class="card-tools float-sm-right">
               <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button" wire:click="setTitulo('Nuevo Nucleo','crear')">
                  Nuevo Nucleo
               </button>
            </div>
         @endcan
      </div>
      <div class="card-body table-responsive">
         <div class="float-right mb-2 card-tools ">
            <div class="input-group input-group-sm" style="width: 200px;">
               <input class="float-right form-control" placeholder="Buscar" type="text" wire:model="search"/>
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
                     Nucleo
                  </th>
                  <th>
                     Locación
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
               @forelse($nucleos as $nucleo)
               <tr>
                  <td>
                     {{ $nucleo->nucleo }}
                  </td>
                  <td>
                     {{ $nucleo->locacion }}
                  </td>
                  <td>
                     {{ $nucleo->estatus }}
                  </td>
                  <td>
                     @can('nucleos.edit')
                        <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal" wire:click="edit({{ $nucleo->id }})">
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
                        No se encontraron resultados de la busqueda "{{$search}}" en la pagina {{$page}}.
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
                        {{ $nucleos->links() }}
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
   <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal" role="dialog" tabindex="-1" wire:ignore.self="">
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
                        Nucleo
                     </label>
                     <input class="form-control @error('nucleo') is-invalid @enderror SoloLetras" maxlength="40" minlength="3" type="text" wire:model="nucleo"/>
                     @error('nucleo')
                     <smal class="text-danger">
                        {{ $message }}
                     </smal>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="">
                        Locación
                     </label>
                     <input class="form-control @error('locacion') is-invalid @enderror SoloLetras" maxlength="150" minlength="3" type="text" wire:model="locacion"/>
                     @error('locacion')
                     <smal class="text-danger">
                        {{ $message }}
                     </smal>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="">
                        Estatus
                     </label>
                     <select class="form-control @error('estatus') is-invalid @enderror" id="" name="" wire:model="estatus">
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
                  <div class="form-group">
                     {{-- @dump ( $permisos_id 	) --}}
                     <label for="">
                        Programas Nacionales de Formación
                     </label>
                     {{-- @dump( $pnfsxnucleo ) --}}
                     <br>
                        @if ($modo == 'ver')
	                  	@forelse($pnfsxnucleo as $pnf)
                        <label class="badge badge-info">
                           {{ $pnf->acronimo }}
                        </label>
                        @empty
                        <smal class="text-muted">
                           el nuecleo "{{ $nucleo }}" no posee PNFs asociados.
                        </smal>
                        @endforelse
                        @else
	                     @forelse($pnfs as $pnf)
                        <label class="badge badge-info">
                           <input autocomplete="off" class="mr-1" id="{{ rand() }}" type="checkbox" value="{{ $pnf->id }}" wire:model="pnfsxnucleo.{{$pnf->id}}"/>
                           {{ $pnf->acronimo }}
                        </label>
                        @empty
	                  	no hay PNFs registrados
	                  	@endforelse
                        @endif
                     </br>
                  </div>
               </div>
               {{-- @endif --}}
            </div>
            <div class="modal-footer">
               <button class="btn btn-secondary" data-dismiss="modal" type="button">
                  Cancelar
               </button>
               @if($modo == 'crear')
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
