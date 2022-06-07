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
               Eventos
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')

	@include('alertas')
	@livewire('admin.alertas')
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
			<livewire:admin.eventos.table model="App\Models\Evento" with="periodo">
		</div>
		@livewire('admin.eventos.edit')
	</div>
@stop

@section('css')

@stop

@push('js')
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
	$(".select2-usuarios").select2({});
   window.livewire.on('cerrar_modal', (modal) => {
        $(modal).modal('hide');
    });
   window.livewire.on('abrir_modal', (modal) => {
        $(modal).modal('show');
    });
	window.livewire.on('open_modal_confirm', () => {
        $('#modalConfirm').modal('show');
    });
	window.livewire.on('close_modal_confirm', () => {
        $('#modalConfirm').modal('hide');
    });
</script>


@endpush
