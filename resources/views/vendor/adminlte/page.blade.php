@extends('adminlte::master')

@inject('layoutHelper', '\JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop
@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())
@section('footer')
<div class="float-right d-none d-sm-inline">
   v3.0
</div>
<strong>
   Copyright © 2021
</strong>
@endsection
@section('body')
<div class="wrapper">
	  <!-- Preloader -->
	  <div class="preloader flex-column justify-content-center align-items-center">
		<img class="animation__shake" src="{{ asset('img/logo.png') }}" alt="AdminLTELogo" height="100" width="100">
		<br>
		<h2 class="animation__shake">
			@yield('title', config('adminlte.title', 'AdminLTE 3'))
		</h2>
		<small class="animation__shake text-info text-capitalize">cargando por favor espere...</small>
	  </div>
   {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
   <div class="content-wrapper {{ config('adminlte.classes_content_wrapper') ?? '' }}">
      {{-- Content Header --}}
      <div class="content-header">
         <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
            @yield('content_header')
         </div>
      </div>
      {{-- Main Content --}}
      <div class="content">
         <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
            @yield('content')
         </div>
      </div>
   </div>
   {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif
</div>
@stop


@section('adminlte_js')
    @stack('js')
    @yield('js')
<script>
   $(function() {
	   setTimeout(() => {
	   	$('.preloader').fadeOut("swing");
	   }, 2000);
            $(document).on('keypress', '.SoloLetras', function(e) {
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
     });

     $(document).on('keypress', '.SoloNumeros', function(e) {
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
     });
        });
</script>
@stop
