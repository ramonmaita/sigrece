
@extends('adminlte::page')

@section('title', 'SIGRECO')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
<div class="card">
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
        <p class="form-control" style="text-transform: capitalize">{{ $usuario->nombre }} {{ $usuario->apellido }}</p>
        {{-- {{ dd($usuario->roles()) }} --}}

        <form action="{{ route('panel.usuarios.update',['usuario' => $usuario]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                @forelse ($roles as $rol)

                <label>
                    <input type="checkbox" name="roles[]" value="{{ $rol->id }}" @if($usuario->hasRole($rol->name)) checked="true" @endif  class="mr-2">
                    {{ $rol->name }}
                </label>
                @empty
                    no hay roles
                @endforelse
            </div>
            <button type="submit" class="btn btn-primary btn-flat">Asignar Rol</button>
        </form>
    </div>
    <!-- /.card-body -->

  </div>
  <!-- /.card -->
@stop

@section('css')

@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
