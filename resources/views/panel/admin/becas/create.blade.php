@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Añadir becado
         </h1>
      </div>
      <div class="col-sm-6">
         <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
               <a href="{{ route('panel.index') }}">
                  Inicio
               </a>
            </li>
            <li class="breadcrumb-item active">
				<a href="{{ route('panel.estudiantes.becas.index') }}">
					Becados
				</a>
            </li>
			<li class="breadcrumb-item active">
				Añadir
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')
	<form action="{{ route('panel.estudiantes.becas.store') }}" method="POST">
		@method('POST')
		@include('panel.admin.becas._form')
	</form>

@stop
