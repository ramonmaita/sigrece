@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Cambios
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
               Cambios
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')
	@include('alertas')
	<div class="card card-primary card-outline">
		<div class="card-header">
			<div class="float-right">
				<a class="btn btn-primary" href="{{ route('panel.cambios.create') }}" role="button">
					Nueva Solicitud
				</a>
			</div>
		</div>
		<div class="card-body table-responsive">
			<table class="table table-striped table-inverse datatables">
				<thead class="thead-inverse">
					<tr>
						<th data-priority="3">Periodo</th>
						<th data-priority="1">Cedula</th>
						<th data-priority="2">Nombres y Apellidos</th>
						<th data-priority="4">Acciones</th>
					</tr>
					</thead>
					<tbody>
						{{-- @foreach ($retiros as $retiro)
							<tr>
								<td scope="row">{{ $retiro->periodo }}</td>
								<td>{{$retiro->Solicitante->cedula }}</td>
								<td>{{$retiro->Solicitante->nombre }} {{$retiro->Solicitante->apellido }}</td>
								<td>
									<a class="btn btn-primary" href="{{ route('panel.retiros.show', [$retiro]) }}" role="button">
										<i class="fas fa-eye"></i>
									</a>
								</td>
							</tr>
						@endforeach --}}
					</tbody>
			</table>
		</div>
	</div>
@stop

@section('css')

@stop

@section('js')
<script>
	$(document).ready(function() {

		var table = $('.datatables').DataTable( {
				responsive: true,
				// buttons: [
				// 	'copy', 'excel', 'pdf'
				// ],
				language: {
					url: '{{ asset('datatables/es.json') }}'
				}
			} )
			.columns.adjust()
			.responsive.recalc();
	} );

</script>
@stop
