@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Eventos
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
               Asignados Opsu
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
				{{-- <a class="btn btn-primary" href="{{ route('panel.eventos.create') }}" role="button">
					Nuevo Evento
				</a> --}}
				@livewire('admin.eventos.create')
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
						{{-- @foreach ($eventos as $evento)
							<tr>
								<td scope="row">{{ $evento->periodo }}</td>
								<td>{{$evento->Solicitante->cedula }}</td>
								<td>{{$evento->Solicitante->nombre }} {{$evento->Solicitante->apellido }}</td>
								<td>
									<a class="btn btn-primary" href="{{ route('panel.eventos.show', [$evento]) }}" role="button">
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
<script type="text/javascript">
	$(".select2").select2({});
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
