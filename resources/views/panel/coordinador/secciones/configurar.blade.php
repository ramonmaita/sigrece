<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-2 md:grid-cols-2">

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Secciones') }}
            </h2>

            <x-breadcrumb>
                <li class="flex items-center">
                    <a href="{{ route('panel.coordinador.index') }}">Inicio</a>
                    <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('panel.coordinador.secciones.index') }}">Secciones</a>
                    <svg class="w-3 h-3 mx-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path
                            d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                    </svg>
                </li>
                <li>
                    <a class="text-gray-500" aria-current="page">{{ $seccion->nombre }} - Asignar Docentes</a>
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
                    <div class="p-6 overflow-x-auto">
						<form action="{{ route('panel.secciones.guardar_config') }}" method="post" autocomplete="off">
							@csrf
							@method('post')
							<input type="hidden" name="seccion_id" value="{{ $seccion->id }}">
							<table class="w-full table-auto min-w-max">
								<thead>
									<tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
										<th class="px-6 py-3 text-center">N°</th>
										<th class="px-6 py-3 text-center">Unidad Curricular</th>
										<th class="px-6 py-3 text-center">{{ $seccion->Plan->cohorte }}</th>
										<th class="px-6 py-3 text-right">Docente</th>
										{{-- <th></th> --}}
									</tr>
								</thead>
								<tbody>
									@php $n = 1; @endphp
									@foreach ($seccion->Plan->Asignaturas->where('trayecto_id', $seccion->trayecto->id) as $asignatura)
									<tr class="bg-green-600 bg"{{--  style=" background-color: lightgreen" --}}>
										<th class="py-3 text-white" colspan="4" style="text-align: center;"  for="{{  $asignatura->codigo }}">
										<label for="{{  $asignatura->codigo }}" style="width: 95%; cursor: pointer; height: 100%;;" class="check-asignatura">
												<input type="checkbox" name="n[]" checked="true" hidden="" class="hidden">
											{{  $asignatura->nombre }}
										</label>
											<input type="checkbox" checked="true"  id="{{  $asignatura->codigo }}" value="{{ $asignatura->id }}" name="asignaturas_ins[]" hidden="true" class="hidden" {{-- class="check-asignatura" --}}>
										</th>
										@forelse($asignatura->DesAsignaturas as $desasignatura)
											<tr>
											<td align="center">

												{{ $n }}
												<input type="hidden" name="{{ $desasignatura->id }}" value="{{ $n }}">
											</td>
											<td align="center">
												{{ $desasignatura->nombre }}
												<input type="hidden" name="codigo" value="{{ $desasignatura->codigo }}">
											</td>
											<td align="center">
												{{ $desasignatura->tri_semestre }}
												<input type="hidden" name="codigo_anual" value="{{ $desasignatura->asignatura_id }}">
											</td>
											<td align="right">
												<select name="docente_id[]" class="{{  $asignatura->codigo }} select2">
												{{-- <option value="0">SIN ASIGNAR</option> --}}
												@foreach($docentes as $docente)
													<option value="{{ $docente->id }}"> {{ $docente->cedula .' '. $docente->nombres .' '. $docente->apellidos }} </option>
												@endforeach
												</select>
											</td>
											{{-- <td> --}}
												{{-- <input type="checkbox" checked="true"  class="{{  $asignatura->codigo }}" value="{{ $desasignatura->codigo }}" name="asignaturas_ins[]" hidden="true"> --}}
											{{-- </td> --}}
											</tr>
										@php $n++; @endphp

										@empty
										@endforelse
									</tr>
									</tr>
									@endforeach
								</tbody>
							</table>
							<div class="grid grid-cols-2">

								<div class=" mt-5">
									<x-link href="{{ url()->previous() }}" color="gray" intensidad="500" class="justify-center w-1/2">
										Atras
									</x-link>
								</div>
								<div class=" float-right mt-5">
									<x-jet-button class="float-right w-1/2 justify-center">Guardar</x-jet-button>
								</div>
							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>

	@push('scripts')
	<script type="text/javascript">
	window.livewire.on('cerrar_modal', () => {
		$('#exampleModal').modal('hide');
	});
	</script>
	<script>
	$(function() {
	  $('.select2').select2({});
	  $(document).on('click','.check-asignatura', function() {
		var id = $(this).attr('for');
		var attr = $('.'+id).attr('disabled')
		// alert($(this).attr('for'))
		  // $('.'+id).attr('disabled', 'true')
		if ( $("#"+id+":checked").length != 1) {

		  $('.'+id).removeAttr('disabled')
		  // $(this).parent().parent().children().css("background-color", "lightgreen");
		  $(this).parent().parent().children().removeClass('bg-red-800');
		  $(this).parent().parent().children().addClass('bg-green-600');
		}else{
		  $('.'+id).attr('disabled', 'true')
		  // $(this).parent().parent().children().css("background-color", "lightgrey");
		  $(this).parent().parent().children().removeClass('bg-green-600');
		  $(this).parent().parent().children().addClass('bg-red-800');
		}
		console.log($("#"+id+":checked").length)
	  });
	});
	</script>
	@endpush
</x-app-layout>
