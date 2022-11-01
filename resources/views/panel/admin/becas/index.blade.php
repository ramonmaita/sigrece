@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Becados
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
               Becados
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')
	@include('alertas')
	<div class="card">
		<div class="card-header">
			@can('becas.create')
				<div class="card-tools float-sm-right">
					<a href="{{ route('panel.estudiantes.becas.create') }}" class="btn btn-primary">
						Añadir Estudiante
					</a>
				</div>
			@endcan
		</div>
		<div class="card-body">
			<livewire:admin.becas.table model="App\Models\Alumno"
				with="pnf"
				with="alumno"
				sort="cedula|asc"
				/>
		</div>
	</div>


@stop

@section('js')
<script type="text/javascript">
   window.livewire.on('cerrar_modal', () => {
        $('#exampleModal').modal('hide');
    });
</script>
@stop
