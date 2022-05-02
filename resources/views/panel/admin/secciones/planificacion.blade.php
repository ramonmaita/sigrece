<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PLANIFICACION PNF {{ $pnf->nombre }}</title>
	<style>
		body{
			font-size: 8pt;
		}
	</style>
</head>
<body>
	{{-- {{ $pnf->Nucleos }} --}}

	@foreach ($pnf->Nucleos as $nucleo)

		<center><h3>{{ $nucleo->nucleo }}</h3></center>

		{{-- {{ $nucleo->Secciones }} --}}

		<table width="100%" border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>Trayecto</td>
				<td>Seccion</td>
				<td></td>
			</tr>
			@foreach ($nucleo->Secciones->where('pnf_id',$pnf->id)->where('estatus','ACTIVA') as $seccion)
				<tr>
					<td>
						{{ $seccion->Trayecto->nombre }}
					</td>
					<td>
						{{ $seccion->nombre }}
					</td>
					<td>
						<table width="100%" border="1" cellspacing="0" cellpadding="0">
							<tr>
								<td>{{ $seccion->Plan->cohorte }}</td>
								<td>UC</td>
								<td>DOCENTE</td>
								<td>ESTATUS</td>
							</tr>
							@foreach ($seccion->DesAsignaturas->sortBy('tri_semestre') as $uc)

								<tr>
									<td>
										{{ $uc->tri_semestre }}
									</td>
									<td>
										{{ $uc->nombre }}
									</td>
									<td>
										{{ $seccion->ConsultarDocente($uc->pivot->docente_id,$uc->id)->Docente->nombre_completo }}
									</td>
									<td>
										@if($uc->estatus_carga($seccion->nombre,$seccion->Periodo->nombre))
											@if ($uc->estatus_carga($seccion->nombre,$seccion->Periodo->nombre)->docente == 'SIGRECE')
											<span style="color:green"> CERRADA POR: <b>{{ $uc->estatus_carga($seccion->nombre,$seccion->Periodo->nombre)->docente }}</b></span>
											@else
												<span style="color:green"> CARGADA POR: <b>{{ $uc->estatus_carga($seccion->nombre,$seccion->Periodo->nombre)->User->nombre }} {{ $uc->estatus_carga($seccion->nombre,$seccion->Periodo->nombre)->User->apellido }} </b></span>
											@endif

										@elseif( $seccion->Docente($uc->id)->NotasActividades()->count() > 0)
											<b style="color:blue">POR CERRAR</b>
										@else
											<b style="color:red">POR CARGAR</b>
										@endif
									</td>
								</tr>
							@endforeach
						</table>
					</td>
				</tr>
			@endforeach
		</table>

		<br>
	@endforeach
</body>
</html>
