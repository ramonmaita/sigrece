@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Documentos Certificados
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
               Documentos Certificados
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')
@include('alertas')

	<div class="card card-primary card-outline">
		<div class="card-body">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<form action="{{ route('panel.documentos.certificados.buscar') }}" method="POST" autocomplete="off">
						@csrf
						@method('POST')
                        <div class="form-group">
                            <label for="">Cédula</label>
                            <input type="text" class="form-control SoloNumeros @error('cedula') is-invalid @enderror" name="cedula" id="" aria-describedby="helpId"
                                placeholder="12345678">
							@error('cedula')
								<small id="helpId" class="form-text text-danger">{{ $message }}</small>
							@enderror
                            <small id="helpId" class="form-text text-muted">Escribir número de cédula sin puntos</small>
                        </div>
                        <div class="form-group">
                            <input name="" id="" class="btn btn-primary btn-block" type="submit" value="Buscar">
                        </div>
                    </form>
					{{-- <form action="{{ route('panel.inscripciones.ciu.uc') }}" method="post" >
						@csrf
						@method('POST')
						<div class="form-group">
							  <label for="">Estudiante</label>
							<select name="estudiante" class="form-control" id="select-ci-estudiante">
							</select>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block">
								BUSCAR
							</button>
						</div>
					</form> --}}
				</div>
			</div>
		</div>
	</div>


@stop

@section('css')

@stop

@section('js')

<script>
	$(function () {
		$.fn.select2.defaults.set('language', 'es');
		$('#select-ci-estudiante').select2({
            // tags: true,
            // tokenSeparators: [','],
			minimumInputLength: 2,
			language: "es",
            ajax: {
                dataType: 'json',
                url: '{{ route('panel.inscripciones.regulares.data') }}',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function (data, page) {
                  return {
                    results: data
                  };
                },
				cache: true
            }
        });
		// $('#select-ci-estudiante').select2({
		// 	placeholder: 'Selecciona una categoría',
		// 	ajax: {
		// 	url: "{{ route('panel.inscripciones.regulares.data') }}",
		// 	dataType: 'json',
		// 	delay: 250,
		// 	processResults: function (data) {
		// 		return {
		// 		results: data
		// 		};
		// 	},
		// 	cache: true
		// 	}
		// });
	});
</script>
<script type="text/javascript">
   window.livewire.on('cerrar_modal', () => {
        $('#exampleModal').modal('hide');
    });
</script>
@stop
