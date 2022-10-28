@csrf

<x-web-card>
	<p class="my-4 text-lg font-semibold">
		{{
			$beca->alumno->p_nombre." ".
			$beca->alumno->s_nombre." ".
			$beca->alumno->p_apellido." ".
			$beca->alumno->s_apellido." ".
			$beca->alumno->nacionalidad[0]."-".$beca->alumno->cedula
		}}
	</p>
	<div class="mb-6 mx-2 md:flex">
		<div class="mb-2 -mx-3 md:flex">
			<div class="px-3 mb-6 md:w-full md:mb-0">
				<x-jet-label for="tipo" value="{{ __('Tipo de beca') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-select class="block w-full mt-1" name="tipo" value="{{ old('tipo', $beca->tipo) }}" id="" wire:model="tipo">
					<option value="ESTUDIO">ESTUDIO</option>
					<option value="AYUDANTIA">AYUDANTIA</option>
					<option value="PREPARADURIA">PREPARADURIA</option>
				</x-select>
				<x-jet-input-error for="tipo" />
			</div>
		</div>
	</div>
	<div class="flex flex-col align-items-center">
		<div class="w-50 mt-6 overflow-hidden text-center sm:max-w-7xl sm:rounded-lg">
			<x-button color="blue" intensidad="600" class="text-center w-25">
				Guardar
			</x-button>
		</div>
	</div>
</x-web-card>



