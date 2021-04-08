
@extends('adminlte::page')

@section('title', 'SIGRECO')

@section('content_header')
  <div class="container-fluid">
      <div class="row  mb-2">
          <div class="col-sm-6">
              <h1>Gestionar Roles y Permisos</h1>
          </div>
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('panel.index') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('panel.roles.index') }}">Gestionar Roles y Permisos</a></li>
                <li class="breadcrumb-item active">Ver Rol: {{ $rol->name }}</li>
              </ol>
          </div>
      </div>
  </div>
@stop

@section('content')
@if (session('mensaje'))
  <div class="callout callout-success">
    <h5>{{ session('mensaje') }}</h5>
  </div>
@endif

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Ver Rol: {{ $rol->name }}</h3>
      <div class="card-tools">
        {{-- <a href="{{ route('panel.roles.create') }}" class="btn btn-flat btn-info">Crear Nuevo Rol</a>   --}}
      </div>
     
    </div>



    <div class="card-body">
      <p class="form-control">{{ $rol->name }}</p>

      @forelse($permisos as $permiso)
        <span class="badge badge-info text-md">{{ $permiso->name }}</span>
      @empty
        no hay permisos asignados
      @endforelse 
    </div>
    <!-- /.card-body -->

  </div>
  <!-- /.card -->
@stop

@section('css')
  
@stop

@section('js')
  
@stop