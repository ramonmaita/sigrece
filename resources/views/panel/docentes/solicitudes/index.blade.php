<x-app-layout>
    <x-slot name="header">
    	<div class="grid grid-cols-2 md:grid-cols-2">

	        <h2 class="text-xl font-semibold leading-tight text-gray-800">
	            {{ __('Mis Solicitudes') }}
	        </h2>

	        <x-breadcrumb>
	        	<li class="flex items-center">
			      <a href="{{ route('panel.docentes.index') }}">Inicio</a>
			      <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
			    </li>
			    <li>
			      <a  class="text-gray-500" aria-current="page">Mis Solicitudes</a>
			    </li>
	        </x-breadcrumb>

    	</div>
    </x-slot>

    <div class="py-12">
		@include('alertas')
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="grid overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
				<div class="grid-cols-1 p-6 bg-gray-200 bg-opacity-25">
					<x-link class="float-right" href="{{ route('panel.docente.solicitudes.create') }}" :disabled="false" color="gray" intensidad="900">
						Nueva Solicitud
					</x-link>
				</div>
                <div class="grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
				    <div class="p-6">
				       <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
							<thead>
								<tr>
									<th data-priority="1">Fecha</th>
									<th data-priority="2">Periodo</th>
									<th data-priority="3">Tipo</th>
									<th data-priority="4">Estatus</th>
									<th data-priority="5">Acciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($solicitudes as $solicitud)
									<tr>
										<td>{{ $solicitud->created_at }}</td>
										<td>{{ $solicitud->periodo }}</td>
										<td>{{ $solicitud->tipo }}</td>
										<td>{{ $solicitud->estatus }}</td>
										<td>
											<x-link :disabled="true"  color="blue" intensidad="400">
												<i class="fas fa-eye"></i>
											</x-link>

											<x-link href="{{ route('panel.docente.solicitudes.pdf', [$solicitud]) }}" target="_blank" color="red" intensidad="400">
												<i class="far fa-file-pdf"></i>
											</x-link>
										</td>
									</tr>
								@endforeach
							</tbody>

						</table>
				    </div>
				</div>
            </div>
        </div>
    </div>
</x-app-layout>
