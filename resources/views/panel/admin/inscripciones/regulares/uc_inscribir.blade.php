@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Inscribir
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
               <a href="{{ route('panel.inscripciones.regulares.index') }}">
                  Inscripciones de Estudiantes Regulares
               </a>
            </li>
            <li class="breadcrumb-item active">
               Inscribir
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
			<h5 class="tritle">{{ $alumno->cedula }} {{ $alumno->nombres }} {{ $alumno->apellidos }}</h5>
		</div>
		{{-- @dump($uc_acursar) --}}
		<div class="card-body">
			<div class="row">
				<div class="col-md-12 table-responsive">
					<form action="{{ route('panel.inscripciones.regulares.store') }}" method="post">
						@method('POST')
						@csrf
						<input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
						<table class="table table-striped table-hover">
							<thead class="thead-inverse">
								<tr>
									<th>N°</th>
									<th>{{ $alumno->Plan->cohorte }}</th>
									<th>UC</th>
									<th>Seccón</th>
								</tr>
							</thead>
							<tbody>
								@php
									$n = 1;
									$trayecto = 0;
								@endphp
								@forelse ($uc_acursar as $key => $asignatura)
									@php
										$u_periodo_asignatura = $alumno->ultimo_periodo($asignatura->codigo);
										$notas =  $alumno->Notas($asignatura->codigo , @$u_periodo_asignatura->nro_periodo)->sum('nota');
										$nota_final = round($notas / count($asignatura->DesAsignaturas));
										if($alumno->tipo == 10) {
											$aprueba = 10;
										}else{
											$aprueba = ($asignatura->aprueba == 1) ? 16 : 12;
										}

									@endphp
									@if ($nota_final <= $aprueba)
										@if ($trayecto != $asignatura->trayecto_id)

										<tr>
											<th colspan="3" align="center" class="text-center">
												{{ $asignatura->Trayecto->observacion }}
											</th>
											<td>
												{{-- <div class="form-group"> --}}
													<select class="form-control form-control-sm" name="seccion[{{$asignatura->trayecto_id}}]" id="">
														@forelse ($asignatura->RelacionSeccionDocente() as $relacion)
														@if ( @$relacion->Seccion->cupos > 0)

														<option value="{{ @$relacion->Seccion->id }}">{{ @$relacion->Seccion->nombre }}</option>
														@endif
														  {{-- @foreach ($relacion->Seccion as $seccion)
														  @endforeach --}}
														  @empty
														  <option selected disabled>NO HAY SECCIONES DISPONIBLES</option>
														@endforelse
													</select>
												  {{-- </div> --}}
											</td>
										</tr>
										@endif
										<tr  class="bg-{{ (count($asignatura->RelacionSeccionDocente()) <= 0) ? 'gray' : 'primary' }}">
											<td scope="row">{{ $n++ }}</td>
											<td>{{ @$asignatura->Trayecto->nombre }}</td>
											<td>{{ @$asignatura->nombre }}</td>
											<td>
												{{-- {{ $asignatura->DesAsignaturas->pluck('id') }} --}}
												{{-- {{ $asignatura->RelacionSeccionDocente() }} --}}
												{{-- <div class="form-group">
												  <select class="form-control form-control-sm" name="" id="">
													  @foreach ($asignatura->RelacionSeccionDocente() as $relacion)
														@foreach ($relacion->Seccion as $seccion)
															<option>{{ $seccion->nombre }}</option>
														@endforeach
													  @endforeach
												  </select>
												</div> --}}
												<label class="form-check-label" for="{{ $asignatura->codigo }}" style="cursor:pointer">
													<input class="form-check-input check-asignatura" type="checkbox" name="uc_a_inscribir[{{$asignatura->trayecto_id}}][]" id="{{ $asignatura->codigo }}" value="{{ $asignatura->id }}" {{ (count($asignatura->RelacionSeccionDocente()) <= 0) ? 'disabled' : 'checked' }}> INSCRIBIR
												</label>
											</td>
										</tr>
										@if ($alumno->Plan->observacion != 'ANUAL')
											<tr>
												<td colspan="4" style="margin: 0px; padding:0px;">
													<table class="table table-striped">

														<tbody>
															@foreach ($asignatura->DesAsignaturas as $key => $desasignatura)
																<tr class="bg-lightblue">
																	<td><b>{{ $asignatura->Plan->cohorte }}</b> {{ $desasignatura->tri_semestre }}</td>
																	<td>{{ $desasignatura->nombre }}</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												</td>
											</tr>
										@endif
										@php
											$trayecto = $asignatura->trayecto_id;
										@endphp
									@endif
								@empty
									@php
										$ocultar = true;
									@endphp
									<tr>
										<td colspan="4" class="text-center">
											No hay Unidades Curriculares Por Inscribir
										</td>
									</tr>
								@endforelse

							</tbody>
						</table>
						<div class="row">
							<div class="col-md-6">
								<a href="{{ url()->previous() }}" role="button" class="btn btn-dark">ATRAS</a>
							</div>
							<div class="text-right col-md-6">
								@if(!isset($ocultar))
									<button type="submit" class="btn btn-primary">
										INSCRIBIR
									</button>
								@endif
							</div>
						</div>
					</form>
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

		$(document).on('click','.check-asignatura', function() {
			var id = $(this).attr('id');
			if ( $("#"+id).prop('checked') == false) {
				$(this).parent().parent().parent().removeClass('bg-primary');
				$(this).parent().parent().parent().addClass('bg-gray');
			}else{
				$(this).parent().parent().parent().removeClass('bg-gray');
				$(this).parent().parent().parent().addClass('bg-primary');
			}
			// console.log($("#"+id).prop('checked'))
			// console.log(id)
			// console.log($(this))
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
