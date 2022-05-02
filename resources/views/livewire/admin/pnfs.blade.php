<div>
   @include('alertas')
   <div class="card card-outline card-primary">
      <div class="card-header">
         @can('pnfs.create')
            <div class="card-tools float-sm-right">
               <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button" wire:click="setTitulo('Nuevo PNF','crear')">
                  Nuevo PNF
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
                     Código
                  </th>
                  <th>
                     Acronimo
                  </th>
                  <th>
                     Nombre
                  </th>
                  <th>
                     Observacion
                  </th>
                  <th>
                     Acciones
                  </th>
               </tr>
            </thead>
            <tbody>
               @forelse($pnfs as $pnf)
               <tr>
                  <td>
                     {{ $pnf->codigo }}
                  </td>
                  <td>
                     {{ $pnf->acronimo }}
                  </td>
                  <td>
                     {{ $pnf->nombre }}
                  </td>
                  <td>
                     {{ $pnf->observacion }}
                  </td>
                  <td>
                     @can('pnfs.edit')
                        <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal" wire:click="edit({{ $pnf->id }})">
                           <i class="fa fa-edit">
                           </i>
                        </button>
                     @endcan
					 <a class="btn btn-warning btn-sm" type="button" role="button" target="_blank" href="{{ route('panel.secciones.planificacion',[$pnf->id]) }}">
					   <i class="fa fa-file">
					   </i>
					@can('secciones.cerrar_carga')
					<a class="btn btn-danger btn-sm" type="button" role="button" href="{{ route('panel.secciones.cerrar_carga',[$pnf->id]) }}">
						<i class="fas fa-eye">
						</i>
					@endcan
                  </td>
				 </a>
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
                        {{ $pnfs->links() }}
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
                        Código
                     </label>
                     <input class="form-control @error('codigo') is-invalid @enderror SoloNumeros" maxlength="4" minlength="2" type="text" wire:model="codigo"/>
                     @error('codigo')
                     <smal class="text-danger">
                        {{ $message }}
                     </smal>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="">
                        Nombre
                     </label>
                     <input class="form-control @error('nombre') is-invalid @enderror SoloLetras" maxlength="20" minlength="6" type="text" wire:model="nombre"/>
                     @error('nombre')
                     <smal class="text-danger">
                        {{ $message }}
                     </smal>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="">
                        Acronimo
                     </label>
                     <input class="form-control @error('acronimo') is-invalid @enderror SoloLetras" maxlength="20" minlength="6" type="text" wire:model="acronimo"/>
                     @error('acronimo')
                     <smal class="text-danger">
                        {{ $message }}
                     </smal>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="">
                        Observacion
                     </label>
                     <input class="form-control @error('observacion') is-invalid @enderror SoloLetras" maxlength="150" type="text" wire:model="observacion"/>
                     @error('observacion')
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
