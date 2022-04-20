<div>
    <form class="form-horizontal" method="POST" wire:submit.prevent='updateDatos'>
		<div class="form-group row">
			<label for="inputEmail" class="col-sm-3 col-form-label">Nacionalidad</label>
			<div class="col-sm-9">
				<select wire:model="nacionalidad" id="nacionalidad" class="form-control">
					<option value="V">Venezolano</option>
					<option value="E">Extranjero</option>
					<option value="P">Pasaporte</option>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="p_nombre" class="col-sm-3 col-form-label">Cédula</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" value="" wire:model='cedula' readonly>
			</div>
		</div>
		<div class="form-group row">
			<label for="p_nombre" class="col-sm-3 col-form-label">Primer Nombre</label>
			<div class="col-sm-9">
				<input type="text" class="form-control @error('p_nombre') is-invalid @enderror SoloLetras" wire:model="p_nombre" id="p_nombre" placeholder="Primer Nombre">
				@error('p_nombre')
				<small class="text-danger">
				{{ $message }}
				</small>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="s_nombre" class="col-sm-3 col-form-label">Segundo Nombre</label>
			<div class="col-sm-9">
				<input type="text" class="form-control @error('s_nombre') is-invalid @enderror SoloLetras" wire:model="s_nombre" id="s_nombre" placeholder="Segundo Nombre">
				@error('s_nombre')
				<small class="text-danger">
				{{ $message }}
				</small>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="p_apellido" class="col-sm-3 col-form-label">Primer Apellido</label>
			<div class="col-sm-9">
				<input type="text" class="form-control @error('p_apellido') is-invalid @enderror SoloLetras" wire:model="p_apellido" id="p_apellido" placeholder="Primer Apellido">
				@error('p_apellido')
				<small class="text-danger">
				{{ $message }}
				</small>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="s_apellido" class="col-sm-3 col-form-label">Segundo Apellido</label>
			<div class="col-sm-9">
				<input type="text" class="form-control @error('s_apellido') is-invalid @enderror SoloLetras" wire:model="s_apellido" id="s_apellido" placeholder="Segundo Apellido">
				@error('s_apellido')
				<small class="text-danger">
				{{ $message }}
				</small>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="inputEmail" class="col-sm-3 col-form-label">Sexo</label>
			<div class="col-sm-9">
				<select wire:model="sexo" id="sexo" class="form-control  @error('sexo') is-invalid @enderror">
					<option value="F">Femenino</option>
					<option value="M">Masculino</option>
				</select>
				@error('sexo')
				<small class="text-danger">
				{{ $message }}
				</small>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="fechan" class="col-sm-3 col-form-label">Fecha de Nacimiento</label>
			<div class="col-sm-9">
				<input type="date" class="form-control  @error('sexo') is-invalid @enderror" wire:model="fechan" id="fechan" placeholder="Fecha de Nacimiento">
				@error('fechan')
				<small class="text-danger">
				{{ $message }}
				</small>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="lugarn" class="col-sm-3 col-form-label">Lugar de Nacimiento</label>
			<div class="col-sm-9">
				<input type="text" class="form-control  @error('lugarn') is-invalid @enderror" wire:model="lugarn" id="lugarn" placeholder="Lugar de Nacimiento">
				@error('lugarn')
				<small class="text-danger">
				{{ $message }}
				</small>
				@enderror
			</div>
		</div>
		<div class="form-group row">
			<div class="offset-sm-2 col-sm-10">
				<button type="submit" class="btn btn-primary" wire:click="updateDatos">Guardar</button>
			</div>
		</div>
	</form>
</div>
