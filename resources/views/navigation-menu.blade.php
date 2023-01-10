@php
	$menu = [];
	$actual = \Carbon\Carbon::now()->toDateTimeString();
	$evento_inscripcion_activo = false;
	$evento_inscripcion = \App\Models\Evento::where('tipo','INSCRIPCION')
	->where('evento_padre',0)
	->where('inicio','<=',$actual)
	->where('fin','>=',$actual)
	->orderBy('id','desc')
	->first();
	// dd($actual);
	// dd($evento_inscripcion);


			$inicio_h = \Carbon\Carbon::createFromFormat('H:i a', '08:00 AM');
			$fin_h = \Carbon\Carbon::createFromFormat('H:i a', '09:00 PM');
			$check_hora = \Carbon\Carbon::now()->between($inicio_h, $fin_h, true);
			$cerrado = true;
			if($check_hora || Auth::user()->hasRole('SupervisorNotas') || Auth::user()->hasRole('Admin')){
				$cerrado = false;
			}else{
				$cerrado = true;
			}

	if($evento_inscripcion){
		$evento_inscripcion_activo = true;
		$inscripcion_ruta = ($evento_inscripcion->aplicar == 'REGULARES' ) ? 'panel.estudiante.inscripciones.regulares.index' :'panel.estudiante.inscripciones.nuevo-ingreso.index'  ;

		// if(Auth::user()->Alumno->IngresoActual()){
		// 	$inscripcion_ruta = ($evento_inscripcion->aplicar == 'REGULARES' ) ? 'panel.estudiante.inscripciones.regulares.index' :'panel.estudiante.inscripciones.nuevo-ingreso.index'  ;
		// }else{
		// 	$inscripcion_ruta = ($evento_inscripcion->aplicar == 'REGULARES' && Auth::user()->Alumno->IngresoActual()->tipo != 'REINGRESO') ? 'panel.estudiante.inscripciones.nuevo-ingreso.index' : 'panel.estudiante.inscripciones.regulares.index' ;
		// }
	}else{
		$fin = \Carbon\Carbon::create(2021, 10, 15, 23, 59, 00);
		$actual = \Carbon\Carbon::now();

		if ($actual->lessThanOrEqualTo($fin) == true) {
			$evento_inscripcion = \App\Models\Evento::where('tipo','INSCRIPCION')
			->where('evento_padre',0)
			->orderBy('id','desc')
			->first();
			$evento_inscripcion_activo = true;
			$inscripcion_ruta = ($evento_inscripcion->aplicar == 'REGULARES' ) ? 'panel.estudiante.inscripciones.regulares.index' :'panel.estudiante.inscripciones.nuevo-ingreso.index'  ;

			// if(Auth::user()->Alumno->IngresoActual()){
			// 	$inscripcion_ruta = ($evento_inscripcion->aplicar == 'REGULARES' && Auth::user()->Alumno->IngresoActual()->tipo != 'REINGRESO') ? 'panel.estudiante.inscripciones.nuevo-ingreso.index' : 'panel.estudiante.inscripciones.regulares.index' ;
			// }else{
			// 	$inscripcion_ruta = ($evento_inscripcion->aplicar == 'REGULARES' ) ? 'panel.estudiante.inscripciones.regulares.index' :'panel.estudiante.inscripciones.nuevo-ingreso.index'  ;
			// }
		}
	}
	// $inicio = \Carbon\ Carbon::create(2021, 4, 8, 8, 30, 00);
	// $fin = \Carbon\Carbon::create(2021, 4, 25, 23, 59, 00);
    if(Auth::user()->hasRole('Estudiante') && session('rol') == 'Estudiante'){
		if ($evento_inscripcion_activo == true) {
		// if ($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin) == true) {
			$menu = [
				[
					'nombre' => 'Inicio',
					'route' => route('panel.estudiante.index'),
					'active' => request()->routeIs('panel.estudiante.index'),
				],
				[
					'nombre' => 'Inscripción',
					'route' => route($inscripcion_ruta),
					'active' => request()->routeIs($inscripcion_ruta),
				],
				[
					'nombre' => 'Documentos',
					'route' => route('panel.estudiante.documentos.index'),
					'active' => request()->routeIs('panel.estudiante.documentos.index'),
				],
			];
		} else {
			$menu = [
				[
					'nombre' => 'Inicio',
					'route' => route('panel.estudiante.index'),
					'active' => request()->routeIs('panel.estudiante.index'),
				],
				[
					'nombre' => 'Documentos',
					'route' => route('panel.estudiante.documentos.index'),
					'active' => request()->routeIs('panel.estudiante.documentos.index'),
				],
			];
		}

	}elseif (Auth::user()->hasRole('Docente') && session('rol') == 'Docente') {
        $menu = [
            [
                'nombre' => 'Inicio',
                'route' => route('panel.docente.index'),
                'active' => request()->routeIs('panel.docente.index'),
            ],
            [
                'nombre' => 'Secciones Asignadas',
                'route' =>  route('panel.docente.secciones.index'),
                'active' => request()->routeIs('panel.docente.secciones.index') ? true : request()->routeIs('panel.docentes.secciones.cargar-nota'),
            ],
			[
                'nombre' => 'Mis Solicitudes',
                'route' =>  route('panel.docente.solicitudes.index'),
                'active' => request()->routeIs('panel.docente.solicitudes.index') ? true : request()->routeIs('panel.docentes.solicitudes.create'),
            ],
        ];
    }elseif (Auth::user()->hasRole('Coordinador') && session('rol') == 'Coordinador') {
        $menu = [
            [
                'nombre' => 'Inicio',
                'route' => route('panel.coordinador.index'),
                'active' => request()->routeIs('panel.coordinador.index'),
            ],
            [
                'nombre' => 'Secciones',
				'route' => route('panel.coordinador.secciones.index'),
                'active' => request()->routeIs('panel.coordinador.secciones.index'),
            ],
			[
                'nombre' => 'Planificación',
                'route' => route('panel.coordinador.planificacion'),
                'active' => request()->routeIs('panel.coordinador.planificacion'),
            ],
			[
                'nombre' => 'Solicitudes',
                'route' => route('panel.coordinador.solicitudes.index'),
                'active' => request()->routeIs('panel.coordinador.solicitudes.index'),
            ],
        ];
    }elseif (Auth::user()->hasRole('Auxiliar') && session('rol') == 'Auxiliar') {
        $menu = [
            [
                'nombre' => 'Inicio',
                'route' => route('panel.auxiliar.index'),
                'active' => request()->routeIs('panel.auxuliar.index'),
            ],

        ];

		if (Auth::user()->hasRole('SuperAdmin') || Auth::user()->hasRole('SupervisorNotas')) {
			array_push($menu,
			[
                'nombre' => 'Registro de Asignado',
				'route' => route('panel.auxiliar.inscripciones.nuevo-ingreso.asignados.index_asignado'),
                'active' => request()->routeIs('panel.auxiliar.inscripciones.nuevo-ingreso.asignados.index_asignado'),
            ],[
                'nombre' => 'Inscribir',
                'route' => route('panel.auxiliar.inscripciones.nuevo-ingreso.index_alumno'),
                'active' => request()->routeIs('panel.auxiliar.inscripciones.nuevo-ingreso.index_alumno'),
            ],[
				'nombre' => 'Registro de No Asignado',
				'route' => route('panel.auxiliar.inscripciones.nuevo-ingreso.flotante.index_flotante'),
                'active' => request()->routeIs('panel.auxiliar.inscripciones.nuevo-ingreso.flotante.index_flotante'),
			]);
		}elseif (Auth::user()->hasPermissionTo('RegistrarAlumno') && $cerrado != true) {
			array_push($menu, [
				'nombre' => 'Registro de No Asignado',
				'route' => route('panel.auxiliar.inscripciones.nuevo-ingreso.flotante.index_flotante'),
                'active' => request()->routeIs('panel.auxiliar.inscripciones.nuevo-ingreso.flotante.index_flotante'),
			],[
                'nombre' => 'Inscribir',
                'route' => route('panel.auxiliar.inscripciones.nuevo-ingreso.index_alumno'),
                'active' => request()->routeIs('panel.auxiliar.inscripciones.nuevo-ingreso.index_alumno'),
            ],);
		}
    }
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('panel.index') }}">
                        <x-jet-application-mark class="block w-auto h-9" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
					{{-- @if (Auth::user()->hasRole('Admin'))
						<x-jet-nav-link href="{{ route('panel.index') }}" :active="request()->routeIs('panel.index')">
                            <span  class="p-2 text-white bg-blue-600 rounded-full" >Panel Admin</span>
						</x-jet-nav-link>
					@endif --}}
                    @forelse ($menu as $item)
						@if ($item['nombre'] == 'Planificación')

                        <x-jet-nav-link href="{{ $item['route'] }}" target="_blank" :active="$item['active']">
                            {{ $item['nombre'] }}
                        </x-jet-nav-link>
						@else
                        <x-jet-nav-link href="{{ $item['route'] }}" :active="$item['active']">
                            {{ $item['nombre'] }}
                        </x-jet-nav-link>
						@endif
					@empty
					<x-jet-nav-link href="#" :active="false">

					</x-jet-nav-link>
                    @endforelse
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
				<!-- ROLES Dropdown -->
				@if (Auth::user()->getRoleNames()->count() >= 2)
					<div class="relative ml-3">
						<x-jet-dropdown align="right" width="60">
							<x-slot name="trigger">
								<span class="inline-flex rounded-md">
									<button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
										Roles

										<svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
											<path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
										</svg>
									</button>
								</span>
							</x-slot>
							<x-slot name="content">
								<div class="w-60">
									<div class="block px-4 py-2 text-xs text-gray-400">
										{{ __('Cambiar Rol de Usuario') }}
									</div>
									@foreach (Auth::user()->getRoleNames()  as $item)
									<x-jet-dropdown-link href="{{ route('cambiar-rol',['rol' => $item]) }}">
										@if ($item == 'Coordinador')
											Jefe de PNF
										@else
											{{ $item }}
										@endif
									</x-jet-dropdown-link>
									@endforeach
								</div>
							</x-slot>
						</x-jet-dropdown>
					</div>
				@endif

                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="relative ml-3">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm transition duration-150 ease-in-out border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <img class="object-cover w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                                        {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Mi Cuenta') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Perfil') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Logout') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
			{{-- @if (Auth::user()->hasRole('Admin'))
				<x-jet-responsive-nav-link href="{{ route('panel.index') }}" :active="request()->routeIs('panel.index')">
					Panel Admin
				</x-jet-responsive-nav-link>
			@endif --}}
            @forelse ($menu as $item)
                <x-jet-responsive-nav-link href="{{ $item['route'] }}" :active="$item['active']">
                    {{ $item['nombre'] }}
                </x-jet-responsive-nav-link>
			@empty
			<x-jet-responsive-nav-link href="#" :active="false">

			</x-jet-responsive-nav-link>
            @endforelse
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex-shrink-0 mr-3">
                        <img class="object-cover w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Perfil') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-jet-responsive-nav-link>
                </form>

				<!-- ROLES -->
                @if (Auth::user()->getRoleNames()->count() >= 2)
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-center text-gray-600">
                        Roles
                    </div>

                    {{-- <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan --}}

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-center text-gray-600 ">
                        {{ __('Cambiar Rol de Usuario') }}
                    </div>

					@foreach (Auth::user()->getRoleNames()  as $item)
						<x-jet-responsive-nav-link href="{{ route('cambiar-rol',['rol' => $item]) }}">
							@if ($item == 'Coordinador')
								Jefe de PNF
							@else
								{{ $item }}
							@endif
						</x-jet-responsive-nav-link>
					@endforeach
                @endif

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
