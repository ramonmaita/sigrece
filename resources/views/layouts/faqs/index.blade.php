<x-guest-layout>
    
	<section class="bg-white dark:bg-gray-900">
	    
		<div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
		    @include('alertas')
			<div class="flex items-center justify-between">
				<h2 class="mb-8 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Preguntas frecuentes</h2>
				@auth
					@can('faqs.create')
					<a href="{{ route('faqs.create') }}" class="bg-gray-800 text-xs text-white rounded px-2 py-1">
						Crear
					</a>
					@endcan
				@endauth
			</div>
			<div class="grid pt-8 text-left border-t border-gray-200 md:gap-5 dark:border-gray-700 md:grid-cols-2">
				@forelse ($faqs as $faq)
				<div>
					<div class="mb-2">
						<h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
							<svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd">
								</path>
							</svg>
							{{ $faq->pregunta }}
							@auth
							    @can ('faqs.edit')
								<a href="{{ route('faqs.edit', $faq) }}" class="text-indigo-600 ml-4">Editar</a>
								@endcan
								@can('faqs.delete')
								<form action="{{ route('faqs.destroy', $faq) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <input type="submit"
                                        value="Eliminar"
                                        class="text-red-600 bg-transparent cursor-pointer rounded px-4 py-2"
                                        onclick="return confirm('¿Desea Eliminar?')">
                                </form>
								@endcan
							@endauth
						</h3>
						<p class="text-gray-500 dark:text-gray-400">
							{{ $faq->respuesta }}
						</p>
					</div>
				</div>
				@empty
				<p class="border-b border-gray-200 text-sm">
					No hay preguntas por contestar.
				</p>
				@endforelse
			</div>
		</div>
	  </section>
</x-guest-layout>
