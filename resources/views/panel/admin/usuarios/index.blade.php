@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>Usuarios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('panel.usuarios.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')


    @livewire('admin.usuarios')
    <!-- /.card -->
@stop

@section('css')

@stop

@section('js')
	<script>
		$('#select2-docente').select2();
	</script>
@endsection
{{-- @section('js')
<script type="text/javascript">
	window.livewire.on('select2', () => {
		$('.select2').select2({});
	 });
 </script>
<script>
	$(function () {


		$('.select2').select2({});
		$(".select-alumno").hide();
		$(".select-usuario").hide();
		$(".select-docente").hide();
		$("#tipo").change(function (e) {
			e.preventDefault();
			if($(this).val() == 'DOCENTE'){
				$(".select-docente").show();
				$(".select-alumno").hide();
				$(".select-usuario").hide();
			}else if($(this).val() == 'USUARIO'){
				$(".select-usuario").show();
				$(".select-docente").hide();
				$(".select-alumno").hide();
			}else if($(this).val() == 'ALUMNO'){
				$(".select-alumno").show();
				$(".select-usuario").hide();
				$(".select-docente").hide();
			}else{
				$(".select-alumno").hide();
				$(".select-usuario").hide();
				$(".select-docente").hide();
			}
		});
	});
</script>
@stop --}}
