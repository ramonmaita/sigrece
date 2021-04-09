@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>
                    {{ $seccion->nombre }}
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
                        {{ $seccion->nombre }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')

	@include('alertas')
    <div class="card card-primary card-outline">
		{{-- @dump($seccion->Docentes) --}}

        <div class="card-body table-responsive">
            <table class="table table-striped table-inverse " id="table-uc">
                <thead class="thead-inverse">
                    <tr>
                        <th data-priority="2">{{ $seccion->Plan->cohorte }}</th>
                        <th data-priority="3">UC-ANUAL</th>
                        <th data-priority="1">UC</th>
                        <th data-priority="4">Docente</th>
                        {{-- <th data-priority="5">Estatus</th> --}}
                        <th data-priority="6">Acciones</th>
                    </tr>
                </thead>
                <tbody>
					@forelse ($seccion->DesAsignaturas as $key => $desasignatura)
						<tr>
							<td>{{ $desasignatura->tri_semestre }}</td>
							<td>{{ $desasignatura->Asignatura->nombre }}</td>
							<td>{{ $desasignatura->nombre }}</td>
							<td>{{ $seccion->Docentes[$key]->nacionalidad }}-{{ $seccion->Docentes[$key]->cedula }} {{ $seccion->Docentes[$key]->nombres }} {{ $seccion->Docentes[$key]->apellidos }}</td>
							{{-- <td></td> --}}
							<td>
								<a href="{{ route('panel.secciones.lista_estudiantes', ['seccion' => $seccion, 'desasignatura' => $desasignatura->id]) }}" class="btn btn-info">
									<i class="fa fa-list-ol" aria-hidden="true"></i>
								</a>
							</td>
						</tr>
					@empty

					@endforelse
					{{-- @forelse ($seccion as $uc)
						<tr>
							<td scope="row">{{ @$uc->DesAsignatura->tri_semestre }}</td>
                            <td>{{ $uc->Asignatura->nombre }}</td>
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
                                @can('secciones.asignar-docente')
                                    @if ($uc->estatus == 0)
        								<button class="btn btn-sm btn-warning" disabled role="button">
        									<i class="fas fa-user-edit "></i>
        								</button>
                                    @else
                                        <a class="btn btn-sm btn-warning" href="{{ route('panel.secciones.asignar-docente',['seccion' => $uc->seccion, 'periodo' => $uc->periodo, 'pnf' => $uc->especialidad, 'desasignatura' => $uc->cod_desasignatura]) }}" role="button">
                                            <i class="fas fa-user-edit "></i>
                                        </a>
                                    @endif
                                @endcan

                                @can('secciones.listado-estudiante')
    								<a class="btn btn-sm btn-info" href="{{ route('panel.secciones.listado-estudiantes',['seccion' => $uc]) }}" role="button">
    									<i class="fas fa-eye "></i>
    								</a>
                                @endcan


                                @if ($uc->estatus == 0)
                                <a class="btn btn-sm btn-danger" href="{{ route('panel.secciones.acta',[$uc]) }}" role="button" target="_blank">
                                    <i class="far fa-file-pdf "></i>
                                </a>
                                @else
                                <button class="btn btn-sm btn-danger"  disabled role="button">
                                    <i class="far fa-file-pdf "></i>
                                </button>
                                @endif
							</td>
						</tr>
					@empty

					@endforelse --}}
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
