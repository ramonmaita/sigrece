<div>
	<div class="w-full mb-3 -m-2 text-center" wire:loading>
		<div class="p-2">
			<div
				class="inline-flex items-center w-1/2 p-2 text-sm leading-none text-blue-600 bg-white rounded-full shadow text-teal">
				<span
					class="inline-flex items-center justify-center h-6 px-3 text-white bg-blue-600 rounded-full">Info</span>
				<span class="inline-flex px-2"> Procesando informarción por favor espere...</span>
			</div>
		</div>
	</div>
    <div class="grid grid-cols-5 gap-2">
		<div class="my-4">
			<div class="px-3">
				<x-jet-label for="actividad" value="{{ __('Seleccione Actividad') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-select  class="block w-full mt-1" wire:model='actividad_id'>
					<option value="">Seleccione</option>
					@forelse ($actividades as $actividad)
						<option value="{{ $actividad->id }}">{{ $actividad->actividad }} - {{ $actividad->porcentaje }}%</option>
					@empty
					<option value="" disabled>No hay actividades registradas</option>

					@endforelse

				</x-select>
				<x-jet-input-error for="actividad" />
			</div>
		</div>
		<div class="my-4">
			<div class="px-3">
				<x-jet-label for="actividad" value="{{ __('actividad') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-jet-input id="actividad" class="block w-full mt-1 SoloNumeros" type="text" name="actividad"
					:value="old('actividad')" wire:model.defer="actividad" required  wire:loading.attr="disabled"/>
				<x-jet-input-error for="actividad" />
			</div>
		</div>
		<div class="my-4">
			<div class="px-3">
				<x-jet-label for="descripcion" value="{{ __('descripcion') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-jet-input id="descripcion" class="block w-full mt-1 SoloNumeros" type="text" name="descripcion"
					:value="old('descripcion')" wire:model.defer="descripcion" required  wire:loading.attr="disabled"/>
				<x-jet-input-error for="descripcion" />
			</div>
		</div>
		<div class="my-4">
			<div class="px-3">
				<x-jet-label for="porcentaje" value="{{ __('porcentaje') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-jet-input id="porcentaje" class="block w-full mt-1 SoloNumeros" type="number" name="porcentaje"
					:value="old('porcentaje')" wire:model.defer="porcentaje" required  wire:loading.attr="disabled"/>
				<x-jet-input-error for="porcentaje" />
			</div>
		</div>
		<div class="my-4">
			<div class="pt-6">
				<x-jet-button wire:click="update"  class="h-10" wire:loading.attr="disabled">
					{{ __('GUARDAR') }}
				</x-jet-button>
			</div>
		</div>
	</div>
</div>
