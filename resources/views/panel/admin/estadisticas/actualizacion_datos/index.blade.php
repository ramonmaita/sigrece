@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>
                    Actualización e Inscripción
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('panel.index') }}">
                            Inicio
                        </a>
                    </li>
                    {{-- <li class="breadcrumb-item">
                        <a href="{{ route('panel.secciones.lista') }}">
                            Secciones
                        </a>
                    </li> --}}
                    <li class="breadcrumb-item active">
                        Estadisticas
                    </li>
                    <li class="breadcrumb-item active">
                        Actualización e Inscripción
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    @include('alertas')
    {{-- <div class="row">
        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Area Chart</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="areaChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Donut Chart</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="donutChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- PIE CHART -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Pie Chart</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="pieChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col (LEFT) -->
        <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Line Chart</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="lineChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- BAR CHART -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Bar Chart</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- STACKED BAR CHART -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Stacked Bar Chart</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="stackedBarChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col (RIGHT) -->
    </div> --}}
    <!-- /.row -->
	<div class="row">
		<div class="col-md-12">
			<div class="card card-danger card-outline">
				<div class="card-header">
					<h3 class="card-title">Inscritos por PNF</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-2"  id="table-inscritos">

						</div>
						<div class="col-md-10">
							<canvas id="inscritoPorPnf"
								style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>
						</div>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
		<div class="col-md-12">
				<div class="card card-success card-outline">
					<div class="card-header">
						<h3 class="card-title">Estudiantes que Actualizaron Datos</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="chart">
							<canvas id="prueba" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
						</div>
					</div>
					<!-- /.card-body -->
				</div>
		</div>
		<div class="col-md-12">
			<div class="card card-info card-outline">
				<div class="card-header">
					<h3 class="card-title">Estudiantes Inscritos</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="chart">
						<canvas id="inscritoPorFecha" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>

    {{-- <div class="card card-outline card-primary">

        <div class="card-body">
        </div>
    </div> --}}

@stop

@section('css')

@stop

