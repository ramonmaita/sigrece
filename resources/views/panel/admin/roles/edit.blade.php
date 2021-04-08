
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
                <li class="breadcrumb-item active">Crear Nuevo Rol</li>
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
        <h3 class="card-title">Gestionar Roles y Permisos</h3>
      <div class="card-tools">
        
      </div>
     
    </div>



    <div class="card-body">
      <div class="row align-items-center">
          <div class="col-sm-3"></div>
        <form action="{{ route('panel.roles.update',['role' => $rol]) }}" method="POST" class="col-sm-6" autocomplete="off">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control form-control-border border-width-2  rounded-0" name="nombre" value="{{ $rol->name }}">
          </div>
          <div class="form-group">
            @foreach($permisos as $permiso)
              <label>
                <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}" class="mr-1" @can($permiso->name) checked="true" @endcan>
                {{ $permiso->name }}
              </label>
            @endforeach 
          </div>
          <div class="form-group"><button class="btn btn-flat btn-primary btn-block">Registrar</button></div>
        </form>
      </div>
    </div>
    <!-- /.card-body -->

  </div>
  <!-- /.card -->
@stop

@section('css')
  
@stop

@section('js')
  
@stop