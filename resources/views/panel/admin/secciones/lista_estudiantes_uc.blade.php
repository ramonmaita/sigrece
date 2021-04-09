@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h4>
                    {{ $desasignatura->nombre }}  {{ $desasignatura->Asignatura->Plan->cohorte }}:  {{ $desasignatura->tri_semestre }}
                </h4>
				<p style="margin: 2px !important;">
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
                            href="{{ route('panel.secciones.show', ['seccion' => $seccion]) }}">
                            {{ $seccion->nombre }}
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
		{{-- @dump($relacion) --}}
        <div class="card-body table-responsive">
			<span id="title" class="hidden" style="display: none;">

				{!! $nombre_archivo = $seccion->nombre.' <br> '.$desasignatura->nombre .'('.$desasignatura->tri_semestre.')'.' <br> '.$relacion->Docente->nombres .' '.$relacion->Docente->apellidos !!}
			</span>
            <table class="table table-striped table-inverse " id="table-uc">
                <thead class="thead-inverse">
                    <tr>
                        <th>Cedula</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Aprueba con:</th>
                    </tr>
                </thead>
                <tbody>
					@forelse ($relacion->Inscritos as $inscritos)
						<tr>
							<td scope="row">{{ $inscritos->Alumno->nacionalidad }}-{{ $inscritos->Alumno->cedula }}</td>
							<td>{{ $inscritos->Alumno->nombres}}</td>
							<td>{{ $inscritos->Alumno->apellidos }}</td>
							<td>
								@if($desasignatura->Asignatura->apueba == 1)
									{{ ($inscritos->Alumno->tipo == 10) ? 10 : 16 }}
								@else
									{{ ($inscritos->Alumno->tipo == 10) ? 12 : $inscritos->Alumno->tipo }}
								@endif
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
	  <!-- DataTables -->
	  {{-- <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}
@stop

@section('js')
	{{-- <script src="https://adminlte.io/themes/v3/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/jszip/jszip.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}
	<script>
		$(document).ready(function() {

			var table = $('#table-uc').DataTable( {
					responsive: true,
					language: {
						url: '{{ asset('datatables/es.json') }}'
					},
					dom: 'Bfrtip',
					buttons: [
						// 'copy', 'csv', 'excel', 'pdf', 'print'}
						{
							extend: 'copy',
							title: $('#title').text(),
						},
						{
							extend: 'csv',
							filename: function () { return $('#title').text()},
							title: $('#title').text(),
						},
						{
							extend: 'excel',
							filename: function () { return $('#title').text()},
							title: $('#title').text(),
						},
						{
							extend: 'pdf',
							filename: function () { return $('#title').text()},
							title: $('#title').text(),
							customize: function (doc) {
								doc.content[1].table.widths =
									Array(doc.content[1].table.body[0].length + 1).join('*').split('');
							}
						},
						{
							extend: 'print',
							filename: function () { return $('#title').text()},
							title: $('#title').html(),
						},
						{
							extend: 'colvis',
						},
					],
				} )
				.columns.adjust()
				.responsive.recalc();
		} );

	</script>
@stop
