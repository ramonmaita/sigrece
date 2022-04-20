@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="row mb-2">
      <div class="col-sm-6">
         <h1>
            Docentes
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
				<a href="{{ route('panel.docentes.index') }}">
               		Docentes
				</a>
            </li>
			<li  class="breadcrumb-item active">
				{{ $docente->nacionalidad }}-{{ $docente->cedula }} {{ $docente->nombres }} {{ $docente->apellidos }} - Secciones
			</li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')

<div class="card card-outline card-primary">
	<div class="card-header">
		{{ $docente->nacionalidad }}-{{ $docente->cedula }} {{ $docente->nombres }} {{ $docente->apellidos }}
	</div>
	<div class="card-body  table-responsive">
		{{-- {{ $secciones }} --}}
		{{-- @dump($secciones) --}}
		<table id="example" class="table">
			<thead>
				<tr>
					<th data-priority="1">Sección</th>
					<th data-priority="2">Nucleo</th>
					<th data-priority="3">Unidad Curricular</th>
					<th data-priority="4">Trayecto</th>
					<th data-priority="5">Acciones</th>
				</tr>
			</thead>
			<tbody>
				{{-- @dump($secciones) --}}
				@forelse($secciones as $seccion)
					<tr>
						<td>{{ $seccion->seccion }}</td>
						<td>{{ $seccion->nucleo }}</td>
						<td>{{ $seccion->nombre }}</td>
						<td>{{ $seccion->trayecto }}</td>
						<td>
							<a href="{{ route('panel.docentes.show_uc',[$seccion->docente_id,$seccion->seccion_id,$seccion->asignatura_id]) }}" role="button" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
						</td>
					</tr>
				@empty

				@endforelse
			</tbody>

		</table>

	</div>
	<!-- /.card-body -->
</div>

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
