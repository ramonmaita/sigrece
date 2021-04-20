@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Corregir Periodo
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
               <a href="{{ route('panel.estudiantes.show',[$alumno]) }}">
				{{ $alumno->cedula }} {{ $alumno->nombres }} {{ $alumno->apellidos }}
               </a>
            </li>
            <li class="breadcrumb-item active">
               Corregir Periodo
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')

	@livewire('admin.alumnos.periodos.corregir', ['alumno' => $alumno])

@stop

@push('css')

@endpush

@push('js')

@endpush
