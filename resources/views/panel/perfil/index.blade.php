@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row  mb-2">
            <div class="col-sm-6">
                <h1>Inicio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('panel.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Perfil</li>
                </ol>
          </div>
        </div>
    </div>
@stop

@section('content')
<div class="row">
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle" src="{{  Auth::user()->adminlte_image() }}" alt="">
        </div>

        <h3 class="profile-username text-center">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h3>

        <p class="text-muted text-center">{{ Auth::user()->cedula }}</p>

        {{-- <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Followers</b> <a class="float-right">1,322</a>
          </li>
          <li class="list-group-item">
            <b>Following</b> <a class="float-right">543</a>
          </li>
          <li class="list-group-item">
            <b>Friends</b> <a class="float-right">13,287</a>
          </li>
        </ul> --}}
{{-- 
        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- About Me Box -->
   {{--  <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">About Me</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <strong><i class="fas fa-book mr-1"></i> Education</strong>

        <p class="text-muted">
          B.S. in Computer Science from the University of Tennessee at Knoxville
        </p>

        <hr>

        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

        <p class="text-muted">Malibu, California</p>

        <hr>

        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

        <p class="text-muted">
          <span class="tag tag-danger">UI Design</span>
          <span class="tag tag-success">Coding</span>
          <span class="tag tag-info">Javascript</span>
          <span class="tag tag-warning">PHP</span>
          <span class="tag tag-primary">Node.js</span>
        </p>

        <hr>

        <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
      </div>
      <!-- /.card-body -->
    </div> --}}
    <!-- /.card -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="card card-primary card-outline">
      <div class="card-header p-2">
        <h5 class="card-title">Información Personal</h5>
      </div><!-- /.card-header -->
      <div class="card-body">
        <form class="form-horizontal">
          <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Cedula</label>
            <div class="col-sm-10">
              <input type="text" class="form-control SoloNumeros" wire:model.defer="state.cedula" autocomplete="cedula" placeholder="Cedula">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputName2" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputName2" wire:model.defer="state.nombre" placeholder="Nombre">
            </div>
          </div>
           <div class="form-group row">
            <label for="inputName2" class="col-sm-2 col-form-label">Apellido</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputName2"  wire:model.defer="state.apellido" placeholder="Apellido">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Correo</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="inputEmail" placeholder="Correo"  wire:model.defer="state.email">
            </div>
          </div>

          <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </form>
      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary card-outline">
      <div class="card-header p-2">
        <h5 class="card-title">Actualizar Contraseña</h5>
      </div><!-- /.card-header -->
      <div class="card-body">
        <form class="form-horizontal">

          <div class="form-group row">
            <label for="inputName2" class="col-sm-4 col-form-label">Contraseña Actual</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="inputName2" placeholder="Contraseña Actual">
            </div>
          </div>
           <div class="form-group row">
            <label for="inputName2" class="col-sm-4 col-form-label">Nueva Contraseña</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="inputName2" placeholder="Nueva Contraseña">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputEmail" class="col-sm-4 col-form-label">Confirmar Contraseña</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="inputEmail" placeholder="Confirmar Contraseña" >
            </div>
          </div>

          <div class="form-group row">
            <div class="offset-sm-4 col-sm-8">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop

@section('css')
 {{--  --}} 
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop