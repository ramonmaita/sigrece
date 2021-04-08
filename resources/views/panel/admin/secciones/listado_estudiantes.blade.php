@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h4>
                    {{ $seccion->first()->DesAsignatura->nombre }}
                </h4>
				<p>
					Listado de Estudiantes
				</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('panel.index') }}">
                            Inicio
                        </a>
                    </li>
					<li class="breadcrumb-item">
                        <a href="{{ route('panel.secciones.lista') }}">
                            Secciones
                        </a>
                    </li>
					<li class="breadcrumb-item">
                        <a
                            href="{{ route('panel.secciones.ver-uc', ['periodo' => $seccion->first()->periodo, 'seccion' => $seccion->first()->seccion, 'pnf' => $seccion->first()->especialidad]) }}">
                            {{ $seccion->first()->seccion }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Listado de Estudiantes
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
                        <th>Cedula</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        {{-- <th>Acciones</th> --}}
                    </tr>
                </thead>
                <tbody>
					@forelse ($seccion as $estudiante)
						<tr>
							<td scope="row">{{ @$estudiante->Alumno->cedula }}</td>
							<td>{{ @$estudiante->Alumno->nombres }}</td>
							<td>{{ @$estudiante->Alumno->apellidos }}</td>

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
@stop
