<x-app-layout>
    <x-slot name="header">
    	<div class="grid grid-cols-2 md:grid-cols-2">

	        <h2 class="text-xl font-semibold leading-tight text-gray-800">
	            {{ __('Inicio') }}
	        </h2>

	        <x-breadcrumb>

			    <li>
			      <a href="#" class="text-gray-500" aria-current="page">Inicio</a>
			    </li>
	        </x-breadcrumb>

    	</div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
			@include('alertas')
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
				{{-- <x-jet-welcome /> --}}
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
					<x-jet-validation-errors class="py-2 mx-5 my-5 text-center text-white bg-red-200 rounded-xl" />
					<div class="">
						<form action="{{ route('panel.estudiante.inscripciones.regulares.store') }}" method="post">
							@csrf
							@method('post')
							<input type="hidden" name="alumno_id" value="{{ $alumno->id }}" readonly>
							<table class="w-full table-auto min-w-max">
								<thead>
									<tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
										<th class="px-6 py-3 text-left">N°</th>
										<th class="px-6 py-3 text-left">{{ $alumno->Plan->cohorte }}</th>
										<th class="px-6 py-3 text-center">UC</th>
										<th class="px-6 py-3 text-center w-96">Seccón</th>
									</tr>
								</thead>
								<tbody class="text-sm font-light text-gray-600">
									@php
										$n = 1;
										$trayecto = 0;
									@endphp
									@forelse ($uc_acursar as $key => $asignatura)
										@php
											$u_periodo_asignatura = $alumno->ultimo_periodo($asignatura->codigo);
											$notas =  $alumno->Notas($asignatura->codigo , @$u_periodo_asignatura->nro_periodo)->sum('nota');
											$nota_final = round($notas / count($asignatura->DesAsignaturas));
											if($alumno->tipo == 10) {
												$aprueba = 10;
											}else{
												$aprueba = ($asignatura->aprueba == 1) ? 16 : 12;
											}

										@endphp
										@if ($nota_final <= $aprueba)
											@if ($trayecto != $asignatura->trayecto_id)

											<tr class="border-b border-gray-200 hover:bg-gray-100">
												<th colspan="3" align="center"  class="px-6 py-3 text-center whitespace-nowrap">
													<span class="font-extrabold tracking-wide">{{ $asignatura->Trayecto->observacion }}</span>
												</th>
												<td   class="px-6 py-3 text-center whitespace-nowrap">
													{{-- <div class="form-group"> --}}
														<x-select class="block w-full mt-1" name="seccion[{{$asignatura->trayecto_id}}]" id=""  >
															@forelse ($asignatura->RelacionSeccionDocente() as $relacion)
															<option value="{{ @$relacion->Seccion->id }}">{{ @$relacion->Seccion->nombre }}</option>
																{{-- @foreach ($relacion->Seccion as $seccion)
																@endforeach --}}
																@empty
																<option selected disabled>NO HAY SECCIONES DISPONIBLES</option>
															@endforelse
														</x-select>
														{{-- </div> --}}
												</td>
											</tr>
											@endif
											<tr  class="border-b border-gray-600 text-white bg-{{ $color=(count($asignatura->RelacionSeccionDocente()) <= 0) ? 'gray-600' : 'blue-900' }}">
												<td class="px-6 py-3 text-left whitespace-nowrap">{{ $n++ }}</td>
												<td class="px-6 py-3 text-left whitespace-nowrap">{{ @$asignatura->Trayecto->nombre }}</td>
												<td class="px-6 py-3 text-left whitespace-nowrap">{{ @$asignatura->nombre }}</td>
												<td class="px-6 py-3 text-left whitespace-nowrap">
													<span class="px-3 py-1 text-xs text-{{ $color=(count($asignatura->RelacionSeccionDocente()) <= 0) ? 'red-200' : 'green-200'}} bg-{{ $color=(count($asignatura->RelacionSeccionDocente()) <= 0) ? 'red-600' : 'green-600'}} rounded-full">
														<label class="tracking-wider form-check-label" for="{{ $asignatura->codigo }}" style="cursor:pointer">
															<input class="form-check-input check-asignatura" type="checkbox" name="uc_a_inscribir[{{$asignatura->trayecto_id}}][]" id="{{ $asignatura->codigo }}" value="{{ $asignatura->id }}" {{ (count($asignatura->RelacionSeccionDocente()) <= 0) ? 'disabled' : 'checked' }}> INSCRIBIR
														</label>
													</span>
												</td>
											</tr>
											@if ($alumno->Plan->observacion != 'ANUAL')
												<tr>
													<td colspan="4" style="margin: 0px; padding:0px;">
														<table class="w-full table-auto min-w-max">

															<tbody>
																@foreach ($asignatura->DesAsignaturas as $key => $desasignatura)
																	<tr class="text-white bg-indigo-400 border-b border-indigo-200 hover:text-gray-700 hover:bg-indigo-100">
																		<td class="px-6 py-3 font-extrabold tracking-wide text-left whitespace-nowrap"><b>{{ $asignatura->Plan->cohorte }}</b> {{ $desasignatura->tri_semestre }}</td>
																		<td class="px-6 py-3 font-extrabold tracking-wide text-left whitespace-nowrap">{{ $desasignatura->nombre }}</td>
																	</tr>
																@endforeach
															</tbody>
														</table>
													</td>
												</tr>
											@endif
											@php
												$trayecto = $asignatura->trayecto_id;
											@endphp
										@endif
									@empty
										@php
											$ocultar = true;
										@endphp
										<tr class="border-b border-gray-200 hover:bg-gray-100">
											<th colspan="4" align="center"  class="px-6 py-3 text-center whitespace-nowrap">
												<span class="font-extrabold tracking-wide">
													No hay Unidades Curriculares Por Inscribir
												</span>
											</th>
										</tr>
									@endforelse
									{{-- <tr class="border-b border-gray-200 hover:bg-gray-100">
										<td class="px-6 py-3 text-left whitespace-nowrap">
											<div class="flex items-center">
												<div class="mr-2">
													<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
														 width="24" height="24"
														 viewBox="0 0 48 48"
														 style=" fill:#000000;">
														<path fill="#80deea" d="M24,34C11.1,34,1,29.6,1,24c0-5.6,10.1-10,23-10c12.9,0,23,4.4,23,10C47,29.6,36.9,34,24,34z M24,16	c-12.6,0-21,4.1-21,8c0,3.9,8.4,8,21,8s21-4.1,21-8C45,20.1,36.6,16,24,16z"></path><path fill="#80deea" d="M15.1,44.6c-1,0-1.8-0.2-2.6-0.7C7.6,41.1,8.9,30.2,15.3,19l0,0c3-5.2,6.7-9.6,10.3-12.4c3.9-3,7.4-3.9,9.8-2.5	c2.5,1.4,3.4,4.9,2.8,9.8c-0.6,4.6-2.6,10-5.6,15.2c-3,5.2-6.7,9.6-10.3,12.4C19.7,43.5,17.2,44.6,15.1,44.6z M32.9,5.4	c-1.6,0-3.7,0.9-6,2.7c-3.4,2.7-6.9,6.9-9.8,11.9l0,0c-6.3,10.9-6.9,20.3-3.6,22.2c1.7,1,4.5,0.1,7.6-2.3c3.4-2.7,6.9-6.9,9.8-11.9	c2.9-5,4.8-10.1,5.4-14.4c0.5-4-0.1-6.8-1.8-7.8C34,5.6,33.5,5.4,32.9,5.4z"></path><path fill="#80deea" d="M33,44.6c-5,0-12.2-6.1-17.6-15.6C8.9,17.8,7.6,6.9,12.5,4.1l0,0C17.4,1.3,26.2,7.8,32.7,19	c3,5.2,5,10.6,5.6,15.2c0.7,4.9-0.3,8.3-2.8,9.8C34.7,44.4,33.9,44.6,33,44.6z M13.5,5.8c-3.3,1.9-2.7,11.3,3.6,22.2	c6.3,10.9,14.1,16.1,17.4,14.2c1.7-1,2.3-3.8,1.8-7.8c-0.6-4.3-2.5-9.4-5.4-14.4C24.6,9.1,16.8,3.9,13.5,5.8L13.5,5.8z"></path><circle cx="24" cy="24" r="4" fill="#80deea"></circle>
													</svg>
												</div>
												<span class="font-medium">React Project</span>
											</div>
										</td>
										<td class="px-6 py-3 text-left">
											<div class="flex items-center">
												<div class="mr-2">
													<img class="w-6 h-6 rounded-full" src="https://randomuser.me/api/portraits/men/1.jpg"/>
												</div>
												<span>Eshal Rosas</span>
											</div>
										</td>
										<td class="px-6 py-3 text-center">
											<div class="flex items-center justify-center">
												<img class="w-6 h-6 transform border border-gray-200 rounded-full hover:scale-125" src="https://randomuser.me/api/portraits/men/1.jpg"/>
												<img class="w-6 h-6 -m-1 transform border border-gray-200 rounded-full hover:scale-125" src="https://randomuser.me/api/portraits/women/2.jpg"/>
												<img class="w-6 h-6 -m-1 transform border border-gray-200 rounded-full hover:scale-125" src="https://randomuser.me/api/portraits/men/3.jpg"/>
											</div>
										</td>
										<td class="px-6 py-3 text-center">
											<span class="px-3 py-1 text-xs text-purple-600 bg-purple-200 rounded-full">Active</span>
										</td>

									</tr> --}}
								</tbody>
							</table>

							<div class="grid grid-cols-2 bg-gray-200 bg-opacity-25 md:grid-cols-2">
								<div class="w-full px-5 mt-6 overflow-hidden text-center sm:max-w-7xl sm:rounded-lg">
									<x-link href="{{ route('panel.estudiante.index') }}" color="gray" intensidad="700" class="w-full text-center">
										Cancelar
									</x-link>
								</div>
								<div class="w-full px-5 mt-6 overflow-hidden text-center sm:max-w-7xl sm:rounded-lg">
									@if(!isset($ocultar))
									<x-button color="gray" intensidad="900" class="w-full text-center">
										Inscribir
									</x-button>
									@endif
								</div>
							</div>
						</form>
					</div>
				    <div class="p-6">
				       {{-- <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
							<thead>
								<tr>
									<th data-priority="1">Sección</th>
									<th data-priority="2">Unidad Curricular</th>
									<th data-priority="3">Trimeste|Semestre|Año</th>
									<th data-priority="4">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>Edinburgh</td>
									<td>61</td>

								</tr>

								<tr>
									<td>Donna Snider</td>
									<td>Customer Support</td>
									<td>New York</td>
									<td>27</td>

								</tr>
							</tbody>
						</table> --}}


				    </div>

					{{-- <div class="p-10">
						<h4 class="text-lg font-semibold leading-tight">
							Bienvenido(a) Estudiante {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
						</h4>
					</div> --}}
				</div>
            </div>
        </div>
    </div>





	@section('scripts')
	<script>
		$(function () {
			$(document).on('click','.check-asignatura', function() {
				var id = $(this).attr('id');
				if ( $("#"+id).prop('checked') == false) {
					$(this).parent().parent().parent().parent().removeClass('bg-blue-900');
					$(this).parent().parent().parent().parent().addClass('bg-gray-600');
				}else{
					$(this).parent().parent().parent().parent().removeClass('bg-gray-600');
					$(this).parent().parent().parent().parent().addClass('bg-blue-900');
				}
				// console.log($("#"+id).prop('checked'))
				// console.log(id)
				// console.log($(this))
			});
		});
	</script>
	@endsection
</x-app-layout>

