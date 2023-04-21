<div class="w-full flex justify-center px-4 py-8 ">
	{{-- Paso 1 --}}
	@if ($step == 1)
		<div class="w-1/3 p-4 overflow-hidden bg-white rounded-lg shadow-xl">
			<form class="p-2" wire:submit.prevent="buscarUsuario">
				<label class="block mt-3" for="nombre">
					Cédula
					<input wire:model="cedula" type="text" name="nombre" id="nombre" class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-400" />
				</label>
				<label class="block mt-3" for="nombre">
					Correo
					<input wire:model="correo" type="email" name="nombre" id="nombre" class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-400" />
				</label>

				<label class="block mt-3" for="nombre">
					Fecha de nacimiento
					<input wire:model="fecha_nacimiento" type="date" class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-400" />
				</label>

				<div class="mt-4 w-full flex justify-center sm:-mx-2">
					<button type="submit" class="p-2 w-28 text-lg font-medium tracking-wide bg-blue-600 text-white capitalize transition-colors duration-300 transform border border-gray-200 rounded-md hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-opacity-40">
						Buscar
					</button>
				</div>
			</form>
			<span class="text-red-500">{{ $error }}</span>
		</div>
	@endif
	{{-- Paso 2 --}}
	@if ($step == 2)
		<div class="w-3/4 p-4 overflow-hidden bg-white rounded-lg shadow-xl">
			<h2 class="font-bold text-xl text-gray-800">Preguntas de seguridad</h2>
			<p class="text-sm text-gray-400">
				Cuando establezca sus preguntas de seguridad deberá hacer clic nuevamente en
				<span class="text-blue-400">¿Olvidaste tu contraseña?</span>
			</p>
			<form class="grid grid-cols-2 gap-8" wire:submit.prevent="guardarPreguntas">
				@foreach ($preguntas as $pregunta)
					<div class="mb-4">
						<label class="block mt-3" for="nombre">
							Pregunta {{ $loop->index + 1}}
							<input wire:model="preguntas.{{ $loop->index }}.pregunta" type="text" name="nombre" id="nombre" class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-400" />
						</label>
						@error('preguntas.'.$loop->index.'.pregunta')
						<span class="text-red-500 text-sm">Esta pregunta es requerida</span>
						@enderror
						<label class="block mt-3" for="nombre">
							Respuesta
							<input wire:model="preguntas.{{ $loop->index }}.respuesta" type="text" name="nombre" id="nombre" class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-400" />
						</label>
						@error('preguntas.'.$loop->index.'.respuesta')
						<span class="text-red-500 text-sm">Esta respuesta es requerida</span>
						@enderror
					</div>
				@endforeach
				<div class="mt-4 col-span-2 w-full flex justify-center sm:-mx-2">
					<button type="submit" class="p-2 w-28 text-lg font-medium tracking-wide bg-blue-600 text-white capitalize transition-colors duration-300 transform border border-gray-200 rounded-md hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-opacity-40">
						Guardar
					</button>
				</div>
			</form>
		</div>
	@endif
	{{-- Paso 3 --}}
	@if ($step == 3)
		<div class="w-3/4 p-4 overflow-hidden bg-white rounded-lg shadow-xl">
			<h2 class="font-bold text-xl text-gray-800">Preguntas de seguridad</h2>
			<form class="flex flex-col gap-4" wire:submit.prevent="verificar">
				@foreach ($preguntas as $pregunta)
					<div class="mb-4">
						<label class="block mt-3" for="nombre">
							{{ $pregunta["pregunta"] }}
							<input wire:model="preguntas.{{ $loop->index }}.respuesta" type="text" name="nombre" id="nombre" class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-400" />
						</label>
						@error('preguntas.'.$loop->index.'.respuesta')
						<span class="text-red-500 text-sm">Esta respuesta es requerida</span>
						@enderror
					</div>
				@endforeach
				<span class="text-red-500">{{ $error }}</span>
				<div class="mt-4 w-full flex justify-center sm:-mx-2">
					<button type="submit" class="p-2 w-28 text-lg font-medium tracking-wide bg-blue-600 text-white capitalize transition-colors duration-300 transform border border-gray-200 rounded-md hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-opacity-40">
						Verificar
					</button>
				</div>
			</form>
		</div>
	@endif

	@if ($step == 4)
		<div class="w-1/3 p-4 bg-white rounded-lg shadow-xl">
			<h2 class="font-bold text-xl text-gray-800">Cambiar contraseña</h2>
			<form class="flex flex-col gap-4 mt-4" wire:submit.prevent="cambiarContrasena">
				<label for="password">Contraseña nueva
					<input wire:model="password" type="password" id="password" name="password" class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-400">
				</label>
				@error('password')
				<span class="text-red-500 text-sm">La contraseña no es válida</span>
				@enderror
				<label for="password_confirmation">Repita la contraseña
					<input wire:model="password1" type="password" id="password_confirmation" name="password_confirmation" class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-400">
				</label>
				@error('password1')
				<span class="text-red-500 text-sm">Las contraseñas no coinciden</span>
				@enderror
				<button class="self-center p-2 w-28 text-lg font-medium tracking-wide bg-blue-600 text-white capitalize transition-colors duration-300 transform border border-gray-200 rounded-md hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-opacity-40">
					Guardar
				</button>
			</form>
		</div>
	@endif
	@if ($step == 5)
		<div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
			<div class="flex items-center justify-center w-12 bg-green-500">
				<svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
					<path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
				</svg>
			</div>

			<div class="px-4 py-2 -mx-3">
				<div class="mx-3">
					<span class="font-semibold text-green-500 dark:text-green-400">Exito</span>
					<p class="text-sm text-gray-600 dark:text-gray-200">Su contraseña ha sido actualizada</p>
				</div>
			</div>
		</div>
	@endif
</div>
