<div>
	<x-jet-validation-errors class="py-2 mx-5 my-5 text-center text-white bg-red-200 rounded-xl" />
	<div class="overflow-x-auto">
			<input type="hidden" name="alumno_id" value="{{ $alumno->id }}" readonly>
			<table class="w-full table-auto min-w-max">
				<thead>
					<tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
						<th class="px-6 py-3 text-left">N°</th>
						<th class="px-6 py-3 text-left">Trayecto</th>
						<th class="px-6 py-3 text-center">{{ $alumno->Plan->cohorte }}</th>
						<th class="px-6 py-3 text-left">Unidad Curricular</th>
						<th class="px-6 py-3 text-left">Sección</th>
						<th class="px-6 py-3 text-left">Retirar</th>
					</tr>
				</thead>
				<tbody class="text-sm font-light text-gray-600">
					@php
						$asignatura = 0;
						// $indicador = 0;
						$danger = false;
					@endphp

					@foreach ($alumno->InscritoActual()->Inscripcion as $key => $uc_inscrita)
						@if (array_key_exists($uc_inscrita->id, $uc_retirar) != false)
							@if ($uc_retirar[$uc_inscrita->id] != false)
								@php
									$danger = true;
								@endphp
							@endif
						@endif
						@if ($alumno->Plan->cohorte != 'AÑO')
							@if ($asignatura != $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->codigo || $loop->first)
								@php
									$indicador++;
								@endphp
								<tr
									class="text-center text-white bg-{{ $danger == true ? 'red-600' : 'green-600' }}">
									<td scope="row" colspan="5"  class="px-6 py-3 text-left whitespace-nowrap">
										{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->nombre }}
									</td>
									<td  class="px-6 py-3 text-left whitespace-nowrap">
										<div class="form-check">
											<label class="form-check-label" sytle="cursor:pointer;">
												<input type="checkbox"
													class="select-all form-check-input " id=""
													value="{{ $indicador }}">
												SI RETIRAR
											</label>
										</div>
									</td>
								</tr>
							@endif
						@endif
						<tr
							class="text-white {{ $alumno->Plan->cohorte == 'AÑO' ? ($danger == true ? 'bg-red-600' : 'bg-green-600') : '' }}">
							<td scope="row"  class="px-6 py-3 text-left whitespace-nowrap">{{ $key + 1 }}</td>
							<td  class="px-6 py-3 text-left whitespace-nowrap">{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->Trayecto->nombre }}
							</td>
							<td  class="px-6 py-3 text-left whitespace-nowrap">{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->tri_semestre }}
							</td>
							<td  class="px-6 py-3 text-left whitespace-nowrap">{{ $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->nombre }}
							</td>
							<td  class="px-6 py-3 text-left whitespace-nowrap">{{ $uc_inscrita->RelacionDocenteSeccion->Seccion->nombre }}</td>
							<td  class="px-6 py-3 text-left whitespace-nowrap">
								@if ($alumno->Plan->cohorte == 'AÑO')
									@php $indicador++; @endphp
									<div class="form-check">
										<label class="form-check-label label-{{ $indicador }}"
											sytle="cursor:pointer;">
											<input type="checkbox"
												class="form-check-input {{ $indicador }} select-all"
												id="" value="{{ $uc_inscrita->id }}"
												wire:model="uc_retirar.{{ $uc_inscrita->id }}">
											SI RETIRAR
										</label>
									</div>
								@else
									<input type="checkbox" style="display:none;"
										class="form-check-input {{ $indicador }}" id=""
										value="{{ $uc_inscrita->id }}"
										wire:model="uc_retirar.{{ $uc_inscrita->id }}">
									<div class="form-check">
										<label class="form-check-label label-{{ $indicador }}"
											sytle="cursor:pointer;">
											@if ($danger == true)
												<small class="text-danger text-capitalize">Para
													retirar</small>
											@endif

										</label>
									</div>

								@endif
							</td>
						</tr>
						@php
							$danger = false;
							$asignatura = $uc_inscrita->RelacionDocenteSeccion->DesAsignatura->Asignatura->codigo;
						@endphp
					@endforeach
				</tbody>
			</table>

			<div class="grid grid-cols-2 bg-gray-200 bg-opacity-25 md:grid-cols-2">
				<div class="w-full px-5 mt-6 overflow-hidden text-center sm:max-w-7xl sm:rounded-lg">
					<x-link href="{{ route('panel.estudiante.index') }}" color="gray" intensidad="700" class="w-full text-center">
						Cancelar
					</x-link>
				</div>
				<div class="w-full px-5 mt-6 overflow-hidden text-center sm:max-w-7xl sm:rounded-lg">
					@if (count($uc_retirar) > 0)
					<x-button color="gray" intensidad="900" class="w-full text-center" wire:click="retirar">
						Retirar ({{ count($uc_retirar) }}) UC
					</x-button>
					@endif
				</div>
			</div>
		</form>
	</div>
	<div class="p-6">


	</div>

	<script>
		$(function () {
			$(document).on('click', '.select-all', function() {
				var value = $(this).val();
				if ($(this).prop('checked') == false) {
					$('.' + value).click();
					Livewire.emit('disminuir');
				} else {
					$('.' + value).click();
					Livewire.emit('incrementar');
				}
			});
		});
	</script>
</div>
