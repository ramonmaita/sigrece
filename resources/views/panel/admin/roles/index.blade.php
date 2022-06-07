@extends('adminlte::page')

{{-- @section('title', 'SIGRECO') --}}

@section('content_header')
<div class="container-fluid">
   <div class="row mb-2">
      <div class="col-sm-6">
         <h1>
            Gestionar Roles y Permisos
         </h1>
      </div>
      <div class="col-sm-6">
         <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
               <a href="{{ route('panel.roles.index') }}">
                  Inicio
               </a>
            </li>
            <li class="breadcrumb-item active">
               Gestionar Roles y Permisos
            </li>
         </ol>
      </div>
   </div>
</div>
@stop

@section('content')


  @livewire('admin.roles-componet')
@stop

@section('css')

@stop

@section('js')
<script type="text/javascript">
   window.livewire.on('cerrar_modal', () => {
		  $('#exampleModal').modal('hide');
	 });
</script>
{{--
<script>
   $(function() {

		$(document).on('click', '#custom-tabs-three-home-tab', function(event) {
		  $('#vista').val('roles');
		  $('#create-permiso').hide('fast/800/fast', function() {
			 $('#create-rol').show('');
		  });
		});

		$(document).on('click', '#custom-tabs-three-profile-tab', function(event) {
		  $('#vista').val('permisos');
		  $('#create-rol').hide('fast/800/fast', function() {
			 $('#create-permiso').show('');
		  });
		});

	 });
</script>
--}}
{{--
<script>
   $('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text(recipient)
  // modal.find('.modal-body input').val(recipient)
})
</script>
--}}
@stop
