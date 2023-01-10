<x-app-layout>
	@php
		$actual = \Carbon\Carbon::now()->toDateTimeString();
		// $actual = date('Y-m-d H:i:s', strtotime(\Carbon\Carbon::now()));
		// return dd($actual);
		$cerrado = true;
		$evento_solicitud_correccion = \App\Models\Evento::where('tipo','ASIGNAR DOCENTES')
		->where('evento_padre',0)
		->where('inicio','<=',$actual)
		->where('fin','>=',$actual)
		->orderBy('id','desc')
		->first();
		// return dd($evento_solicitud_correccion);
		if($evento_solicitud_correccion){
			$aplicable = json_decode($evento_solicitud_correccion->aplicable);
			if ($evento_solicitud_correccion->aplicar == 'TODOS') {
				$cerrado = false;
			}elseif ($evento_solicitud_correccion->aplicar == 'ESPECIFICO' && array_search(Auth::user()->cedula,$aplicable[1]) !== false) {
				$cerrado = false;
			}
		}

	@endphp
    <x-slot name="header">
    	<div class="grid grid-cols-2 md:grid-cols-2">

	        <h2 class="text-xl font-semibold leading-tight text-gray-800">
	            {{ __('Secciones') }}
	        </h2>

	        <x-breadcrumb>
	        	<li class="flex items-center">
			      <a href="{{ route('panel.coordinador.index') }}">Inicio</a>
			      <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
			    </li>
			    <li>
			      <a  class="text-gray-500" aria-current="page">Secciones</a>
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
				       <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
							<thead>
								<tr>
									<th data-priority="1">Sección</th>
									<th data-priority="2">Nucleo</th>
									<th data-priority="5">Acciones</th>
								</tr>
							</thead>
							<tbody>
								@forelse($secciones as $seccion)
									<tr>
										<td>{{ $seccion->nombre }}</td>
										<td>{{ $seccion->Nucleo->nucleo }}</td>

										<td>

											@if ($seccion->DesAsignaturas->count() > 0)
												<x-link href="{{ route('panel.coordinador.secciones.show',[$seccion->id]) }}" color="blue" intensidad="600">
													<i class="fas fa-eye"></i>
												</x-link>
												@if ($cerrado == false)
													@can('jefe-pnf.secciones.editar_configuracion')
														<x-link href="{{ route('panel.coordinador.secciones.editar_config',[$seccion->id]) }}" color="yellow" intensidad="600">
															<i class="fas fa-cogs"></i>
														</x-link>
													@endcan
												@endif
											@else
												@if ($cerrado == false)
													@can('jefe-pnf.secciones.configurar')
														<x-link href="{{ route('panel.coordinador.secciones.configurar',[$seccion->id]) }}" color="blue" intensidad="800">
															<i class="fas fa-cogs"></i>
														</x-link>
													@endcan
												@endif
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

</x-app-layout>
