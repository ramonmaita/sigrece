@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Estudiantes
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
               Estudiantes
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')

	<livewire:admin.alumnos.table model="App\Models\Alumno"
	with="pnf"
	sort="cedula|asc"
	{{-- include="id, motivo, solicitante.nombre|User" --}}
	searchable="cedula, p_nombre, s_nombre, p_apellido, s_apellido, pnf.nombre"

	{{-- hideable="select" --}}
	 />

      {{-- @livewire('admin.alumnos') --}}


@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
   window.livewire.on('cerrar_modal', () => {
        $('#exampleModal').modal('hide');
    });
</script>
@stop
