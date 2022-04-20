@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Solicitud de Corrección
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
               <a href="{{ route('panel.correcciones.index') }}">
					Correcciones
               </a>
            </li>
            <li class="breadcrumb-item active">
               Solicitud de Corrección
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')

    @livewire('admin.correcciones.create')

@stop

@section('css')

@stop

@section('js')
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
