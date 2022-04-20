<x-app-layout>
    <x-slot name="header">
    	<div class="grid grid-cols-2 md:grid-cols-2">

	        <h2 class="text-xl font-semibold leading-tight text-gray-800">
	            {{ $desasignatura->nombre }}
	        </h2>

	        <x-breadcrumb>
	        	<li class="flex items-center">
			      <a href="{{ route('panel.coordinador.index') }}">Inicio</a>
			      <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
			    </li>
				<li class="flex items-center">
                    <a href="{{ route('panel.coordinador.secciones.index') }}">Secciones</a>
                    <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </li>
				<li class="flex items-center">
                    <a href="{{ route('panel.coordinador.secciones.show',[$seccion->id]) }}">{{ $seccion->nombre }}</a>
                    <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </li>
			    <li>
			      <a  class="text-gray-500" aria-current="page">{{ $desasignatura->nombre }}</a>
			    </li>
	        </x-breadcrumb>

    	</div>
    </x-slot>

    <div class="py-12">
		@include('alertas')
		@livewire('docente.alertas')
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
				    <div class="p-6">
						<span id="title" class="hidden" style="display: none;">

							{!! $nombre_archivo = $seccion->nombre.' <br> '.$desasignatura->nombre .'('.$desasignatura->tri_semestre.')'.' <br> '.$relacion->Docente->nombres .' '.$relacion->Docente->apellidos !!}
						</span>
						<table class="table table-striped table-inverse w-full " id="table-uc">
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
												{{ ($inscritos->Alumno->tipo == 1 || $inscritos->Alumno->tipo == 12) ? 12 : $inscritos->Alumno->tipo }}
											@endif
										</td>
									</tr>
								@empty

								@endforelse
							</tbody>
						</table>
				    </div>
				</div>
            </div>
        </div>
    </div>
	@section('scripts')
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
</x-app-layout>
