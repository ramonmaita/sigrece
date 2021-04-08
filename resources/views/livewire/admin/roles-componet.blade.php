<div>
   @include('alertas')
   <div class="card card-outline card-primary">
      <div class="card-header">
         <div class="row">
            <div class="col-sm-8">
               <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  @can('roles.index')
                  <li class="nav-item">
                     <a aria-controls="custom-tabs-three-home" aria-selected="true" class="nav-link {{ ($vista=='roles') ? 'active' : ''}}" data-toggle="pill" href="#custom-tabs-three-home" id="custom-tabs-three-home-tab" role="tab" wire:click="setVista('roles')">
                        Roles
                     </a>
                  </li>
                  @endcan
                  @can('permisos.index')
                  <li class="nav-item">
                     <a aria-controls="custom-tabs-three-profile" aria-selected="false" class="nav-link {{ ($vista=='permisos') ? 'active' : ''}}" data-toggle="pill" href="#custom-tabs-three-profile" id="custom-tabs-three-profile-tab" role="tab" wire:click="setVista('permisos')">
                        Permisos
                     </a>
                  </li>
                  @endcan
               </ul>
            </div>
            <div class="col-sm-4">
               <div class="card-tools float-sm-right">
                  @can('roles.create')
                     @if ($vista=="roles")
                     <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" data-whatever="Crear Nuevo Rol" type="button" wire:click="setTitulo('Crear Nuevo Rol','crear')">
                        Crear Nuevo Rol
                     </button>
                     @endif
                  @endcan

                  @can('permisos.create')
   						@if ($vista=="permisos")
                     <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" data-whatever="Crear Nuevo Permiso" type="button" wire:click="setTitulo('Crear Nuevo Permiso','crear')">
                        Crear Nuevo Permiso
                     </button>
                     @endif
                  @endcan
               </div>
            </div>
         </div>
      </div>
      <div class="card-body table-responsive">
         <div class="card-tools float-right mb-2 ">
            <div class="input-group input-group-sm" style="width: 200px;">
               <input class="form-control float-right" placeholder="Buscar en {{ $vista }}" type="text" wire:model="search"/>
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
         <div class="tab-content" id="custom-tabs-three-tabContent">
            @can('roles.index')
            <div aria-labelledby="custom-tabs-three-home-tab" class="tab-pane fade {{ ($vista == 'roles') ? 'active show' : '' }} " id="custom-tabs-three-home" role="tabpanel">
               <table class="table table-hove table-striped">
                  <thead>
                     <tr>
                        <th>
                           Rol
                        </th>
                        <th>
                           Acciones
									{{-- {{ $vista }} --}}
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse ($roles as $rol)
                     <tr>
                        <td>
                           {{ $rol->name }}
                        </td>
                        <td>
                           @can('roles.show')
                              <button class="btn btn-info btn-sm" data-target="#exampleModal" data-toggle="modal" wire:click="show({{ $rol->id }})">
                                 <i class="fa fa-eye">
                                 </i>
                              </button>
                           @endcan

                           @can('roles.edit')
                           <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal" wire:click="edit({{ $rol->id }})">
                              <i class="fa fa-edit">
                              </i>
                           </button>
                           @endcan
                        </td>
                     </tr>
                     @empty
                     <tr>
                        <th colspan="2">
                           No se encontraron resultados de la busqueda "{{$search}}" en la pagina {{$page}}
                        </th>
                     </tr>
                     @endforelse
                  </tbody>
               </table>
               <div class="float-right">
                  {{ $roles->links() }}
               </div>
            </div>
            @endcan
            @can('permisos.index')
            <div aria-labelledby="custom-tabs-three-profile-tab" class="tab-pane fade {{ ($vista == 'permisos') ? 'active show' : '' }}" id="custom-tabs-three-profile" role="tabpanel">
               <table class="table table-hove table-striped">
                  <thead>
                     <tr>
                        <th>
                           Permiso
                        </th>
                        <th>
                           Acciones
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse ($permisos as $permiso)
                     <tr>
                        <td>
                           {{ $permiso->name }}
                        </td>
                        <td>
                           @can('permisos.edit')
                              <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal" wire:click="edit({{ $permiso->id }})">
                                 <i class="fa fa-edit">
                                 </i>
                              </button>
                           @endcan
                        </td>
                     </tr>
                     @empty
                     <tr>
                        <th colspan="2">
                           No se encontraron resultados de la busqueda "{{$search}}" en la pagina {{$page}}
                        </th>
                     </tr>
                     @endforelse
                  </tbody>
               </table>
               <div class="float-right">
                  {{ $permisos->links() }}
               </div>
            </div>
            @endcan
         </div>
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
               @if ($vista == 'roles')
               <div>
                  <div class="form-group">
                     <label for="">
                        Nombre
                     </label>
                     @if ($modo != 'ver')
                     <input class="form-control @error('nombre') is-invalid @enderror" type="text" wire:model="nombre"/>
                     @error('nombre')
                     <smal class="text-danger">
                        {{ $message }}
                     </smal>
                     @enderror
	                  @else
                     <p class="form-control">
                        {{ $nombre }}
                     </p>
                     @endif
                  </div>
                  <div class="form-group">
                     {{-- @dump ( $permisos_id 	) --}}
                     <label for="">
                        Permisos
                     </label>
                     <br>
                        @if ($modo == 'ver')
	                  	@forelse($permisos_id as $permiso)
                        <label class="badge badge-info">
                           {{ $permiso->name }}
                        </label>
                        @empty
                        <smal class="text-muted">
                           el rol "{{ $nombre }}" no posee permisos asociados.
                        </smal>
                        @endforelse
                        @else
	                     @forelse($permissions as $permiso)
                        <label class="badge badge-info">
                           <input autocomplete="off" class="mr-1" id="{{ rand() }}" type="checkbox" value="{{ $permiso->id }}" wire:model="permisos_id.{{$permiso->id}}"/>
                           {{ $permiso->name }}
                        </label>
                        @empty
	                  	no hay permisos registrados
	                  	@endforelse
                        @endif
                     </br>
                  </div>
               </div>
               @endif

               @if($vista == 'permisos')
               <div>
                  <div class="form-group">
                     <label for="">
                        Nombre
                     </label>
                     @if ($modo != 'ver')
                     <input class="form-control @error('nombre') is-invalid @enderror" type="text" wire:model="nombre"/>
                     @error('nombre')
                     <smal class="text-danger">
                        {{ $message }}
                     </smal>
                     @enderror
	                  @else
                     <p class="form-control">
                        {{ $nombre }}
                     </p>
                     @endif
                  </div>
               </div>
               @endif
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
