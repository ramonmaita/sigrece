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
                        <a href="{{ route('panel.secciones.index') }}">
                            Secciones
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
	<div class="small-box bg-warning">
		<div class="icon">
		  <i class="fas fa-users"></i>
		</div>
	  </div>
    <div class="card card-primary card-outline">
		{{-- @dump($seccion->Docentes) --}}
        <div class="card-body table-responsive">
            <table class="table table-striped table-inverse " id="table-uc">
                <thead class="thead-inverse">
                    <tr>
                        <th data-priority="3">Trayecto</th>
                        <th data-priority="1">Seccion</th>
                        <th data-priority="4">Año|Semestre|Trimestre</th>
						<th>UC</th>
						<th>Docente</th>
						<th>Estatus</th>
                        {{-- <th data-priority="5">Estatus</th> --}}
                        <th data-priority="6">Acciones</th>
                    </tr>
                </thead>
                <tbody>

					@foreach ($pnf->Secciones->where('estatus','ACTIVA') as $seccion)

						@foreach ($seccion->DesAsignaturas->sortBy('tri_semestre') as $uc)
							@if(!$uc->estatus_carga($seccion->nombre,$seccion->Periodo->nombre))
								<tr>
									<td>
										{{ $seccion->Trayecto->nombre }}
									</td>
									<td align="center">
										{{ $seccion->nombre }}
									</td>
									<td>
										{{ $uc->tri_semestre }}
									</td>
									<td>
										{{ $uc->nombre }}
									</td>
									<td>
										{{ $seccion->ConsultarDocente($uc->pivot->docente_id,$uc->id)->Docente->nombre_completo }}
									</td>
									<td>
										@if($uc->estatus_carga($seccion->nombre,$seccion->Periodo->nombre))
											<span style="color:green"> CARGADA POR: <b>{{ $uc->estatus_carga($seccion->nombre,$seccion->Periodo->nombre)->User->nombre }} {{ $uc->estatus_carga($seccion->nombre,$seccion->Periodo->nombre)->User->apellido }} </b></span>

										@elseif( $seccion->Docente($uc->id)->NotasActividades()->count() > 0)
											<b style="color:blue">POR CERRAR</b>
										@else
											<b style="color:red">POR CARGAR</b>
										@endif
									</td>
									<td align="center">
										@if( $seccion->Docente($uc->id)->NotasActividades()->count() > 0)
										<a target="_blank"
											href="{{ route('panel.docente.secciones.gestion.avance', [$uc->pivot->id]) }}" type='button'
											class=" btn btn-primary">
											<i class="far fa-file-excel" aria-hidden="true"></i>
										</a>
										@endif
										{{-- <a
											href="{{ route('panel.secciones.cerrar', [$uc->pivot->id]) }}" type='button'
											class=" btn btn-danger">
											<i class="fas fa-ban    "></i>
										</a> --}}

										<button class="confirmar btn btn-danger" data-ruta="{{ route('panel.secciones.cerrar', [$uc->pivot->id]) }}">
											<i class="fas fa-ban    "></i>
										</button>
									</td>
								</tr>
							@endif
						@endforeach
				@endforeach
                </tbody>

            </table>


        </div>
    </div>

@stop

@section('css')
	<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.4/css/rowGroup.bootstrap.min.css">
@stop

@section('js')
    <script type="text/javascript">
        window.livewire.on('cerrar_modal', () => {
            $('#exampleModal').modal('hide');
        });

    </script>
	<script src="https://cdn.datatables.net/rowgroup/1.1.4/js/dataTables.rowGroup.min.js"></script>
	<script>
		$(document).ready(function() {

			$('.confirmar').click(function (e) {
				e.preventDefault();
				Swal
			.fire({
				title: "CERRAR CARGA",
				text: "¿Esta seguro?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: "Sí, cerrar",
				cancelButtonText: "Cancelar",
			})
			.then(resultado => {
				if (resultado.value) {
					// Hicieron click en "Sí"

					// Swal.fire({
					// 	title: 'Escriba su contraseña',
					// 	input: 'text',
					// 	inputAttributes: {
					// 		autocapitalize: 'off'
					// 	},
					// 	showCancelButton: true,
					// 	confirmButtonText: 'Confirmar',
					// 	cancelButtonText: "Cancelar",
					// 	showLoaderOnConfirm: true,
					// 	preConfirm: (valor) => {
					// 		var route = $(this).data('ruta');
					// 		console.log(route+'/'+valor)
					// 		return fetch(route+'/'+valor)
					// 		// return fetch(`//api.github.com/users/${login}`)
					// 		.then(response => {
					// 			if (!response.ok) {
					// 			throw new Error(response.statusText)
					// 			}
					// 			return response.json()
					// 		})
					// 		.catch(error => {
					// 			Swal.showValidationMessage(
					// 			`Request failed: ${error}`
					// 			)
					// 		})
					// 	},
					// 	allowOutsideClick: () => !Swal.isLoading()
					// 	}).then((result) => {
					// 		console.log(result.isConfirmed)
					// 	if (result.isConfirmed) {
					// 		Swal.fire({
					// 		title: `${result.value.login}'s avatar`,
					// 		imageUrl: result.value.avatar_url
					// 		})
					// 	}
					// })

					window.location.href = $(this).data('ruta')
					console.log("*se elimina la venta*");
				} else {
					// Dijeron que no
					console.log("*NO se elimina la venta*");
				}
			});
			});
			var table = $('#table-uc').DataTable( {
					responsive: true,
					order: [[1, 'asc']],
					rowGroup: {
						dataSrc: 1,
						startClassName: 'text-center',
						className: 'bg-success '
					},
					language: {
						url: '{{ asset('datatables/es.json') }}'
					}
				} )
				.columns.adjust()
				.responsive.recalc();
		} );

	</script>
@stop
