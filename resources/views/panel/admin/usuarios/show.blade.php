@extends('adminlte::page')



@section('content_header')
<div class="container-fluid">
	<div class="mb-2 row">
	   <div class="col-sm-6">
		  <h1>
			 {{ $usuario->cedula }} {{ $usuario->nombre }} {{ $usuario->apellido }}
		  </h1>
	   </div>
	   <div class="col-sm-6">
		  <ol class="breadcrumb float-sm-right">
			 <li class="breadcrumb-item">
				<a href="{{ route('panel.index') }}">
				   Inicio
				</a>
			 </li>
			 <li class="breadcrumb-item">
				<a href="{{ route('panel.usuarios.index') }}">
				   Usuarios
				</a>
			 </li>
			 <li class="breadcrumb-item active">
				{{ $usuario->cedula }} {{ $usuario->nombre }} {{ $usuario->apellido }}
			 </li>
		  </ol>
	   </div>
	</div>
 </div>
@stop

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Usuarios</h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <p class="form-control" style="text-transform: capitalize">{{ $usuario->nombre }} {{ $usuario->apellido }}
            </p>
            {{-- {{ dd($usuario->roles()) }} --}}

            <form action="{{ route('panel.usuarios.update', ['usuario' => $usuario]) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    @forelse ($roles as $rol)

                        <label>
                            <input type="checkbox" name="roles[]" value="{{ $rol->id }}" @if ($usuario->hasRole($rol->name)) checked="true" @endif
                                class="mr-2">
                            {{ $rol->name }}
                        </label>
                    @empty
                        no hay roles
                    @endforelse
                </div>
                <button type="submit" class="btn btn-primary">Asignar Rol</button>
            </form>
        </div>
        <!-- /.card-body -->

    </div>
    <!-- /.card -->
	<div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Inicio de sesión</h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">



            <table class="table table-striped table-inverse datatables" id="actividades">
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuario->Logins->where('tipo','1') as $login)
                        <tr>
                            <td scope="row">
								{{ \Carbon\Carbon::parse($login->created_at)->format('d-m-Y h:s:i A') }}
							</td>
							<td>{{ $login->ip }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Acciones</h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">



            <table class="table table-striped table-inverse datatables" id="actividades">
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Tags</th>
						<th>Accion</th>
                        <th>Sobre</th>
						<th>Valores Nuevos</th>
						<th>Valores Anterior</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach (\DB::table('audits')->where('user_id',$usuario->id)->get() as $acciones)
                        <tr>
                            <td scope="row">
								{{ \Carbon\Carbon::parse($acciones->created_at)->format('d-m-Y h:s:i A') }}
							</td>
							<td>{{ $acciones->tags }}</td>
                            <td>
								{{ $acciones->event }}
							</td>
							<td>{{ $acciones->auditable_type }}</td>
							<td>{{ $acciones->old_values }}</td>
							<td>{{ $acciones->new_values }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

    </div>
@stop

@section('css')

@stop

@push('js')
<script>
    $(function() {
        $('.datatables').dataTable({})
    });

</script>
@endpush
