@extends('adminlte::page')


@section('content_header')
<div class="container-fluid">
   <div class="row mb-2">
      <div class="col-sm-6">
         <h1>
            Secciones
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
               <a href="{{ route('panel.secciones.index') }}">
                  Secciones
               </a>
            </li>
            <li class="breadcrumb-item active">
               Editar Configuración
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')

      {{-- @livewire('admin.secciones') --}}

      <div class="card card-primary card-outline">
         <div class="card-body table-responsive">
            {{-- {{ $seccion->DesAsignaturas }} --}}
            {{-- @dump( $seccion->Docentes->where('id',1) ) --}}
         {{--    @foreach ( $seccion->DesAsignaturas as $element)
               {{ $element}}
            @endforeach --}}
            <form action="{{ route('panel.secciones.actualizar_config') }}" method="post" autocomplete="off">
               @csrf
               @method('post')
               <input type="hidden" name="seccion_id" value="{{ $seccion->id }}">
               <table class="table table-hover table-striped">
                  <thead>
                     <tr>
                        <th>N°</th>
                        <th>Unidad Curricular</th>
                        <th>Trimeste/Semestre/Año</th>
                        <th>Docente</th>
                        {{-- <th></th> --}}
                      </tr>
                  </thead>
                  <tbody>
                      @php $n = 1; @endphp
                     @foreach ($seccion->Plan->Asignaturas->where('trayecto_id',$seccion->trayecto->id) as $asignatura)
                        <tr class="bg-{{ ($seccion->checkAsignatura($asignatura->id) == true) ? 'success' :'danger' }}"{{--  style=" background-color: lightgreen" --}}>
                           <th colspan="4" style="text-align: center;"  for="{{  $asignatura->codigo }}">
                             <label for="{{  $asignatura->codigo }}" style="width: 95%; cursor: pointer; height: 100%;;" class="check-asignatura">
                                   <input type="checkbox" name="n[]" checked="true" hidden="">
                               {{  $asignatura->nombre }}
                             </label>
                               <input type="checkbox" {{ ($seccion->checkAsignatura($asignatura->id) == true) ? 'checked="true"' :''}} id="{{  $asignatura->codigo }}" value="{{ $asignatura->id }}" name="asignaturas_ins[]" hidden="true" {{-- class="check-asignatura" --}}>
                           </th>
                           @forelse($asignatura->DesAsignaturas as $desasignatura)
                               <tr>
                                 <td>

                                   {{ $n }}
                                   <input type="hidden" name="{{ $desasignatura->id }}" value="{{ $n }}">
                                 </td>
                                 <td>
                                   {{ $desasignatura->nombre }}
                                   <input type="hidden" name="codigo" value="{{ $desasignatura->codigo }}">
                                 </td>
                                 <td>
                                   {{ $desasignatura->tri_semestre }}
                                   <input type="hidden" name="codigo_anual" value="{{ $desasignatura->asignatura_id }}">
                                 </td>
                                 <td>
                                  {{-- {{ $seccion->checkDocente(0) }} --}}
                                   <select name="docente_id[{{$desasignatura->id}}]" class="{{  $asignatura->codigo }} select2" {{ ($seccion->checkAsignatura($asignatura->id) == true) ? '' :'disabled'}}>
                                     {{-- <option value="0">SIN ASIGNAR</option> --}}
                                     @foreach($docentes as $docente)
                                       <option value="{{ $docente->id }}" {{ ($seccion->checkDocente($docente->id,$desasignatura->id) == true) ? 'selected' :'' }}> {{ $docente->cedula .' '. $docente->nombres .' '. $docente->apellidos }} </option>
                                     @endforeach
                                   </select>
                                 </td>
                                 {{-- <td> --}}
                                   {{-- <input type="checkbox" checked="true"  class="{{  $asignatura->codigo }}" value="{{ $desasignatura->codigo }}" name="asignaturas_ins[]" hidden="true"> --}}
                                 {{-- </td> --}}
                               </tr>
                             @php $n++; @endphp

                             @empty
                             @endforelse
                        </tr>
                     @endforeach
                  </tbody>
               </table>
                <div class="form-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </form>
         </div>
      </div>
      
    
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
   window.livewire.on('cerrar_modal', () => {
        $('#exampleModal').modal('hide');
    });
</script>
<script>
    $(function() {
      $('.select2').select2({});
      $(document).on('click','.check-asignatura', function() {
        var id = $(this).attr('for');
        var attr = $('.'+id).attr('disabled')
        // alert($(this).attr('for'))
          // $('.'+id).attr('disabled', 'true')
        if ( $("#"+id+":checked").length != 1) {
          
          $('.'+id).removeAttr('disabled')
          // $(this).parent().parent().children().css("background-color", "lightgreen");
          $(this).parent().parent().children().removeClass('bg-danger');
          $(this).parent().parent().children().addClass('bg-success');
        }else{
          $('.'+id).attr('disabled', 'true')
          // $(this).parent().parent().children().css("background-color", "lightgrey");
          $(this).parent().parent().children().removeClass('bg-success');
          $(this).parent().parent().children().addClass('bg-danger');
        }
        console.log($("#"+id+":checked").length)
      }); 
    });
  </script>
@stop
