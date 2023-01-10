<div class="flex space-x-1">
    @can('secciones.edit')
        <button class="btn btn-primary btn-sm" data-target="#exampleModal" data-toggle="modal"
            wire:click="$emit('edit','{{ $id }}')">
            <i class="fa fa-edit">
            </i>
        </button>
    @endcan
    @can('secciones.configurar')
		@php
			$seccion = \App\Models\Seccion::find($id);
		@endphp
        <a href="{{ $seccion->DesAsignaturas->count() > 0 ? route('panel.secciones.editar_config', ['id' => $seccion->id]) : route('panel.secciones.config', ['id' => $seccion->id]) }}"
            class="btn btn-{{ $seccion->DesAsignaturas->count() > 0 ? 'warning' : 'info' }} btn-sm"><i
                class="fa fa-cogs">
            </i> </a>
    @endcan
    <a href="{{ route('panel.secciones.show', ['seccion' => $id]) }}" class="btn btn-info btn-sm"><i
            class="fa fa-eye">
        </i> </a>
    <a href="{{ route('panel.secciones.descargar-listado', ['seccion' => $id]) }}" class="btn btn-warning btn-sm"><i
            class="fa fa-download">
        </i> </a>

</div>
