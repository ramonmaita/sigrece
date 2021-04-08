<x-app-layout>
    <x-slot name="header">
    	<div class="grid grid-cols-2 md:grid-cols-2 flex-inline sm:grid-cols-1">
    		<div class="">
		        <h2 class="text-xl font-semibold leading-tight text-gray-800">
		            {{ $seccion }} - Cargar Notas
		        </h2>
    			<small>UC: {{ $desAsignatura->nombre }} </small> <br>
    			<small class="mr-4">Trimeste|Semestre|Año:  {{ $desAsignatura->tri_semestre }}</small>
    			<small>Docente: {{ Auth::user()->nombre }} {{ Auth::user()->apellido }} </small>
    		</div>

    		<div class="">
		        <x-breadcrumb>
		        	<li class="flex items-center">
				      <a href="{{ route('panel.docente.index') }}">Inicio</a>
				      <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
				    </li>
				    <li class="flex items-center">
				      <a href="{{ route('panel.docente.secciones.index') }}">Secciones Asignadas</a>
				      <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
				    </li>
				    <li>
				      <a href="#" class="text-gray-500" aria-current="page">{{ $seccion }} - Cargar Notas</a>
				    </li>
		        </x-breadcrumb>
    		</div>

    	</div>
    </x-slot>

    <div class="py-12">
		@include('alertas')
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
				<form action="{{ route('panel.docente.secciones.guardar-nota',['seccion' => $asignaturas->first()]) }}" method="POST">
					@method('POST')
					@csrf
					<div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
						<div class="p-6">
						   <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
								<thead>
									<tr>
										<th data-priority="1">N°</th>
										<th data-priority="2">Cédula</th>
										<th data-priority="3">Nombres</th>
										<th data-priority="4">Apellidos</th>
										<th data-priority="5">Nota</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($asignaturas as $key => $asignatura)
										<tr>
											<td>{{ $key+1 }}</td>
											<td><input type="hidden" name="estudiantes[{{$asignatura->cedula_estudiante}}]" value="{{ $asignatura->cedula_estudiante }}" autofocus="false" readonly  tabindex="-6"> {{ $asignatura->cedula_estudiante }}</td>
											<td>{{ @$asignatura->Alumno->nombres }}</td>
											<td>{{ @$asignatura->Alumno->apellidos }}</td>
											<td align="right">
												<x-jet-input type="number" id="" class="block w-full mt-1" name="notas[{{$asignatura->cedula_estudiante}}]" required autofocus autocomplete="off" min="1" max="20" value="{{ $asignatura->nota }}"
													{{-- @if ($asignatura->nota == 0) --}}
														:disabled="($asignatura->nota == 0) ? false : true"
													{{-- @endif --}}
												/>
											</td>
										</tr>
									@endforeach
								</tbody>

							</table>
						</div>
					</div>

					<div class="grid grid-cols-2 m-5">
						<div class="">
							<x-link href="{{ url()->previous() }}" color="gray" intensidad="500" class="justify-center w-1/2">
								Atras
							</x-link>
						</div>
						<div class="">
							<x-jet-button class="justify-center float-right w-1/2">
								Guardar
							</x-jet-button>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</x-app-layout>
