<div>
   @if (session('mensaje'))
   <div class="callout callout-success">
      <h5>
         {{ session('mensaje') }}
      </h5>
   </div>
   @endif
   @if (session('error'))
   <div class="callout callout-danger">
      <h5>
         {{ session('error') }}
      </h5>
   </div>
   @endif
   <div class="card card-outline card-primary">
      {{--
      <div class="card-header">
         <div class="card-tools float-sm-right">
            <button class="btn btn-primary" data-target="#exampleModal" data-toggle="modal" type="button" wire:click="setTitulo('Nuevo Nucleo','crear')">
               Nuevo Nucleo
            </button>
         </div>
      </div>
      --}}
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
                     Cédula
                  </th>
                  <th>
                     P. Nombre
                  </th>
                  <th>
                     S. Nombre
                  </th>
                  <th>
                     P. Apellido
                  </th>
                  <th>
                     S. Apellido
                  </th>
                  <th>
                     Acciones
                  </th>
               </tr>
            </thead>
            <tbody>
               @forelse($alumnos as $alumno)
               <tr>
                  <td>
                     {{ $alumno->cedula }}
                  </td>
                  <td>
                     {{ $alumno->p_nombre }}
                  </td>
                  <td>
                     {{ $alumno->s_nombre }}
                  </td>
                  <td>
                     {{ $alumno->p_apellido }}
                  </td>
                  <td>
                     {{ $alumno->s_apellido }}
                  </td>
                  <td>
                     {{--
                     <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal" wire:click="edit({{ $alumno->id }})">
                        <i class="fa fa-edit">
                        </i>
                     </button>
                     --}}
					<a href="{{ route('panel.estudiantes.show', [$alumno]) }}" class="btn btn-primary btn-sm" role="button">
						<i class="fas fa-eye" aria-hidden="true"></i>
					</a>
                  </td>
               </tr>
               @empty
               <tr>
                  <th class="text-center" colspan="6">
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
                  <td colspan="6">
					  {{-- {{ $alumnos->count() }} --}}
                     <div class="float-right">
                        {{ $alumnos->links() }}
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
</div>
