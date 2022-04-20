<div>
    <div class="grid grid-cols-4 gap-2">
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
				<x-jet-button wire:click="store"  class="h-10" wire:loading.attr="disabled">
					{{ __('GUARDAR') }}
				</x-jet-button>
			</div>
		</div>
	</div>
</div>