@section('js')
    <script type="text/javascript">
        window.livewire.on('cerrar_modal', () => {
            $('#exampleModal').modal('hide');
        });

        $('.select2').select2({});

    </script>
    <script>
        $(function() {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.
            // var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

            // var areaChartData = {
            //     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            //     datasets: [{
            //             label: 'Digital Goods',
            //             backgroundColor: 'rgba(60,141,188,0.9)',
            //             borderColor: 'rgba(60,141,188,0.8)',
            //             pointRadius: false,
            //             pointColor: '#3b8bba',
            //             pointStrokeColor: 'rgba(60,141,188,1)',
            //             pointHighlightFill: '#fff',
            //             pointHighlightStroke: 'rgba(60,141,188,1)',
            //             data: [28, 48, 40, 19, 86, 27, 90]
            //         },
            //         {
            //             label: 'Electronics',
            //             backgroundColor: 'rgba(210, 214, 222, 1)',
            //             borderColor: 'rgba(210, 214, 222, 1)',
            //             pointRadius: false,
            //             pointColor: 'rgba(210, 214, 222, 1)',
            //             pointStrokeColor: '#c1c7d1',
            //             pointHighlightFill: '#fff',
            //             pointHighlightStroke: 'rgba(220,220,220,1)',
            //             data: [65, 59, 80, 81, 56, 55, 40]
            //         },
            //     ]
            // }

            // var areaChartOptions = {
            //     maintainAspectRatio: false,
            //     responsive: true,
            //     legend: {
            //         display: false
            //     },
            //     scales: {
            //         xAxes: [{
            //             gridLines: {
            //                 display: false,
            //             }
            //         }],
            //         yAxes: [{
            //             gridLines: {
            //                 display: false,
            //             }
            //         }]
            //     }
            // }

            // // This will get the first returned node in the jQuery collection.
            // new Chart(areaChartCanvas, {
            //     type: 'line',
            //     data: areaChartData,
            //     options: areaChartOptions
            // })

            // //-------------
            // //- LINE CHART -
            // //--------------
            // var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            // var lineChartOptions = $.extend(true, {}, areaChartOptions)
            // var lineChartData = $.extend(true, {}, areaChartData)
            // lineChartData.datasets[0].fill = false;
            // lineChartData.datasets[1].fill = false;
            // lineChartOptions.datasetFill = false

            // var lineChart = new Chart(lineChartCanvas, {
            //     type: 'line',
            //     data: lineChartData,
            //     options: lineChartOptions
            // })

            // //-------------
            // //- DONUT CHART -
            // //-------------
            // // Get context with jQuery - using jQuery's .get() method.
            // var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            // var donutData = {
            //     labels: [
            //         'Chrome',
            //         'IE',
            //         'FireFox',
            //         'Safari',
            //         'Opera',
            //         'Navigator',
            //     ],
            //     datasets: [{
            //         data: [700, 500, 400, 600, 300, 100],
            //         backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            //     }]
            // }
            // var donutOptions = {
            //     maintainAspectRatio: false,
            //     responsive: true,
            // }
            // //Create pie or douhnut chart
            // // You can switch between pie and douhnut using the method below.
            // new Chart(donutChartCanvas, {
            //     type: 'doughnut',
            //     data: donutData,
            //     options: donutOptions
            // })

            // //-------------
            // //- PIE CHART -
            // //-------------
            // // Get context with jQuery - using jQuery's .get() method.
            // var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            // var pieData = donutData;
            // var pieOptions = {
            //     maintainAspectRatio: false,
            //     responsive: true,
            // }
            // //Create pie or douhnut chart
            // // You can switch between pie and douhnut using the method below.
            // new Chart(pieChartCanvas, {
            //     type: 'pie',
            //     data: pieData,
            //     options: pieOptions
            // })

            // //-------------
            // //- BAR CHART -
            // //-------------
            // var barChartCanvas = $('#barChart').get(0).getContext('2d')
            // var barChartData = $.extend(true, {}, areaChartData)
            // var temp0 = areaChartData.datasets[0]
            // var temp1 = areaChartData.datasets[1]
            // barChartData.datasets[0] = temp1
            // barChartData.datasets[1] = temp0

            // var barChartOptions = {
            //     responsive: true,
            //     maintainAspectRatio: false,
            //     datasetFill: false
            // }

            // new Chart(barChartCanvas, {
            //     type: 'bar',
            //     data: barChartData,
            //     options: barChartOptions
            // })

            // //---------------------
            // //- STACKED BAR CHART -
            // //---------------------
            // var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
            // var stackedBarChartData = $.extend(true, {}, barChartData)

            // var stackedBarChartOptions = {
            //     responsive: true,
            //     maintainAspectRatio: false,
            //     scales: {
            //         xAxes: [{
            //             stacked: true,
            //         }],
            //         yAxes: [{
            //             stacked: true
            //         }]
            //     }
            // }

            // new Chart(stackedBarChartCanvas, {
            //     type: 'bar',
            //     data: stackedBarChartData,
            //     options: stackedBarChartOptions
            // })





            $.ajax({
                type: "get",
                url: "{{ route('panel.estadisticas.actualizacion-de-datos.data') }}",
                data: "",
                dataType: "json",
                success: function(response) {
                    console.log(response)

                    //---------------------
                    //- STACKED BAR CHART - PRUEBA
                    //---------------------

                    var EstudiantesActualizados = {
                        labels: response.label,
                        datasets: [{
                            label: 'ESTUDIANTES ACTUALIZADOS',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: response.datos
                        }]
                    }

                    var EstudiantesInscritos = {
                        labels: response.label_inscritos,
                        datasets: [{
                            label: 'ESTUDIANTES INSCRITOS',
                            backgroundColor: 'rgba(30,90,188,0.9)',
                            borderColor: 'rgba(30,90,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(30,90,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(30,90,188,1)',
                            data: response.datos_inscritos
                        }]
                    }
                    // var stackedBarChartCanvas =
                    var stackedEstudiantesActualizados = $.extend(true, {}, EstudiantesActualizados)
                    var stackedEstudiantesInscritos = $.extend(true, {}, EstudiantesInscritos)

                    var stackedBarChartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            xAxes: [{
                                stacked: true,
                            }],
                            yAxes: [{
                                stacked: true
                            }]
                        }
                    }

                    new Chart($('#prueba').get(0).getContext('2d'), {
                        type: 'bar',
                        data: stackedEstudiantesActualizados,
                        options: stackedBarChartOptions
                    })

					new Chart($('#inscritoPorFecha').get(0).getContext('2d'), {
                        type: 'bar',
                        data: stackedEstudiantesInscritos,
                        options: stackedBarChartOptions
                    })


					//-------------
					//- DONUT CHART -
					//-------------
					// Get context with jQuery - using jQuery's .get() method.
					var GraficaInscirtosPnf = $('#inscritoPorPnf').get(0).getContext('2d')
					var InscritosPorPnfData = {
						labels: [
							response.data_inscritos_pnf[40]['pnf'],
							response.data_inscritos_pnf[45]['pnf'],
							response.data_inscritos_pnf[50]['pnf'],
							response.data_inscritos_pnf[55]['pnf'],
							response.data_inscritos_pnf[60]['pnf'],
							response.data_inscritos_pnf[65]['pnf'],
							response.data_inscritos_pnf[70]['pnf'],
							response.data_inscritos_pnf[75]['pnf'],
							response.data_inscritos_pnf[80]['pnf'],
							response.data_inscritos_pnf[85]['pnf'],
							response.data_inscritos_pnf[90]['pnf'],
							response.data_inscritos_pnf[95]['pnf'],
						],
						datasets: [{
							data: [
								response.data_inscritos_pnf[40]['cantidad'],
								response.data_inscritos_pnf[45]['cantidad'],
								response.data_inscritos_pnf[50]['cantidad'],
								response.data_inscritos_pnf[55]['cantidad'],
								response.data_inscritos_pnf[60]['cantidad'],
								response.data_inscritos_pnf[65]['cantidad'],
								response.data_inscritos_pnf[70]['cantidad'],
								response.data_inscritos_pnf[75]['cantidad'],
								response.data_inscritos_pnf[80]['cantidad'],
								response.data_inscritos_pnf[85]['cantidad'],
								response.data_inscritos_pnf[90]['cantidad'],
								response.data_inscritos_pnf[95]['cantidad']
							],
							backgroundColor: [
								'#00a65a',
								'#f56954',
								'#00c0ef',
								'#7ef0f2',
								'#114e4f',
								'#004d01',
								'#f5f107',
								'#52500c',
								'#f39c12',
								'#f39d12',
								'#f79c12',
								'#f35c12'
							],

						}]
					}
					var donutOptions = {
						maintainAspectRatio: false,
						responsive: true,
					}

					var table ='<table class="table table-stripped table-hover table-sm"><thead><tr><th>PNF</th><th>Inscritos</th></tr></thead><tbody>'
					// var table =''
					var total = 0;
					$.each(response.data_inscritos_pnf, function (indexInArray, valueOfElement) {
						 console.log('index '+indexInArray);
						 console.log('value '+valueOfElement.pnf);
						 console.log('value '+valueOfElement.cantidad);
						table = table + '<tr><td>'+valueOfElement.pnf+'</td><td>'+valueOfElement.cantidad+'</td></tr>';
						// table =table + ' '+valueOfElement.pnf+' '+valueOfElement.cantidad+' <br>';
						total = total + valueOfElement.cantidad;
					});
					table = table + '<tr><th>Total</th><th>'+total+'</th></tr></tbody></table>';
					$('#table-inscritos').html(table);
					//Create pie or douhnut chart
					// You can switch between pie and douhnut using the method below.
					new Chart(GraficaInscirtosPnf, {
						type: 'doughnut',
						data: InscritosPorPnfData,
						options: donutOptions
					})
                }
            })
        });

    </script>
@stop
