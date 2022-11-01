@csrf

<x-web-card>
	@if (Route::currentRouteName() == 'panel.estudiantes.becas.edit')
		<p class="my-4 text-lg font-semibold">
			{{
				$beca->alumno->p_nombre." ".
				$beca->alumno->s_nombre." ".
				$beca->alumno->p_apellido." ".
				$beca->alumno->s_apellido." ".
				$beca->alumno->nacionalidad[0]."-".$beca->alumno->cedula
			}}
		</p>
	@endif


	<div class="mb-6 mx-2 md:flex">
		<div class="mb-2 -mx-3 md:flex">
			@if (Route::currentRouteName() == 'panel.estudiantes.becas.create')
				<div class="px-3 mb-6 md:w-1/2 md:mb-0">
					<x-jet-label for="cedula" value="{{ __('Cédula') }}"
						class="block font-bold tracking-wide capitalize" />
					<x-jet-input id="cedula" wire:model.defer="cedula" class="block w-full mt-1 " type="text" name="cedula"
					:value="old('cedula')" />
					<x-jet-input-error for="cedula" />
					@error('tipo')
						<p class="text-sm text-red-600">Este alumno ya tiene una beca.</p>
					@enderror
				</div>
			@endif
			<div class="px-3 mb-6 md:w-full md:mb-0">
				<x-jet-label for="tipo" value="{{ __('Tipo de beca') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-select class="block w-full mt-1" name="tipo" id="" wire:model="tipo">
					<option @if (@$beca->tipo == 'ESTUDIO') {{'selected'}} @endif value="ESTUDIO">ESTUDIO</option>
					<option @if (@$beca->tipo == 'AYUDANTIA') {{'selected'}} @endif  value="AYUDANTIA">AYUDANTIA</option>
					<option @if (@$beca->tipo == 'PREPARADURIA') {{'selected'}} @endif  value="PREPARADURIA">PREPARADURIA</option>
				</x-select>
			</div>
		</div>
	</div>
	<div class="flex flex-col align-items-center">
		<div class="w-50 mt-6 overflow-hidden text-center sm:max-w-7xl sm:rounded-lg">
			<x-button color="blue" intensidad="600" class="text-center">
				Guardar
			</x-button>
		</div>
	</div>
</x-web-card>



