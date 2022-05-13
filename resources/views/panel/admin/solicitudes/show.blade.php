@extends('adminlte::page')



@section('content_header')
<div class="container-fluid">
	<div class="mb-2 row">
	   <div class="col-sm-6">
		  <h1>

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
				<a href="{{ route('panel.usuarios.index') }}">
				   Solicitudes
				</a>
			 </li>
			 <li class="breadcrumb-item active">

			 </li>
		  </ol>
	   </div>
	</div>
 </div>
@stop

@section('content')
@include('alertas')
@livewire('admin.alertas')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Solicitud</h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
			@livewire('admin.solicitudes.show',['solicitud' => $solicitud, 'relacion' => $relacion])
        </div>
        <!-- /.card-body -->

    </div>

@stop

@section('css')

@stop

@push('js')
<script>
	$(function () {
		$('#estatus_jefe').change(function (e) {
			e.preventDefault();
			if($(this).val() == 'APROBADO'){
				$('.estatus_alumno').val('APROBADO');
				$('.estatus_alumno').attr('disabled', 'true');
			}
			if($(this).val() == 'RECHAZADO'){
				$('.estatus_alumno').val('RECHAZADO');
				$('.estatus_alumno').attr('disabled', 'true');
			}
			if($(this).val() == 'PROCESADO'){
				$('.estatus_alumno').val('');
				$('.estatus_alumno').removeAttr('disabled');
			}
		});

		$('.estatus_alumno').change(function (e) {
			e.preventDefault();
			$('#estatus_jefe').val('PROCESADO');
			$('.seleccione').attr('disabled','true');
		});
	});
</script>
@endpush
