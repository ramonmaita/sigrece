@extends('adminlte::page')


@section('content_header')
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1>
                   Control de Carga de Notas
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
                       Control de Carga de Notas
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    @include('alertas')
    <div class="card card-outline card-primary">

        <div class="card-body">
            <div class="row">
				@php
					$uc_totales = 0;
					$uc_cargadas_totales = 0;
					$total_secciones = 0;
				@endphp
                <div class="col-md-12">
                    <div id="accordion">
                        @foreach ($total_secciones_pnf as $pnf)
							@php
								$total_secciones +=  count($pnf['secciones']);
							@endphp
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100 collapsed" data-toggle="collapse"
                                            href="#{{ str_replace(' ','_',$pnf['pnf']) }}" aria-expanded="false"
                                            style="text-decoration: none !important">
                                            {{ $pnf['pnf'] }}

											<span class="float-right "> <span class="px-4 py-2 badge badge-pill badge-warning"> {{ count($pnf['secciones']) }} Secciones</span> </span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="{{  str_replace(' ','_',$pnf['pnf']) }}" class="collapse" data-parent="#accordion" style="">
                                    <div class="card-body table-responsive">
                                        <table class="table table-striped table-inverse ">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>Sección</th>
                                                    <th>UC En La Seccion</th>
                                                    <th>UC Cargada</th>
                                                    <th>% de Carga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total_uc = 0;
                                                    $total_uc_cargadas = 0;
                                                    // $total_uc = 0;
                                                @endphp
                                                @foreach ($pnf['secciones'] as $seccion)
                                                    <tr>
                                                        <td> <a href="{{ route('panel.estadisticas.carga-de-notas.show', ['seccion'=>$seccion['seccion'], 'periodo' => '2021']) }}"> {{ $seccion['seccion'] }}</a></td>
                                                        <td>{{ $seccion['uc_total'] }}</td>
                                                        <td>{{ $seccion['uc_cargada'] }}</td>
                                                        <td class="text-center">
                                                            <div class="progress">
                                                                <div class="progress-bar bg-primary progress-bar-striped"
                                                                    role="progressbar" aria-valuenow="{{ round($seccion['p_carga'],2) }}"
                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                    style="width: {{ round($seccion['p_carga'],2) }}%">
                                                                    <span class="sr-only">{{ round($seccion['p_carga'],2) }}% </span>
                                                                </div>
                                                            </div>
                                                            {{ round($seccion['p_carga'],2) }}%
                                                        </td>
                                                        @php
                                                            $total_uc += $seccion['uc_total'];
                                                            $total_uc_cargadas += $seccion['uc_cargada'];

															$uc_totales += $seccion['uc_total'];
															$uc_cargadas_totales += $seccion['uc_cargada'];
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    @php
                                                        $porcentage = ($total_uc != 0) ? round(($total_uc_cargadas * 100) / $total_uc, 2) : 0;
                                                        // $porcentage =0;
                                                    @endphp
                                                    <th>Total</th>
                                                    <th colspan="3" class="text-center">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-primary progress-bar-striped"
                                                                role="progressbar" aria-valuenow="{{ $porcentage }}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{ $porcentage }}%">
                                                                <span class="sr-only">{{ $porcentage }}% </span>
                                                            </div>
                                                        </div>
                                                        <small>{{ $porcentage }}%</small>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
			<div class="row">
				@php
					$porc = round(($uc_cargadas_totales * 100) / $uc_totales, 2);
				@endphp
				<div class="col-md-12 table-responsive">
					<table class="table table-striped ">
						<thead class="thead-inverse bg-primary">
							<tr>
								<th>Total de Secciones</th>
								<th>Total de UC Registradas</th>
								<th>Total de UC Cargadas</th>
								<th>% Total de Carga</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">{{ $total_secciones }}</th>
								<th>{{ $uc_totales }}</th>
								<th>{{ $uc_cargadas_totales }}</th>
								<th>{{ $porc }}%</th>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="4" class="text-center">
									<div class="progress">
										<div class="progress-bar bg-primary progress-bar-striped"
											role="progressbar" aria-valuenow="{{ $porc }}"
											aria-valuemin="0" aria-valuemax="100"
											style="width: {{ $porc }}%">
											<span class="sr-only">{{ $porc }}% </span>
										</div>
									</div>
									<small>{{ $porc }}%</small>
								</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
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

        $('.select2').select2({});

    </script>
@stop
