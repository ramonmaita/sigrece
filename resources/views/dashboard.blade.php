{{-- @role('Admin') --}}


@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>Inicio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="#">Inicio</a></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">Inicio</h3>
							<div class="card-tools">
								<!-- Buttons, labels, and many other things can be placed here! -->
								<!-- Here is a label for example -->
							</div>
							<!-- /.card-tools -->
						</div>
						<!-- /.card-header -->
						@include('alertas')
						<div class="card-body">
							Bienvenido {{ Auth::user()->nombre_completo }}
						</div>
						<!-- /.card-body -->
					</div>
				</div>
				<div class="col-md-12">
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">Periodo Activo</h3>
							<div class="card-tools">
								<!-- Buttons, labels, and many other things can be placed here! -->
								<!-- Here is a label for example -->
							</div>
							<!-- /.card-tools -->
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							Periodo: {{ \App\Models\Periodo::where('estatus',0)->first()->nombre }}
						</div>
						<!-- /.card-body -->
					</div>
				</div>
			</div>
        </div>
		<div id="content" class="col-md-9">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title">CALENDARIO DE EVENTOS</h3>
					<div class="card-tools">
						<!-- Buttons, labels, and many other things can be placed here! -->
						<!-- Here is a label for example -->
					</div>
					<!-- /.card-tools -->
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<div id="calendar"></div>
					<div class="modal fade" id="modal-event" tabindex="-1" role="dialog" aria-labelledby="modal-eventLabel"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="event-title"></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div id="event-description" class=""></div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.card-body -->
		</div>
    </div>


    <!-- /.card -->
@stop

@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> --}}
    <link rel='stylesheet' type='text/css' href="{{ asset('css/fullcalendar.css') }}" />
@endpush

@push('js')
    <script type='text/javascript' src="{{ asset('js/moment.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('js/fullcalendar.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('js/locale/es.js') }}"></script>
    <script>
        function addZero(i) {
            if (i < 10) {
                i = '0' + i;
            }
            return i;
        }

        var hoy = new Date();
        var dd = hoy.getDate();
        if (dd < 10) {
            dd = '0' + dd;
        }

        if (mm < 10) {
            mm = '0' + mm;
        }

        var mm = hoy.getMonth() + 1;
        var yyyy = hoy.getFullYear();

        dd = addZero(dd);
        mm = addZero(mm);

        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: yyyy + '-' + mm + '-' + dd,
                buttonIcons: true, // show the prev/next text
                weekNumbers: false,
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: "{{ route('panel.eventos.data') }}",
                        dataType: 'json',
                        success: function(doc) {
                            var events = [];
                            if (!!doc.eventos) {
                                $.map(doc.eventos, function(r) {
                                    events.push({
                                        id: r.id,
                                        title: r.nombre,
                                        start: r.inicio,
                                        end: r.fin,
                                        description: r.descripcion,
                                        color: '#3A87AD',
                                        textColor: '#ffffff'
                                    });
                                });
                            }
                            callback(events);
                        }
                    });
                },
                dayClick: function(date, jsEvent, view) {
                    alert('Has hecho click en: ' + date.format());
                },
                eventClick: function(calEvent, jsEvent, view) {
					var inicio = new Date(calEvent.start._i)
					var fin = new Date(calEvent.end._i)
					inicio =  inicio.toLocaleString('es-ES',{'hour12' : true});
					fin =  fin.toLocaleString('es-ES',{'hour12' : true});
                    $('#event-title').text(calEvent.title);
                    $('#event-description').html(calEvent.description+' desde el '+inicio+' hasta el '+fin);
                    $('#modal-event').modal();
                },
            });
        });
    </script>
    <script>
        console.log('Hi!');
    </script>
@endpush



{{-- @else --}}
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout> --}}


{{-- @endrole --}}
