<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

         <!--Regular Datatables CSS-->
         <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
         <!--Responsive Extension Datatables CSS-->
         <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatables-tailwind.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
		@method('css')
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
                @yield('content')
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <!-- jQuery -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

        <!--Datatables -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
				$('.select2').select2({});
                var table = $('#example, .datatables').DataTable( {
                        responsive: true,
						columnDefs: [
							{ type: 'num', targets: 0 }
						],
						"order": [[ 0, "asc" ]],
						language: {
							url: '{{ asset('datatables/es.json') }}'
						},
						"pageLength": 100
                    } )
                    .columns.adjust()
                    .responsive.recalc();
            } );

			window.livewire.on('datatables', () => {
			console.log('asdasdasdsada');
            var table = $('#example, .datatables').DataTable( {
                        responsive: true,
						columnDefs: [
							{ type: 'num', targets: 0 }
						],
						"order": [[ 0, "asc" ]],
						language: {
							url: '{{ asset('datatables/es.json') }}'
						},
						"pageLength": 100
                    } )
                    .columns.adjust()
                    .responsive.recalc();
            } );
        </script>

	<script type="text/javascript">
		window.livewire.on('select2', () => {
			$('.select2').select2({});
		});


	</script>

	@yield('scripts')
    </body>
</html>
