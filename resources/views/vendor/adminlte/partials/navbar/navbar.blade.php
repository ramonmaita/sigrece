<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ (null !== session('color-topnav')) ? session('color-topnav') : 'navbar-lightblue navbar-dark'}}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="ml-auto navbar-nav">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')
		@if (Auth::user())
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
					<i class="fas fa-people-arrows"></i>
					Sistema
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
					<small class="dropdown-footer text-muted">Cambiar el sistema</small>
						@if (Str::upper(session('sistema')) != 'PNFA')
						<div class="dropdown-divider"></div>
						<a href="{{ route('cambiar-sistema', ['sistema' => 'PNFA']) }}" class="dropdown-item">
							<!-- Message Start -->
							<div class="media">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										<span class="float-right text-sm text-primary"><i class="fas fa-user"></i></span>
										PNFA
									</h3>
								</div>
							</div>
							<!-- Message End -->
						</a>
						@endif
						@if (Str::upper(session('sistema')) != 'SIGRECE')
						<div class="dropdown-divider"></div>
						<a href="{{ route('cambiar-sistema', ['sistema' => 'SIGRECE']) }}" class="dropdown-item">
							<!-- Message Start -->
							<div class="media">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										<span class="float-right text-sm text-primary"><i class="fas fa-user"></i></span>
										SIGRECE
									</h3>
								</div>
							</div>
							<!-- Message End -->
						</a>
						@endif
						@if (Str::upper(session('sistema')) != 'MS')
						<div class="dropdown-divider"></div>
						<a href="{{ route('cambiar-sistema', ['sistema' => 'MS']) }}" class="dropdown-item">
							<!-- Message Start -->
							<div class="media">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										<span class="float-right text-sm text-primary"><i class="fas fa-user"></i></span>
										Misión Sucre
									</h3>
								</div>
							</div>
							<!-- Message End -->
						</a>
						@endif
						<!-- Message End -->
						</a>
				</div>
			</li>
		@endif
        {{-- Configured right links --}}
		@if (Auth::user()->getRoleNames()->count() >= 2)
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
					<i class="fas fa-people-arrows"></i>
					Roles
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
					<small class="dropdown-footer text-muted">Cambiar Rol de Usuario</small>
					@foreach (Auth::user()->getRoleNames() as $item)
						<div class="dropdown-divider"></div>
						<a href="{{ route('cambiar-rol', ['rol' => $item]) }}" class="dropdown-item">
							<!-- Message Start -->
							<div class="media">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										<span class="float-right text-sm text-primary"><i class="fas fa-user"></i></span>
										@if ($item == 'Coordinador')
											Jefe de PNF
										@else
											{{ $item }}
										@endif
									</h3>
								</div>
							</div>
							<!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
					@endforeach
				</div>
			</li>
		@endif
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if (Auth::user())
            @if (config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if (config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
