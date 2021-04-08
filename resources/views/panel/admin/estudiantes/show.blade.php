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
			<li class="breadcrumb-item">
				<a href="{{ route('panel.estudiantes.index') }}">
					Estudiantes
				</a>
			 </li>
            <li class="breadcrumb-item active">
                {{ $alumno->nombres }} {{ $alumno->apellidos }}
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')

      @livewire('admin.alumnos.show-alumno',['alumno' => $alumno,'trayectos' => $trayectos])


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
