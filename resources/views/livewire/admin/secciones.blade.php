<div>
   @include('alertas')
   <div class="card card-outline card-primary">
      <div class="card-header">
         @can('secciones.create')
            <div class="card-tools float-sm-right">
               <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button" wire:click="setTitulo('Nueva Seccion','crear')">
                  Nueva Seccion
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
                     Seccion
                  </th>
                  <th>
                     Turno
                  </th>
                  <th>
                     Cupos
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
               @forelse($secciones as $seccion)
               <tr>
                  <td>
                     {{ $seccion->nombre }}
                  </td>
                  <td>
                     {{ $seccion->turno }}
                  </td>
                  <td>
                     {{ $seccion->cupos }}
                  </td>
                  <td>
                     {{ $seccion->observacion }}
                  </td>
                  <td>
                     @can('secciones.edit')
                        <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal" wire:click="edit({{ $seccion->id }})">
                           <i class="fa fa-edit">
                           </i>
                        </button>
                     @endcan
                     @can('secciones.configurar')
                     <a href="{{ ($seccion->DesAsignaturas->count() > 0)  ? route('panel.secciones.editar_config',['id' => $seccion->id]) : route('panel.secciones.config',['id' => $seccion->id]) }}" class="btn btn-{{($seccion->DesAsignaturas->count() > 0)  ? 'warning' : 'info'}} btn-sm" ><i class="fa fa-cogs">
                        </i> </a>
                     @endcan
                  </td>
               </tr>
               @empty
               <tr>
                  <th class="text-center" colspan="5">
                     <small class="text-muted">
                        @if ($search == '')
                        No hay registro para mostrar.
                     @else
                        No se encontraron resultados de la busqueda "{{$search}}" en la pagina {{$page}}.
                     @endif
                     </small>
                  </th>
               </tr>
               @endforelse
            </tbody>
            <tfoot>
               <tr>
                  <td colspan="5">
                     <div class="float-right">
                        {{ $secciones->links() }}
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
               <div wire:loading.delay="" wire:target="store,update,nucleo_id">
                  <div class="callout callout-info">
                     <h5>
                        Procesando informarción por favor espere...
                     </h5>
                  </div>
               </div>
               {{-- @if ($modo == 'crear') --}}
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="">
                           Nucleo {{ $nucleo_id }}
                        </label>
                        {{-- @forelse ($nucleos as $nucleo)
                         {{ $nucleo->nucleo }}
                         @forelse($nucleo->Pnfs as $p)
                         	{{ $p->nombre }}
                         @empty
                         @endforelse
                         @empty
                         @endforelse --}}
                        <select class="form-control @error('nucleo_id') is-invalid @enderror" id="" name="" wire:model="nucleo_id">
                           <option selected="">
                              seleccione
                           </option>
                           @forelse ($nucleos as $nucleo)
                           <option value="{{ $nucleo->id }}">
                              {{ $nucleo->nucleo }}
                           </option>
                           @empty
                           <option disabled="">
                              No hay nucleos disponibles
                           </option>
                           @endforelse
                        </select>
                         @error('nucleo_id')
                        <smal class="text-danger">
                           {{ $message }}
                        </smal>
                        @enderror
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="">
                           PNF
                        </label>
                        {{-- @dump( $pnfs ) --}}
                        <select class="form-control @error('pnf_id') is-invalid @enderror" id="" name="" wire:model="pnf_id">
                           <option disabled="" selected="">
                              seleccione
                           </option>
                           @if (!is_null($nucleo_id))
                           @forelse ($pnfs as $pnf)
                           <option value="{{ $pnf->id }}">
                              {{ $pnf->nombre }}
                           </option>
                           @empty
                           <option disabled="" selected="">
                              No hay Pnf registrados
                           </option>
                           @endforelse
	                           @endif
                        </select>
                         @error('pnf_id')
                        <smal class="text-danger">
                           {{ $message }}
                        </smal>
                        @enderror
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="">
                           Trayecto
                        </label>
                        <select class="form-control  @error('trayecto_id') is-invalid @enderror" id="" name="" wire:model="trayecto_id">
                            @forelse ($trayectos as $trayecto)
                           <option value="{{ $trayecto->id }}">
                              {{ $trayecto->nombre }}
                           </option>
                           @empty
                           <option disabled="">
                              No hay trayectos registrados
                           </option>
                           @endforelse
                        </select>
                        @error('trayecto_id')
                        <smal class="text-danger">
                           {{ $message }}
                        </smal>
                        @enderror
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="">
                           Plan
                        </label>
                        <select class="form-control @error('plan_id') is-invalid @enderror" id="" name="" wire:model="plan_id">
                        	<option selected="">
                              seleccione
                           </option>
                           @if (!is_null($pnfs))
                           @forelse ($planes as $plan)
                           <option value="{{ $plan->id }}">
                              {{ $plan->codigo }} - {{ $plan->nombre }}
                           </option>
                           @empty
                           <option disabled="" selected="">
                              No hay Planes de estudios Disponibles
                           </option>
                           @endforelse
	                           @endif
                        </select>
                        @error('plan_id')
                        <smal class="text-danger">
                           {{ $message }}
                        </smal>
                        @enderror
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="">
                           Nombre
                        </label>
                        <input class="text-uppercase form-control @error('nombre') is-invalid @enderror" maxlength="40" minlength="2" type="text" wire:model="nombre"/>
                        @error('nombre')
                        <smal class="text-danger">
                           {{ $message }}
                        </smal>
                        @enderror
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="">
                           Turno {{ $turno }}
                        </label>
                        <select class="form-control" id="" name="" wire:model="turno">
                           <option value="MAÑANA">
                              MAÑANA
                           </option>
                           <option value="TARDE">
                              TARDE
                           </option>
                           <option value="NOCHE">
                              NOCHE
                           </option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="">
                           Cupos
                        </label>
                        <input class="form-control @error('cupos') is-invalid @enderror SoloNumeros" maxlength="3" minlength="1" type="text" wire:model="cupos"/>
                        @error('cupos')
                        <smal class="text-danger">
                           {{ $message }}
                        </smal>
                        @enderror
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="">
                           Observación
                        </label>
                        <input class="form-control @error('observacion') is-invalid @enderror SoloLetras" maxlength="40" minlength="2" type="text" wire:model="observacion"/>
                        @error('observacion')
                        <smal class="text-danger">
                           {{ $message }}
                        </smal>
                        @enderror
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="form-group">
                        <label for="">
                           Estatus {{ $estatus }}
                        </label>
                        <select class="form-control @error('estatus') is-invalid @enderror" id="" name="" wire:model="estatus">
                           <option value="ACTIVA">
                              ACTIVA
                           </option>
                           <option value="INACTIVA">
                              INACTIVA
                           </option>
                        </select>
                        @error('estatus')
                        <smal class="text-danger">
                           {{ $message }}
                        </smal>
                        @enderror
                     </div>
                  </div>
               </div>
               {{--
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
               --}}
               {{-- @endif --}}
            </div>
            <div class="modal-footer">
               <button class="btn btn-secondary" data-dismiss="modal" type="button">
                  Cancelar
               </button>
               @if($modo == 'crear')
               <button class="btn btn-primary" type="button" wire:click="store" wire:loading.attr="disabled">
                  Guardar
               </button>
               @elseif($modo == 'editar')
               <button class="btn btn-primary" type="button" wire:click="update" wire:loading.attr="disabled">
                  Actualizar
               </button>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
