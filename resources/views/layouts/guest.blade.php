<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @laravelPWA
    @livewireStyles
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .min-h-screen-opc {
            min-height: 89vh;
        }

    </style>

    <style>
        .animated {
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }

        .animated.faster {
            -webkit-animation-duration: 500ms;
            animation-duration: 500ms;
        }

        .fadeIn {
            -webkit-animation-name: fadeIn;
            animation-name: fadeIn;
        }

        .fadeOut {
            -webkit-animation-name: fadeOut;
            animation-name: fadeOut;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

    </style>
</head>

<body class="min-h-screen bg-gray-100">
    <div class="font-sans antialiased text-gray-900">
        <!-- component -->
        <nav class="relative flex items-center justify-between w-full h-20 px-8 mx-auto bg-white shadow-md overflow-x-auto">
            <!-- logo -->
            <div class="inline-flex">
                <a class="_o6689fn" href="/">
                    <div class="hidden md:block">
                        <div class="inline-flex">

                            <img src="{{ asset('img/logo.png') }}" alt="logo" style="max-width: 50px">

                        </div>
                    </div>
                    <div class="block md:hidden">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" style="max-width: 50px">
                    </div>
                </a>
            </div>
            <div class="top-0 left-0 inline-flex float-left">

                <h4 class="items-center text-xl font-semibold leading-tight text-center text-gray-800">
                    UPTBolivar</h4>
            </div>

            <!-- end logo -->


            <!-- login -->
            <div class="flex-initial">
                <div class="relative flex items-center justify-end">

                    {{-- <div class="flex items-center mr-4">
                      <a class="inline-block px-3 py-2 rounded-full hover:bg-gray-200" href="#">
                        <div class="relative flex items-center cursor-pointer whitespace-nowrap">Become a host</div>
                      </a>
                      <div class="relative block">
                        <button type="button" class="relative inline-block px-3 py-2 rounded-full hover:bg-gray-200 ">
                          <div class="flex items-center h-5">
                            <div class="_xpkakx">
                              <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; height: 16px; width: 16px; fill: currentcolor;"><path d="m8.002.25a7.77 7.77 0 0 1 7.748 7.776 7.75 7.75 0 0 1 -7.521 7.72l-.246.004a7.75 7.75 0 0 1 -7.73-7.513l-.003-.245a7.75 7.75 0 0 1 7.752-7.742zm1.949 8.5h-3.903c.155 2.897 1.176 5.343 1.886 5.493l.068.007c.68-.002 1.72-2.365 1.932-5.23zm4.255 0h-2.752c-.091 1.96-.53 3.783-1.188 5.076a6.257 6.257 0 0 0 3.905-4.829zm-9.661 0h-2.75a6.257 6.257 0 0 0 3.934 5.075c-.615-1.208-1.036-2.875-1.162-4.686l-.022-.39zm1.188-6.576-.115.046a6.257 6.257 0 0 0 -3.823 5.03h2.75c.085-1.83.471-3.54 1.059-4.81zm2.262-.424c-.702.002-1.784 2.512-1.947 5.5h3.904c-.156-2.903-1.178-5.343-1.892-5.494l-.065-.007zm2.28.432.023.05c.643 1.288 1.069 3.084 1.157 5.018h2.748a6.275 6.275 0 0 0 -3.929-5.068z"></path></svg>
                            </div>
                          </div>
                        </button>
                      </div>
                    </div> --}}
                    @php
						$actual = \Carbon\Carbon::now()->toDateTimeString();
						// $actual = date('Y-m-d H:i:s', strtotime(\Carbon\Carbon::now()));
						// return dd($actual);
						$evento_actualizacion_datos_activo = false;
						$evento_actualizacion_datos = \App\Models\Evento::where('tipo','ACTUALIZACION DE DATOS')
						->where('evento_padre',0)
						->where('inicio','<=',$actual)
						->where('fin','>=',$actual)
						->orderBy('id','desc')
						->first();
						// return dd($evento_actualizacion_datos);
						if($evento_actualizacion_datos){
							$evento_actualizacion_datos_activo = true;
						}

						$evento_inscripcion_nuevo_activo = false;
						$evento_inscripcion_nuevo = \App\Models\Evento::where('tipo','INSCRIPCION')
						->where('evento_padre',0)
						->where('inicio','<=',$actual)
						->where('fin','>=',$actual)
						->where('aplicar','NUEVO INGRESO')
						->orderBy('id','desc')
						->first();
						if($evento_inscripcion_nuevo){
							$evento_inscripcion_nuevo_activo = true;
						}

                        $active_ni = request()->routeIs('nuevo-ingreso.index') ? true : false;
                        $active_ad = request()->routeIs('actualizar-datos.index') ||  request()->routeIs('actualizar-datos.show-form')? true : false;
                    @endphp
                    @if (Auth::check())
                        <div class="block">
                            <div class="relative inline">
                                <a href="{{ route('panel.index') }}" type="button"
                                    class="relative inline-flex items-center px-2 border rounded-full hover:shadow-lg">
                                    <div class="flex-grow-0 flex-shrink-0 block w-12 h-10">
                                        <img class="object-cover w-8 h-8 my-1 rounded-full"
                                            src="{{ Auth::user()->profile_photo_url }}"
                                            alt="{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}" />
                                    </div>

                                    <h5 class="pr-1 font-semibold">{{ Auth::user()->nombre }}
                                        {{ Auth::user()->apellido }}</h5>
                                </a>
                            </div>
                        </div>
						@if (Auth::user()->hasRole('Admin'))
                            <a href="{{ route('nuevo-ingreso.index') }}"
                                class="ml-1 inline-block px-3 py-2 rounded-full border-2 border-transparent {{ $active_ni == true ? 'bg-blue-800 text-white  hover:bg-white hover:border-blue-800 hover:text-blue-800' : 'hover:border-blue-800 hover:text-blue-800' }} ">
                                <div class="relative flex items-center cursor-pointer whitespace-nowrap">Nuevo Ingreso
                                </div>
                            </a>
                        @endif
                    @else
                        {{-- @if (\Carbon\Carbon::now())

					@endif --}}

                        {{-- @dump( $actual->greaterThanOrEqualTo($inicio)) --}}
                        @if (!request()->routeIs('login') && !request()->routeIs('raiz') )
                            <a href="{{ route('login') }}"
                                class="inline-block px-3 py-2 ml-1 border-2 border-transparent rounded-full hover:border-blue-800 hover:text-blue-800">
                                <div class="relative flex items-center cursor-pointer whitespace-nowrap">Iniciar Sesi??n
                                </div>
                            </a>
                        @endif

						@if ($evento_actualizacion_datos_activo == true)
							{{-- @if ($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin) == true) --}}
								<a href="{{ route('actualizar-datos.index') }}"
									class="inline-block px-3 py-2 ml-1 rounded-full border-2 border-transparent {{ $active_ad == true ? 'bg-blue-800 text-white  hover:bg-white hover:border-blue-800 hover:text-blue-800' : 'hover:border-blue-800 hover:text-blue-800' }} ">
									<div class="relative flex items-center cursor-pointer whitespace-nowrap">Actualizar
										Datos</div>
								</a>
							{{-- @endif --}}
						@endif

                        @if ($evento_inscripcion_nuevo_activo == true)
							{{-- @if ($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin) == true) --}}
								<a href="{{ route('nuevo-ingreso.index') }}"
									class="ml-1 inline-block px-3 py-2 rounded-full border-2 border-transparent {{ $active_ni == true ? 'bg-blue-800 text-white  hover:bg-white hover:border-blue-800 hover:text-blue-800' : 'hover:border-blue-800 hover:text-blue-800' }} ">
									<div class="relative flex items-center cursor-pointer whitespace-nowrap">Nuevo Ingreso
									</div>
								</a>
							{{-- @endif --}}
						@endif
                    @endif
                </div>
            </div>
            <!-- end login -->
        </nav>
        {{ $slot }}

        <div class="fixed inset-0 z-50 flex items-center justify-center w-full overflow-hidden main-modal h-100 animated fadeIn faster"
            style="background: rgba(0,0,0,.7); display:none">
            <div
                class="z-50 w-11/12 mx-auto overflow-y-auto bg-white border border-teal-500 rounded shadow-lg h-5/6 modal-container">
                <div class="px-6 py-4 text-left modal-content h-5/6">
                    <!--Title-->
                    <div class="flex items-center justify-between pb-3">
                        <p class="text-2xl font-bold">Manual de Inscripci??n</p>
                        <div class="z-50 cursor-pointer modal-close">
                            <svg class="text-black fill-current" xmlns="http://www.w3.org/2000/svg" width="18"
                                height="18" viewBox="0 0 18 18">
                                <path
                                    d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <!--Body-->
                    <div class="my-5 h-5/6">
                        <iframe src="{{ asset('manual_inscripcion.pdf') }}" frameborder="0" class="h-full w-100"
                            width="100%" height="80%"></iframe>
                    </div>
                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <button
                            class="p-3 px-4 text-white bg-gray-900 rounded-lg focus:outline-none modal-close hover:bg-gray-700">Cerrar</button>
                        {{-- <button
						class="p-3 px-4 ml-3 text-white bg-gray-900 rounded-lg focus:outline-none hover:bg-gray-700">Confirm</button> --}}
                    </div>
                </div>
            </div>
        </div>
        @livewireScripts()
        <!-- jQuery -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(function() {
                $(document).on('keypress', '.SoloLetras', function(e) {
                    key = e.keyCode || e.which;
                    tecla = String.fromCharCode(key).toLowerCase();
                    letras = " ??????????abcdefghijklmn??opqrstuvwxyz";
                    especiales = "8-37-39-46";

                    tecla_especial = false
                    for (var i in especiales) {
                        if (key == especiales[i]) {
                            tecla_especial = true;
                            break;
                        }
                    }

                    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                        return false;
                    }
                });

                $(document).on('keypress', '.SoloNumeros', function(e) {
                    key = e.keyCode || e.which;
                    tecla = String.fromCharCode(key).toLowerCase();
                    letras = "0123456789";
                    especiales = "8-37-39-46";

                    tecla_especial = false
                    for (var i in especiales) {
                        if (key == especiales[i]) {
                            tecla_especial = true;
                            break;
                        }
                    }

                    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                        return false;
                    }
                });


            });
        </script>
        <script>
            const modal = document.querySelector('.main-modal');
            const closeButton = document.querySelectorAll('.modal-close');

            const modalClose = () => {
                modal.classList.remove('fadeIn');
                modal.classList.add('fadeOut');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 500);
            }

            const openModal = () => {
                modal.classList.remove('fadeOut');
                modal.classList.add('fadeIn');
                modal.style.display = 'flex';
            }

            for (let i = 0; i < closeButton.length; i++) {

                const elements = closeButton[i];

                elements.onclick = (e) => modalClose();

                modal.style.display = 'none';

                window.onclick = function(event) {
                    if (event.target == modal) modalClose();
                }
            }

        </script>
    </div>

    @yield('scripts')
</body>

</html>
