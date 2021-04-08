<x-app-layout>
    <x-slot name="header">
    	<div class="grid grid-cols-2 md:grid-cols-2">

	        <h2 class="text-xl font-semibold leading-tight text-gray-800">
	            {{ __('Secciones Asignadas') }}
	        </h2>

	        <x-breadcrumb>
	        	<li class="flex items-center">
			      <a href="{{ route('panel.docentes.index') }}">Inicio</a>
			      <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
			    </li>
			    <li>
			      <a  class="text-gray-500" aria-current="page">Secciones Asignadas</a>
			    </li>
	        </x-breadcrumb>

    	</div>
    </x-slot>

    <div class="py-12">
		@include('alertas')
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
				    <div class="p-6">
				       <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
							<thead>
								<tr>
									<th data-priority="1">Sección</th>
									<th data-priority="2">Unidad Curricular</th>
									<th data-priority="3">Trimeste|Semestre|Año</th>
									<th data-priority="4">Acciones</th>
								</tr>
							</thead>
							<tbody>
								@forelse($secciones as $seccion)
									<tr>
										<td>{{ $seccion->seccion }}</td>
										<td>{{ $seccion->DesAsignatura->nombre }}</td>
										<td>{{ $seccion->DesAsignatura->tri_semestre }}</td>
										<td>
											@if (
													Auth::user()->cedula == 5013386 && $seccion->cod_asignatura == '01PSI106' || 
													Auth::user()->cedula == 12598686 && $seccion->cod_asignatura == '01PSI106' || 
													Auth::user()->cedula == 14590972 && $seccion->cod_asignatura == '01PSI507' ||
													Auth::user()->cedula == 18014562 || Auth::user()->cedula == 12185888 
												)
													{{-- 18014562	MARIO JOSE	BRAVO GUTIERREZ --}}
													{{-- 12185888	CAROLA	SERRANO FLORES --}}
													{{-- 11175805	CLEVER JESÚS	TORRES RAMIREZ || Auth::user()->cedula == 11175805 --}}
													{{-- 19872686	RAY JOSE	ALFONZO GUEVARA
													Auth::user()->cedula == 19872686 && $seccion->cod_asignatura == '01PSI106' ||  --}}

													{{-- 26355485	JOSE RAFAEL	LOPEZ GUEVARA
													Auth::user()->cedula == 26355485 && $seccion->cod_asignatura == '01PSI307' ||  --}}

											<x-link :disabled="true"  color="red" intensidad="400">
												<i class="fas fa-upload"></i>
											</x-link>
											@else

													<x-link href="{{ route('panel.docente.secciones.cargar-nota',[$seccion->seccion,$seccion->DesAsignatura->codigo]) }}" color="blue" intensidad="600">
														<i class="fas fa-upload"></i>
													</x-link>
												@if ($seccion->estatus == 0)
													<x-link href="{{ route('panel.docente.secciones.acta',[$seccion]) }}" :disabled="false" target="_blank" color="red" intensidad="600">
														<i class="far fa-file-pdf "></i>
													</x-link>
												@else
													<x-link :disabled="true" target="_blank" color="red" intensidad="400">
														<i class="far fa-file-pdf "></i>
													</x-link>
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
