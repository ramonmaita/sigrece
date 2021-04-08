@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>
                    Estadisticas: {{ $seccion->first()->seccion }}
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
                        <a href="{{ route('panel.estadisticas.carga-de-notas.index') }}">
                            Control de Carga de Notas
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Estadisticas: {{ $seccion->first()->seccion }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')

	@include('alertas')
    <div class="card card-primary card-outline">
        <div class="card-body table-responsive">
            <table class="table table-striped table-inverse " id="table-uc">
                <thead class="thead-inverse">
                    <tr>
                        <th>Trimestre|Semestre|Año</th>
                        <th>UC</th>
                        <th>Docente</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
					@forelse ($seccion as $uc)
						<tr>
							<td scope="row">{{ @$uc->DesAsignatura->tri_semestre }}</td>
							<td>{{ $uc->nombre_asignatura }}</td>
							<td>{{ $uc->cedula_docente }} {{ $uc->docente }}</td>
							<td>
								<small>
									@if ($uc->estatus == 0)
									CARGADA POR: <b>{{ $uc->estatus_carga($uc->seccion,$uc->periodo,$uc->cod_desasignatura)->User->nombre }}  {{ $uc->estatus_carga($uc->seccion,$uc->periodo,$uc->cod_desasignatura)->User->apellido }} </b> EL <b>{{ \Carbon\Carbon::parse($uc->estatus_carga($uc->seccion,$uc->periodo,$uc->cod_desasignatura)->fecha)->format('d/m/Y h:i:s A') }}</b>
									@else
									POR CARGAR
									@endif
								</small>
							</td>
							<td>
								{{-- {{ route('panel.docente.secciones.acta',[$uc]) }} --}}
								@if ($uc->estatus == 0)
								<a class="btn btn-sm btn-danger" href="{{ route('panel.secciones.acta',[$uc]) }}" role="button" target="_blank">
									<i class="far fa-file-pdf "></i>
								</a>
								@else
								<a class="btn btn-sm btn-danger"  disabled role="button">
									<i class="far fa-file-pdf "></i>
								</a>
								@endif
								{{-- <a class="btn btn-sm btn-warning" href="{{ route('panel.secciones.asignar-docente',['seccion' => $uc->seccion, 'periodo' => $uc->periodo, 'pnf' => $uc->especialidad, 'desasignatura' => $uc->cod_desasignatura]) }}" role="button">
									<i class="fas fa-user-edit "></i>
								</a>

								<a class="btn btn-sm btn-info" href="{{ route('panel.secciones.listado-estudiantes',['seccion' => $uc]) }}" role="button">
									<i class="fas fa-eye "></i>
								</a> --}}
							</td>
						</tr>
					@empty

					@endforelse
                </tbody>
            </table>
        </div>
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
	<script>
		$(document).ready(function() {

			var table = $('#table-uc').DataTable( {
					responsive: true,
					language: {
						url: '{{ asset('datatables/es.json') }}'
					}
				} )
				.columns.adjust()
				.responsive.recalc();
		} );

	</script>
@stop
