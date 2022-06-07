<div>
    @php
        $pnf = '';
        switch ($datos_graduando->pnf) {
            // MISION SUCRE
            case 2:
                $pnf = 'Geología y Minas';
                break;
            case 4:
                $pnf = 'Electricidad';
                break;
            case 6:
                $pnf = $datos_graduando->titulo == 1 ? 'Informática' : 'Sistemas';
                break;
            case 8:
                $pnf = 'Mecánica';
                break;
            case '10':
                $pnf = 'Tecnología de Producción Agroalimentaria';
                break;
            // CARRERAS
            case 25:
                $pnf = 'Geología y Minas';
                break;
            case 30:
                $pnf = 'Mecánica';
                break;
            case 35:
                $pnf = 'Sistemas Industriales';
                break;
            // PNF
            case 40:
                $pnf = $datos_graduando->titulo == 1 ? 'Electricidad' : 'Electricista';
                break;
            case 45:
                $pnf = 'Geociencias';
                break;
            case 50:
                $pnf = 'Informática';
                break;
            case 55:
                $pnf = $datos_graduando->titulo == 1 ? 'Mantenimiento Industrial' : 'Mantenimiento';
                break;
            case 60:
                $pnf = $datos_graduando->titulo == 1 ? 'Mecánica' : ($retVal = $datos_graduando->Alumno->sexo == 'M' ? 'Mecánico' : 'Mecánica');
                break;
            case 65:
                $pnf = 'Sistemas de Calidad y Ambiente';
                break;

            default:
                # code...
                break;
        }
    @endphp
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
				Información del Título
				<span class="text-center badge badge-pill badge-info">
					@if ($datos_graduando->pnf <= 10)
						MISIÓN SUCRE
					@elseif ($datos_graduando->pnf >= 25 && $datos_graduando->pnf <= 35)
						CARRERA
					@else
						PNF
					@endif
				</span>
			</h3>
            <div class="card-tools">
                @if (count($titulos) > 1)
                    <select class="form-control" wire:model="select_titulo">
                        @foreach ($titulos as $titulo_select)
                            @php
                                $pnf_select = '';
                                switch ($titulo_select->pnf) {
                                    // MISION SUCRE
                                    case 2:
                                        $pnf = 'Geología y Minas';
                                        break;
                                    case 4:
                                        $pnf = 'Electricidad';
                                        break;
                                    case 6:
                                        $pnf = $datos_graduando->titulo == 1 ? 'Informática' : 'Sistemas';
                                        break;
                                    case 8:
                                        $pnf = 'Mecánica';
                                        break;
                                    case '10':
                                        $pnf = 'Tecnología de Producción Agroalimentaria';
                                        break;
                                    // CARRERAS
                                    case 25:
                                        $pnf_select = 'Geología y Minas';
                                        break;
                                    case 30:
                                        $pnf_select = 'Mecánica';
                                        break;
                                    case 35:
                                        $pnf_select = 'Sistemas Industriales';
                                        break;
                                    // PNF
                                    case 40:
                                        $pnf_select = $datos_graduando->titulo == 1 ? 'Electricidad' : 'Electricista';
                                        break;
                                    case 45:
                                        $pnf_select = 'Geociencias';
                                        break;
                                    case 50:
                                        $pnf_select = 'Informática';
                                        break;
                                    case 55:
                                        $pnf_select = $datos_graduando->titulo == 1 ? 'Mantenimiento Industrial' : 'Mantenimiento';
                                        break;
                                    case 60:
                                        $pnf_select = $datos_graduando->titulo == 1 ? 'Mecánica' : ($retVal = $datos_graduando->Alumno->sexo == 'M' ? 'Mecánico' : 'Mecánica');
                                        break;
                                    case 65:
                                        $pnf_select = 'Sistemas de Calidad y Ambiente';
                                        break;

                                    default:
                                        # code...
                                        break;
                                }
                            @endphp
                            <option value="{{ $titulo_select->id }}">
                                {{ $titulo_select->titulo == 1 || $titulo_select->titulo == 3 ? 'TSU' : 'Ing' }} -
                                {{ $pnf_select }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
        <div class="card-body">
            <p class="lead uppercase font-semibold text-center">
                @if ($datos_graduando->titulo == 1)
                    {{ $retVal = @$datos_graduando->Alumno->sexo == 'M' || $datos_graduando->sexo == 'M' ? 'Técnico Superior  Universitario' : ' Técnica Superior  Universitaria' }}
                    en
                @endif

                @if ($datos_graduando->titulo == 3)
                    Técnico Superior Universitario en la Especialidad de
                @endif
                @if ($datos_graduando->titulo == 2)
                    {{ $retVal = @$datos_graduando->Alumno->sexo == 'M' || $datos_graduando->sexo == 'M' ? 'Ingeniero' : 'Ingeniera' }}
                    @if ($datos_graduando->pnf != 40 && $datos_graduando->pnf != 60)
                        en
                    @endif
                @endif

                {{ $pnf }}
            </p>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width:50%">Nro:</th>
                            <td>{{ $datos_graduando->nro_titulo }}</td>
                        </tr>
                        <tr>
                            <th>Nro Acta:</th>
                            <td>{{ $datos_graduando->nro_acta }}</td>
                        </tr>
                        <tr>
                            <th>Libro:</th>
                            <td>{{ $datos_graduando->libro }}</td>
                        </tr>
                        <tr>
                            <th>Periodo:</th>
                            <td>{{ $datos_graduando->periodo }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de Egreso:</th>
                            <td>{{ \Carbon\Carbon::parse($datos_graduando->egreso)->format('d/m/Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
