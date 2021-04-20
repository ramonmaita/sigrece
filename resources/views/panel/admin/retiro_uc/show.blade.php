@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="mb-2 row">
      <div class="col-sm-6">
         <h1>
            Retiro de UC Inscritas a
         </h1>
		 <p style="margin: 2px !important">
			{{ $solicitud->Solicitante->cedula }} {{ $solicitud->Solicitante->nombre }} {{ $solicitud->Solicitante->apellido }}
		 </p>
      </div>
      <div class="col-sm-6">
         <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
               <a href="{{ route('panel.index') }}">
                  Inicio
               </a>
            </li>
            <li class="breadcrumb-item">
               <a href="{{ route('panel.retiros.index') }}">
					Retiro de Unidades Curriculares Inscritas
               </a>
            </li>
            <li class="breadcrumb-item active">
              {{ $solicitud->Solicitante->cedula }}
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')

@livewire('admin.retiros.restaurar',['alumno' => $alumno,'solicitud' => $solicitud, 'retiros' => $retiros])

@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">

</script>
@stop
