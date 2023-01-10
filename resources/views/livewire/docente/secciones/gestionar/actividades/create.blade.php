<div>
    <div class="grid grid-cols-5 gap-2">
		<div class="my-1">
			<div class="px-3">
				<x-jet-label for="actividad" value="{{ __('actividad') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-jet-input id="actividad" class="block w-full mt-1" type="text" name="actividad"
					:value="old('actividad')" wire:model.defer="actividad" required  wire:loading.attr="disabled"/>
				<x-jet-input-error for="actividad" />
			</div>
		</div>
		<div class="my-1">
			<div class="px-3">
				<x-jet-label for="descripcion" value="{{ __('descripcion') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-jet-input id="descripcion" class="block w-full mt-1" type="text" name="descripcion"
					:value="old('descripcion')" wire:model.defer="descripcion" required  wire:loading.attr="disabled"/>
				<x-jet-input-error for="descripcion" />
			</div>
		</div>
		<div class="my-1">
			<div class="px-3">
				<x-jet-label for="porcentaje" value="{{ __('porcentaje') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-jet-input id="porcentaje" class="block w-full mt-1 SoloNumeros" type="number" name="porcentaje"
					:value="old('porcentaje')" wire:model.defer="porcentaje" required  wire:loading.attr="disabled"/>
				<x-jet-input-error for="porcentaje" />
			</div>
		</div>
		<div class="my-1">
			<div class="px-3">
				<x-jet-label for="fecha" value="{{ __('fecha') }}"
					class="block font-bold tracking-wide capitalize" />
				<x-jet-input id="fecha" class="block w-full mt-1 SoloNumeros" type="date" name="fecha"
					:value="old('fecha')" wire:model.defer="fecha" required  wire:loading.attr="disabled"/>
				<x-jet-input-error for="fecha" />
			</div>
		</div>
		<div class="my-1">
			<div class="pt-6">
				<x-jet-button wire:click="store"  class="h-10 w-full text-center justify-center" wire:loading.attr="disabled">
					{{ __('GUARDAR') }}
				</x-jet-button>
			</div>
		</div>
	</div>
</div>
