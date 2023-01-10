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
					@livewire('alumnos.retiros.create',['alumno' => Auth::user()->Alumno])



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

