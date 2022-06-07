@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Solicitudes
         </h1>
      </div>
      <div class="col-sm-6">
         <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
               <a href="{{ route('panel.index') }}">
                  Inicio
               </a>
            </li>
            <li class="breadcrumb-item active">
               Solicitudes
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')

      {{-- @livewire('admin.solicitudes') --}}
	  {{-- <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Inicio</h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header --> --}}
        @include('alertas')
        {{-- <div class="card-body"> --}}
			{{-- <livewire:datatable model="App\Models\SolicitudCorreccion" name="as" /> --}}
			<livewire:admin.solicitudes.correcciones.table model="App\Models\SolicitudCorreccion"
			with="solicitante, desasignatura"
			sort="seccion|asc"
			{{-- include="id, motivo, solicitante.nombre|User" --}}
			searchable="seccion, solicitante.nombre, solicitante.apellido, desasignatura.nombre, estatus_jefe, estatus_admin, fecha"

			{{-- hideable="select" --}}
			exportable />
			{{-- </div>
			<!-- /.card-body -->

		</div> --}}
    <!-- /.card -->


@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
   window.livewire.on('cerrar_modal', () => {
        $('#exampleModal').modal('hide');
    });

	window.livewire.on('open_modal_confirm', () => {
        $('#modalConfirm').modal('show');
    });
	window.livewire.on('close_modal_confirm', () => {
        $('#modalConfirm').modal('hide');
    });
</script>
@stop
