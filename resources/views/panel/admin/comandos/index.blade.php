@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h4>
                    Listado de Comandos Artisan {{ env('APP_NAME') }}
                </h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('panel.index') }}">
                            Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Listado de Comandos Artisan {{ env('APP_NAME') }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')

	@include('alertas')

    @php
        $comandos = [
            [
                'comando' => 'cache:clear - config:clear - config:cache - view:clear',
                'funcion' => 'Limpiar cache del sistema',
                'route' =>  route('panel.comandos.limpiar-cache')
            ],
			[
                'comando' => 'db:dump',
                'funcion' => 'Respaldar Base de Datos',
                'route' =>  route('panel.comandos.respaldar-db')
            ],
            [
                'comando' => 'storage:link',
                'funcion' => 'Crear enlace simbolico de la carpeta storage',
                'route' =>  route('panel.comandos.storage-link')
            ],
            [
                'comando' => 'queue:work',
                'funcion' => 'Ejecutar cola de procesos',
                'route' =>  route('panel.comandos.jobs')
            ],
            [
                'comando' => 'livewire:discover',
                'funcion' => 'Descubrir componetes livewire',
                'route' =>  route('panel.comandos.livewire-discover')
            ],
        ];
    @endphp
    <div class="card card-primary card-outline">
        <div class="card-body table-responsive">
            <table class="table table-striped table-inverse " id="table-uc">
                <thead class="thead-inverse">
                    <tr>
                        <th>Comando</th>
                        <th>Función</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($comandos as $comando)
                    <tr>
                       <td>{{ $comando['comando'] }}</td>
                       <td>{{ $comando['funcion'] }}</td>
					   <td>
                            @can('comandos.ejecutar')
                                <a href="{{ $comando['route'] }}" class="btn btn-dark btn-sm"><i class="fas fa-tools "></i></a>
                            @endcan
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
