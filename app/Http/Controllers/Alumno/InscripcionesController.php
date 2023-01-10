<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Ingreso;
use App\Models\Inscripcion;
use App\Models\Inscrito;
use App\Models\Periodo;
use App\Models\Seccion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class InscripcionesController extends Controller
{


	public function porcentajeAprobado(Alumno $alumno, $trayecto, $porcentaje, $incluir_psi = true)
	{
		$n_uc = $alumno->Plan->Asignaturas->where('trayecto_id',$trayecto)->count();
		// $t = $n_uc-1;
		// $n_uc = 7;
		if($incluir_psi == false){
			$n_uc = $n_uc-1;
		}
		$t = ($porcentaje*$n_uc)/100;
		return round($t,0);
	}


	public function CheckPIU(Alumno $alumno )
	{
		// return $alumno->PIU;
		$aprobadas = 0;
		$reprobadas = 0;

		foreach ($alumno->PIU as $key => $asignatura) {
			$nota = '';
			$nota_final = 0;
			if (count($alumno->NotasPIU($asignatura->cod_asignatura,@$alumno->ultimo_periodoPIU($asignatura->cod_asignatura)->nro_periodo)) <= 0 ){
				$nota = 0;
			}else{
				foreach ($alumno->NotasPIU($asignatura->cod_asignatura,@$alumno->ultimo_periodoPIU($asignatura->cod_asignatura)->nro_periodo) as $key => $nota_trimestre) {
					$nota .= $nota_trimestre->nota.' ';
					$nota_final += $nota_trimestre->nota;
				}
			}

			$cohortes = 2;
			if(round($nota_final/$cohortes) >= 12){
				$aprobadas++;
			}else{
				$reprobadas++;
			}
		}

		if($aprobadas == 5){
			return true; //TODO: APROBO TODO EL PIU
		}else{
			return false; //TODO: NO APROBO TODO EL PIU
		}
	}

	public function cambiar_plan(Alumno $alumno)
	{
		$nuevo_plan = $alumno->plan_id;

		switch ($alumno->plan_id) {
			case '27':
				$nuevo_plan = 5;
				break;
			case '28':
				$nuevo_plan = 11;
				break;
			case '29':
				$nuevo_plan = 14;
				break;
			case '30':
				$nuevo_plan = 17;
				break;
			case '31':
				$nuevo_plan = 21;
				break;
			case '32':
				$nuevo_plan = 23;
				break;
			case '33':
				$nuevo_plan = 24;
				break;
			case '34':
				$nuevo_plan = 25;
				break;
			case '35':
				$nuevo_plan = 26;
				break;
			case '36':
				$nuevo_plan = 39;
				break;

			default:
				$nuevo_plan = $alumno->plan_id;
				break;
		}

		if( $nuevo_plan != $alumno->plan_id){
			$alumno->update([
				'plan_id' => $nuevo_plan
			]);
		}
	}

    public function uc_incribir_regulares()
	{
		// return dd($request);
		$alumno = Alumno::where('cedula',Auth::user()->cedula)->first();
		// return $alumno->InscritoActual()->Inscripcion;
		if($alumno->plan_id >= 27 && $alumno->plan_id <= 36){
			$this->cambiar_plan($alumno);
		}
		$incritas = array();
		if($alumno->InscritoActual()){
			foreach ($alumno->InscritoActual()->Inscripcion as $key => $inscripcion) {
				// echo $inscripcion->RelacionDocenteSeccion->des_asignatura_id;
				array_push($incritas,$inscripcion->RelacionDocenteSeccion->DesAsignatura->Asignatura->id);
				// echo "<br>";
			}
		}
		$titulo = DB::table('graduandos')->where('cedula',$alumno->cedula)->where('pnf',$alumno->Pnf->codigo)->max('titulo');
		if ($titulo == 2) {
			# TITULO DE INGENIERO
			if ($alumno->Pnf->codigo == 40 || $alumno->Pnf->codigo == 60) {
				$trayectos_aprobados = [8,1,2,3,4,5,7];
				foreach ($alumno->Plan->Asignaturas->whereIn('trayecto_id',$trayectos_aprobados) as $key => $asignatura) {
					array_push($incritas,$asignatura->id);
				}
			}else{
				$trayectos_aprobados = [8,1,2,3,4,7];
				foreach ($alumno->Plan->Asignaturas->whereIn('trayecto_id',$trayectos_aprobados) as $key => $asignatura) {
					array_push($incritas,$asignatura->id);
				}
			}
		}elseif($titulo == 1){
			# TITULO DE TSU
			if ($alumno->Pnf->codigo == 40 || $alumno->Pnf->codigo == 60) {
				$trayectos_aprobados = [8,1,2,3];
				foreach ($alumno->Plan->Asignaturas->whereIn('trayecto_id',$trayectos_aprobados) as $key => $asignatura) {
					array_push($incritas,$asignatura->id);
				}
			}else{
				$trayectos_aprobados = [8,1,2];
				foreach ($alumno->Plan->Asignaturas->whereIn('trayecto_id',$trayectos_aprobados) as $key => $asignatura) {
					array_push($incritas,$asignatura->id);
				}
			}
		}
		// return $alumno->Historico;
		// foreach ($alumno->Plan->Asignaturas as $key => $a) {
		// 	echo  'Trayecto:'.@$a->Trayecto->nombre.' - '.@$a->codigo.' - '.@$a->nombre.'<br>';
		// 	echo $a->DesAsignaturas.'<br>';
		// 	echo "----------------------------------<br>";
		// }
		// return '';

		$uc_acursar = array();

		// TODO: VARIABLES PARA PNF
		$aprueba_ti = 0;
		$aprueba_t1 = 0;
		$aprueba_t2 = 0;
		$aprueba_t3 = 0;
		$aprueba_t4 = 0;
		$aprueba_t5 = 0;

		// TODO: ELECTRICIDAD
		$e_r_mat = 0; //reprobo matematica TI
		$e_r_fisi = 0; //reprobo fisica TI
		$e_r_uc_ti = 0; // unidades reprobadas aparte de MAT y MF
		$e_a_uc_ti = 0; // unidades reprobadas aparte de MAT y MF
		$e_r_tde = 1; //reprobo taller de elec T1
		$e_r_psi1 = 0; //reprobo psi T1
		$e_a_tde = 0; //aprobo taller de elec T1
		$e_a_psi1 = 0; //aprobo psi T1
		$e_r_psi2 = 0; //reprobo psi T2
		$e_a_uc_t1 = 0; // unidades aprobadas T1
		$e_a_uc_tn = 0; // unidades aprobadas TN
		$e_r_uc_tn = 0; // unidades aprobadas TN
		$e_a_uc_t3 = 0; // unidades aprobadas T3
		$e_r_psi4 = 0; //reprobo psi T4

		// TODO: GEOCIENCIASS
		$gcs_a_ti = 0;
		$gcs_a_pst1 = 0;
		$gcs_a_pst2 = 0;
		$gcs_a_pst3 = 0;
		$gcs_a_t1 = 0;
		$gcs_a_t2 = 0;
		$gcs_a_t3 = 0;

		// TODO: INFORMATICA
		$inf_a_ti = 0;
		$inf_a_pst1 = 0;
		$inf_a_pst2 = 0;
		$inf_a_pst3 = 0;

		// TODO: MANTENIMIENTO
		$mtto_r_mat = 0;
		$mtto_r_uc_ti = 0; // unidades reprobadas aparte de MAT
		$mtto_a_uc_ti = 0;
		$mtto_a_psi1 = 0;
		$mtto_a_psi2 = 0;
		$mtto_a_psi3 = 0;
		$mtto_a_uc_tn = 0;

		// TODO: SISTEMAS DE CALIDAD Y AMBIENTE
		$cya_r_ti = 0;
		$cya_a_ti = 0;
		$cya_r_psi1 = 0;
		$cya_a_psi1 = 0;
		$cya_a_t1 = 0;
		$cya_a_psi2 = 0;
		$cya_a_psi3 = 0;

		// TODO: ORFREBERIA Y JOYERIA
		$oyj_r_ti = 0;
		$oyj_a_ti = 0;
		$oyj_r_psi1 = 0;
		$oyj_a_psi1 = 0;
		$oyj_a_t1 = 0;
		$oyj_a_psi2 = 0;
		$oyj_a_psi3 = 0;
		$oyj_r_mat =  0;


		// TODO: INGENERIA DE MATERIALES INDUSTRIALES
		$imi_r_ti = 0;
		$imi_a_ti = 0;
		$imi_a_psi1 = 0;
		$imi_a_t1 = 0;
		$imi_a_psi2 = 0;
		$imi_a_psi3 = 0;
		$imi_r_t1=0;
		$imi_r_t2=0;
		$imi_r_t3=0;
		$imi_r_mat = 0;

		// TODO: HIGIENE Y SEGURIDAD LABORAL
		$hsl_r_ti = 0;
		$hsl_r_mat = 0;
		$hsl_r_dibujo = 0;
		$hsl_a_ti = 0;
		$hsl_a_psi1 = 0;
		$hsl_a_t1 = 0;
		$hsl_a_psi2 = 0;
		$hsl_a_psi3 = 0;

		// TODO: QUIMICA
		$qui_r_mat = 0;
		$qui_r_qui = 0;

		// TODO:: MECANICA
		$ti_porcentaje_aprobado = 0;
		$ti_matematica = 0;

		$t1_cursado = 0;
		$t1_a_calculo_i = false;
		$t1_a_algebraYgeometria = false;
		$t1_a_fisica = false;
		$t1_a_psi_i = false;
		$t1_a_dibujo_mecanico = false;

		$t2_cursado = 0;
		$t2_a_mec_aplicada = false;
		$t2_a_psi_ii = false;

		$t4_cursado = 0;
		$t4_a_psi_iv = false;
		$t4_a_generacion_p = false;
		$t4_a_diseno_mac = false;
		$ti_a = 0;
		$t1_a = 0;
		$t2_a = 0;
		$t3_a = 0;
		$gsc_a_pp_tsu = 0;
		if($alumno->pnf_id == 2){
			$pp = $alumno->ultimo_periodo('PGT28');

			if($pp){
				$gsc_a_pp_tsu = ($pp->nota >= 12) ? 1 : 0;
			}
		}
		foreach ($alumno->Plan->Asignaturas->whereNotIn('id',$incritas) as $key => $asignatura) {
			$u_periodo_asignatura = $alumno->ultimo_periodo($asignatura->codigo);
			$cursado = $alumno->Notas($asignatura->codigo , @$u_periodo_asignatura->nro_periodo)->count();
			$notas =  $alumno->Notas($asignatura->codigo , @$u_periodo_asignatura->nro_periodo)->sum('nota');
			$notas = ($notas == 0) ? 1 : $notas;
			// TODO: ELEGIBLE DE IMI
			$cohortes = ($asignatura->codigo == '75ELE4918')? 1 : count($asignatura->DesAsignaturas);
			$nota_final = round($notas / $cohortes);
			// $nota_final = round($notas / count($asignatura->DesAsignaturas));
			if($alumno->tipo == 10) {
				$aprueba = 10;
			}else{
				$aprueba = ($asignatura->aprueba == 1) ? 16 : 12;
			}
			switch ($alumno->Pnf->codigo) {
				case 40:
					// TODO: COMIENZA ELECTRICIDAD
					// if ($alumno->plan_id == 27) {
					// 	# code...
					// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					// }
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL
							switch ($asignatura->codigo) {
								case '01MAT000':
									# MATEMATICA TI
									if($this->CheckPIU($alumno) == true){
										$e_r_mat = 0;
									}elseif (round($nota_final) < 12) {
										$e_r_mat = 1; //REPROBO MATEMATICA TI
										array_push($uc_acursar, $asignatura);
										// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
										// 	$alumno->update([
										// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
										// 	]);
										// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
										// }
									}
								break;

								case '01MFI000':
									# FISICA TI
									if($this->CheckPIU($alumno) == true){
										$e_r_fisi = 0;
									}elseif (round($nota_final) < 12) {
										$e_r_fisi = 1; //REPROBO FISICA TI
										array_push($uc_acursar, $asignatura);
										// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
										// 	$alumno->update([
										// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
										// 	]);
										// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
										// }
									}
								break;

								default:
									if($this->CheckPIU($alumno) == true){
										$e_a_uc_ti++; //APROBO PIU
									}elseif (round($nota_final) < 12) {
										$e_r_uc_ti++; //REPROBO TI
										array_push($uc_acursar, $asignatura);
									}else{
										$e_a_uc_ti++; //APROBO TI
										// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo')) && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
										// 	$alumno->update([
										// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
										// 	]);
										// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
										// }
									}
								break;
							}

						break;
							// FIN TRAYECTO INICIAL

							//TRAYECTO 1
						case 1:
						// echo round($nota_final)." $asignatura->nombre <br>";
							if ($e_r_fisi == 0 && $e_r_mat == 0 && $e_a_uc_ti >= 2 && $asignatura->aprueba == 0 || $e_r_fisi == 0 && $e_r_mat == 0 && $e_a_uc_ti >= 2   && $asignatura->aprueba == 1 ) {
									if ($asignatura->codigo == "01TDE105"   && round($nota_final) >= 12  ) {
										# code...
										$e_a_tde++; //REPROBO TALLER DE ELECTRICIDAD T1
									}
									if ($asignatura->codigo == "01PSI106" && round($nota_final) >= 16 ) {
										# code...
										$e_a_psi1++; //REPROBO TALLER DE ELECTRICIDAD T1
									}

									if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
										# APRUEBA T1
										$e_a_uc_t1++; //APROBO TI


									}else{
										array_push($uc_acursar, $asignatura);

									}
							}

						break;

							// FIN TRAYECTO 1

						case 2:
							// TRAYECTO 2
							// echo "$e_a_tde <br>";
							if (round($nota_final) < 12 && $asignatura->aprueba == 0 && $e_a_psi1 == 1 && $e_a_tde == 1 && $e_r_fisi == 0 && $e_r_mat == 0 && $e_a_uc_ti >= 2 || round($nota_final) < 16 && $asignatura->aprueba == 1 && $e_a_psi1 == 1 && $e_a_tde == 1 && $e_r_fisi == 0 && $e_r_mat == 0 && $e_a_uc_ti >= 2  ) {
									if ($asignatura->codigo == "01TDI206" && $asignatura->aprueba == 0 && round($nota_final) < 12 || $asignatura->codigo == "01PSI206" && $asignatura->aprueba == 1 && round($nota_final) < 16 ) {
										# code...
										$e_r_psi2 = 1; //REPROBO TALLER DE ELECTRICIDAD T1
									}
										array_push($uc_acursar, $asignatura);
								}
						break;
							// FIN TRAYECTO 2

						case 3:

							if ($e_a_uc_t1 == 7 && $e_r_psi2 == 0) {
								# code...
								// if ($asignatura->codigo == "01TDI206" && $asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->codigo == "01PSI106" && $asignatura->aprueba == 1 && round($nota_final) >= 16 ) {

								// }
								 if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									# APRUEBA T3
									// $e_a_uc_t3++; //APROBO T3

									array_push($uc_acursar, $asignatura);
								}

							}

							 if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
								# APRUEBA T3
								$e_a_uc_t3++; //APROBO T3

							}

						break;

						case 7:
							if (round($nota_final) < 12) {
								$e_r_uc_tn++; //REPROBO TI
								// array_push($uc_acursar, $asignatura);
							}else{
								$e_a_uc_tn++; //APROBO TI

							}
						break;

						case 4:
							# TRAYECTO 4
							if ($e_a_uc_t3 == 8 || $e_a_uc_tn == 5|| $titulo ==1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {

									if ($asignatura->codigo =="01PSI407" && round($nota_final) < 16 ) {
										$e_r_psi4 = 1; // reprobo proyecto
									}
									array_push($uc_acursar, $asignatura);
								}

								if ($asignatura->codigo =="01PSI407" && round($nota_final) >= 16 ) {
									$e_r_psi4 = 2;; // aprobo proyecto
								}
							}
						break;

						case 5:
							# TRAYECTO 5
							if ($e_r_psi4 == 2) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}

							}

						break;


						default:
							# code...
							break;
					}
					# FIN ELECTRICIDAD
				break;

				case 45:
					// TODO: COMIENZA GEOCIENCIAS
					// if ($alumno->plan_id == 28) {
					// 	# code...
					// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					// }
					switch ($asignatura->trayecto_id) {
						case 8:
							# TRAYECTO INICIAL
							if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $this->CheckPIU($alumno) == true) {
								$gcs_a_ti++;
							}else{
								array_push($uc_acursar, $asignatura);
							}
						break;

						case 1:
							# TRAYECTO 1
							if ($gcs_a_ti < 3) {
								// TODO: ESTA COMPROBACION ES SI CURSO TRAYECTO 1 !!! TODO: OJO REVISAR TODO:
								// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
								// 	$alumno->update([
								// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
								// 	]);
								// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
								// }
							}
							if ($gcs_a_ti >= 3 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $gcs_a_ti >= 3 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								# code...
								array_push($uc_acursar, $asignatura);
							}
							// TODO: COMPROBAR CUANTAS UNIDADES CURRICULARES APROBO
							if(round($nota_final) >= 12 && $asignatura->aprueba == 0){
								$aprueba_t1++;
							}
							if ($asignatura->codigo == "PGT17" && round($nota_final) >= 16) {
								# code...
								$gcs_a_pst1 = 1;
								$aprueba_t1++;
							}
						break;

						case 2:
							# TRAYECTO 2
							// TODO: COMPROBAR QUE CUMPLE CON EL % DE UNIDADES CURRICULARES Y PROYECTO APROBADO
							if($aprueba_t1 >= $this->porcentajeAprobado($alumno,1,65) && $gcs_a_pst1 == 1){
								if ($asignatura->aprueba == 0 && round($nota_final) < 12 || $asignatura->aprueba == 1 && round($nota_final) < 16) {
									# code...
									array_push($uc_acursar, $asignatura);
									}
									// TODO: COMPROBAR CUANTAS UNIDADES CURRICULARES APROBO
									if(round($nota_final) >= 12 && $asignatura->aprueba == 0){
										$aprueba_t2++;
								}
								if ($asignatura->codigo == "PGT27" && round($nota_final) >= 16) {
									# code...
									$gcs_a_pst2 = 1;
									$aprueba_t2++;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							// TODO: COMPROBAR QUE CUMPLE 100% DE UNIDADES CURRICULARES APROBADAS PARA TSU
							if($titulo == 1 || $aprueba_t1 >= $this->porcentajeAprobado($alumno,1,100) && ($aprueba_t2+$gsc_a_pp_tsu) >= $this->porcentajeAprobado($alumno,2,100) && $gcs_a_ti >= $this->porcentajeAprobado($alumno,8,100)){
								if ($asignatura->aprueba == 0 && round($nota_final) < 12 || $asignatura->aprueba == 1 && round($nota_final) < 16) {
									array_push($uc_acursar, $asignatura);
								}
								// TODO: COMPROBAR CUANTAS UNIDADES CURRICULARES APROBO
								if(round($nota_final) >= 12 && $asignatura->aprueba == 0){
									$aprueba_t3++;
								}
							if ($asignatura->codigo == "PGT37" && round($nota_final) >= 16) {
								$gcs_a_pst3 = 1;
									$aprueba_t3++;
								}
							}
						break;

						case 4:
							# TRAYECTO 4
							// TODO: COMPROBAR QUE CUMPLE CON EL % DE UNIDADES CURRICULARES Y PROYECTO APROBADO
							// if ( $gcs_a_t1 == 7 && $gcs_a_t2 == 7 && $gcs_a_ti >= 5 && $gcs_a_pst3 == 1 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $gcs_a_t1 == 7 && $gcs_a_t2 == 7 && $gcs_a_ti >= 5 && $gcs_a_pst3 == 1 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
							if($aprueba_t3 >= $this->porcentajeAprobado($alumno,3,75) && $gcs_a_pst3 == 1){
								if ($asignatura->aprueba == 0 && round($nota_final) < 12 || $asignatura->aprueba == 1 && round($nota_final) < 16) {
									array_push($uc_acursar, $asignatura);
								}
							}
						break;

						default:
							# code...
							break;
					}
					// FIN GEOCIENCIAS
				break;

				case 50:
					# TODO: COMIENZA INFORMATICA
					// if ($alumno->plan_id == 29) {
					// 	# code...
					// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					// }
					switch ($asignatura->trayecto_id) {
						case 8:
							# TRAYECTO INICIAL
							if ($asignatura->aprueba == 0 && round($nota_final) >=  12 || $this->CheckPIU($alumno) == true) {
								$inf_a_ti++;
								$aprueba_ti++;
							}else{
								array_push($uc_acursar, $asignatura);
								// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
								// 	$alumno->update([
								// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
								// 	]);
								// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
								// }
							}
						break;

						case 1:
							# TRAYECTO 1
							if ($inf_a_ti == $this->porcentajeAprobado($alumno,8,100) && $asignatura->aprueba == 0 && round($nota_final) < 12 || $inf_a_ti == $this->porcentajeAprobado($alumno,8,100)  && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								array_push($uc_acursar, $asignatura);
							}
							// TODO: COMPROBAR CUANTAS UNIDADES CURRICULARES APROBO
							if(round($nota_final) >= 12 && $asignatura->aprueba == 0){
								$aprueba_t1++;
							}
							if ($asignatura->codigo == "PTP139" && round($nota_final) >= 16) {
								$inf_a_pst1 = 1;
								$aprueba_t1++;
							}
						break;

						case 2:
							# TRAYECTO 2
							// TODO: COMPROBAR QUE CUMPLE CON EL % DE UNIDADES CURRICULARES Y PROYECTO APROBADO
							if($aprueba_ti == $this->porcentajeAprobado($alumno,8,100) && $aprueba_t1 >= $this->porcentajeAprobado($alumno,1,65) && $inf_a_pst1 == 1){

								// if ($inf_a_ti >= 3 && $inf_a_pst1 == 1 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $inf_a_ti >= 3 && $inf_a_pst1 == 1 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								if ($asignatura->aprueba == 0 && round($nota_final) < 12 ||  $asignatura->aprueba == 1 && round($nota_final) < 16) {
									array_push($uc_acursar, $asignatura);
								}
								// TODO: COMPROBAR CUANTAS UNIDADES CURRICULARES APROBO
								if(round($nota_final) >= 12 && $asignatura->aprueba == 0){
									$aprueba_t2++;
								}
								if ($asignatura->codigo == "PTP239" && round($nota_final) >= 16) {
									$inf_a_pst2 = 1;
									$aprueba_t2++;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							// TODO: COMPROBAR QUE CUMPLE 100% DE UNIDADES CURRICULARES APROBADAS PARA TSU
							if($titulo == 1 || $aprueba_ti == $this->porcentajeAprobado($alumno,8,100) && $aprueba_t1 >= $this->porcentajeAprobado($alumno,1,90) && $aprueba_t2 >= $this->porcentajeAprobado($alumno,2,75) &&	$inf_a_pst2 = 1 ){
								if ($asignatura->aprueba == 0 && round($nota_final) < 12 || $asignatura->aprueba == 1 && round($nota_final) < 16) {
									# code...
									array_push($uc_acursar, $asignatura);
								}
								// TODO: COMPROBAR CUANTAS UNIDADES CURRICULARES APROBO
								if(round($nota_final) >= 12 && $asignatura->aprueba == 0){
										$aprueba_t3++;
								}
								if ($asignatura->codigo == "PTP339" && round($nota_final) >= 16) {
									$inf_a_pst3 = 1;
									$aprueba_t3++;
								}
							}
						break;

						case 4:
							# TRAYECTO 4
							// TODO: COMPROBAR QUE CUMPLE CON EL % DE UNIDADES CURRICULARES Y PROYECTO APROBADO
							if($titulo == 1 && $aprueba_t3 >= $this->porcentajeAprobado($alumno,3,75) && $inf_a_pst3 == 1 || $aprueba_ti == $this->porcentajeAprobado($alumno,8,100) && $aprueba_t1 == $this->porcentajeAprobado($alumno,1,100) && $aprueba_t2 >= $this->porcentajeAprobado($alumno,2,80)  && $aprueba_t3 >= $this->porcentajeAprobado($alumno,3,75) && $inf_a_pst3 == 1  ){
								if ($asignatura->aprueba == 0 && round($nota_final) < 12 || $asignatura->aprueba == 1 && round($nota_final) < 16) {
									array_push($uc_acursar, $asignatura);
								}
							}
						break;

						default:
							# code...
							break;
						// FIN INFORMATICA
					}
					// FIN INFORMATICA
				break;

				case 55:
					# TODO: COMIENZA MATENIMIENTO
					// if ($alumno->plan_id == 30) {
					// 	# code...
					// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					// }
					switch ($asignatura->trayecto_id) {
						case 8:
							# TRAYECTO INICIAL

								switch ($asignatura->codigo ) {
									case "MTMA004":
										if (round($nota_final) < 12) {
											$mtto_r_mat = 1; //REPROBO MATEMATICA TI
											array_push($uc_acursar, $asignatura);
											// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
											// 	$alumno->update([
											// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
											// 	]);
											// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
											// }

										}else{
											$mtto_a_uc_ti++;
										}
									break;

									default:
										if (round($nota_final) < 12) {
											$mtto_r_uc_ti++; //REPROBO TI
											array_push($uc_acursar, $asignatura);
											// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
											// 	$alumno->update([
											// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
											// 	]);
											// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
											// }
										}else{
											$mtto_a_uc_ti++; //APROBO TI

										}
									break;
								}

							break;

						default:
							# code...
							break;

						case 1:
							# TRAYECTO 1
							// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
							// 	$alumno->update([
							// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
							// 	]);
							// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
							// }
							if ($mtto_r_mat == 0 && $mtto_a_uc_ti >= 3 && round($nota_final) < 12 && $asignatura->aprueba == 0 || $mtto_r_mat == 0 && $mtto_a_uc_ti >= 3 && round($nota_final) < 16 && $asignatura->aprueba == 1 ) {
								array_push($uc_acursar, $asignatura);

							}
							if ($asignatura->codigo == "MIPR10112" && round($nota_final) >= 16) {
								$mtto_a_psi1 = 1;
								$aprueba_t1++;
							}

							// TODO: COMPROBAR CUANTAS UNIDADES CURRICULARES APROBO
							if(round($nota_final) >= 12 && $asignatura->aprueba == 0){
								$aprueba_t1++;
							}
						break;

						case 2:
							// TRAYECTO 2
							if($mtto_r_mat == 0 && $mtto_a_uc_ti >= 3 && $aprueba_t1 >= $this->porcentajeAprobado($alumno,1,65) && $mtto_a_psi1 == 1){
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1 ) {
								array_push($uc_acursar, $asignatura);
							}

							if ($asignatura->codigo == "MIPR20412" && round($nota_final) >= 16) {
								$mtto_a_psi2 = 1;
									$aprueba_t2++;
								}
								// TODO: COMPROBAR CUANTAS UNIDADES CURRICULARES APROBO
								if(round($nota_final) >= 12 && $asignatura->aprueba == 0){
									$aprueba_t2++;
								}
							}
						break;

						case 7:
							# TRAYECTO DE NIVELACION
							if ($mtto_a_uc_ti == 0) {
								if (round($nota_final) > 12 || $titulo == 1) {
									$mtto_a_uc_tn++; //aprobo tn
								}else{
									array_push($uc_acursar, $asignatura);

								}
							}
						break;

						case 3:
							// TRAYECTO 3
							if($titulo == 1 || $mtto_a_uc_tn == 4 || $mtto_a_uc_ti == $this->porcentajeAprobado($alumno,8,100) && $aprueba_t1 >= $this->porcentajeAprobado($alumno,1,90) && $aprueba_t2 >= $this->porcentajeAprobado($alumno,2,75) && $mtto_a_psi2 == 1){
								if ( round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1 ) {

								array_push($uc_acursar, $asignatura);
							}

								// TODO: COMPROBAR QUE APROBO PSI
							if ($asignatura->codigo == "MTPR30712" && round($nota_final) >= 16) {
								$mtto_a_psi3 = 1;
									$aprueba_t3++;
								}
								// TODO: COMPROBAR CUANTAS UNIDADES CURRICULARES APROBO
								if(round($nota_final) >= 12 && $asignatura->aprueba == 0){
									$aprueba_t3++;
								}
							}
						break;

						case 4:
							// TRAYECTO 4
							if ($titulo == 1 && $aprueba_t3 >= $this->porcentajeAprobado($alumno,3,75) && $mtto_a_psi3 == 1
								|| $mtto_a_uc_tn == 4  && $aprueba_t3 >= $this->porcentajeAprobado($alumno,3,75) && $mtto_a_psi3 == 1
								|| $mtto_a_uc_ti == $this->porcentajeAprobado($alumno,8,100) && $aprueba_t1 == $this->porcentajeAprobado($alumno,1,100) && $aprueba_t2 >= $this->porcentajeAprobado($alumno,2,80)  && $aprueba_t3 >= $this->porcentajeAprobado($alumno,3,75) && $mtto_a_psi3 == 1
							){
								if(round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1 ) {
									array_push($uc_acursar, $asignatura);
								}
							}
						break;
					}
					// FIN MANTENIMIENTO
				break;

				case 60:
					// TODO: COMIENZA MECANICA
					// if ($alumno->plan_id == 31) {
					// 	# code...
					// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					// }
					switch ($asignatura->trayecto_id) {
						case 8:
							# TRAYECTO INICIAL
							if ($asignatura->codigo == 'CBAMAT060' && round($nota_final) >= 12 || $this->CheckPIU($alumno) == true) {
								# APRUEBA MATEMATICA PARA CURSAR T1
								$ti_matematica = 1;
								$aprueba_ti++;
							}elseif ($asignatura->codigo != 'CBAMAT060' && $asignatura->aprueba == 0 && round($nota_final) >= 12 || $this->CheckPIU($alumno) == true) {
								$ti_porcentaje_aprobado++;
								$ti_a++;
								$aprueba_ti++;
							}else{
								array_push($uc_acursar, $asignatura);
								// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
								// 	$alumno->update([
								// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
								// 	]);
								// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
								// }
							}
							// echo $asignatura->nombre.': '.$notas.'<br>';
						break;

						case 1:
							# TRAYECTO 1
							// 75% APROBADO DE TI INCULIDO MATEMATICA
							$ti_porcentaje_aprobado += $ti_matematica;
							if($ti_porcentaje_aprobado >= 3 && $ti_matematica == 1){
								// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
								// 	$alumno->update([
								// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
								// 	]);
								// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
								// }
								if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
									// $ti_porcentaje_aprobado++;
									if ($asignatura->codigo == 'CBACAL168') {
										# APRUEBA CALCULO I PRELACION DE CALCULO II
										$t1_a_calculo_i = true;
									}elseif($asignatura->codigo == 'CBAAYG134'){
										# APRUEBA ALGEBRA Y GEOMETRÍA PRELACION DE CALCULO II
										$t1_a_algebraYgeometria = true;
									}elseif($asignatura->codigo == 'CBAFIS145'){
										# APRUEBA FÍSICA PRELACION DE MECÁNICA APLICADA Y TERMODINÁMICA
										$t1_a_fisica = true;
									}elseif($asignatura->codigo == 'PSIPSI157'){
										# APRUEBA PROYECTO SOCIO-INTEGRADOR I PRELACION DE PROYECTO SOCIO-INTEGRADOR II
										$t1_a_psi_i = true;
									}elseif($asignatura->codigo == 'DISDIM157'){
										# APRUEBA DIBUJO MECÁNICO PRELACION DE TALLER MECANIZADO
										$t1_a_dibujo_mecanico = true;
									}
									$t1_a++;
								}else{
									array_push($uc_acursar, $asignatura);
								}
							}

							if ($cursado >= 1) {
								$t1_cursado += 1;
							}
						// return '';
						break;

						case 2:
							if ($cursado >= 1) {
								$t2_cursado += 1;
							}
							switch ($asignatura->codigo) {
								case 'CBACAL235':
									# code...
									if ($t1_a_calculo_i == true && $t1_a_algebraYgeometria == true) {
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											$t2_a++;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;
								case 'DISMAP268':
									if($t1_a_fisica == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											// APRUEBA MECÁNICA APLICADA PRECACION DE DISEÑO DE ELEMENTOS MECÁNICOS
											$t2_a_mec_aplicada = true;
											$t2_a++;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'PSIPSI257':
									if($t1_a_psi_i == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											// APRUEBA PROYECTO SOCIO-INTEGRADOR II PRECACION DE PROYECTO SOCIO-INTEGRADOR III
											$t2_a++;
											$t2_a_psi_ii = true;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'MYMTME257':
									if($t1_a_dibujo_mecanico == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											// APRUEBA TALLER MECANIZADO PRECACION DE DISEÑO DE ELEMENTOS MECÁNICOS
											$t2_a++;
											$t2_a_mec_aplicada = true;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'ENETER268':
									if($t1_a_fisica == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											$t2_a++;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								default:
									# RESTO DE LAS UC DE T1 QUE NO TIENEN PRELACION
									if($t1_cursado >= 5){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											$t2_a++;

										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;
							}

						break;

						case 3:
							switch ($asignatura->codigo) {
								case 'DISDEM354':
									# code...
									if ($t2_a_mec_aplicada == true && $t2_a_mec_aplicada == true) {
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											$t3_a++;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;
								case 'AUTEIA354':
									if($t1_a_fisica == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											$t3_a++;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'PSIPSI354':
									if($t2_a_psi_ii == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											// APRUEBA PROYECTO SOCIO-INTEGRADOR II PRECACION DE PROYECTO SOCIO-INTEGRADOR III
											$t3_a++;
											$t3_a_psi_iii = true;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'ENEMHI354':
									if($t1_a_fisica == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											// APRUEBA TALLER MECANIZADO PRECACION DE DISEÑO DE ELEMENTOS MECÁNICOS
											$t3_a++;
											// $t2_a_mec_aplicada = true;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'MYMCNC354':
									if($t2_a_mec_aplicada == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											$t3_a++;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								default:
									# RESTO DE LAS UC DE T1 QUE NO TIENEN PRELACION
									if($t2_cursado >= 5){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
											$t3_a++;

										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;
							}
						break;

						case 4:
							if ($cursado >= 1) {
								$t4_cursado += 1;
							}
							// if ($titulo == 1 || $ti_a == 4 && $t1_a == 7 && $t2_a == 7 && $t3_a == 9) {
							if ($titulo == 1 || $aprueba_ti == $this->porcentajeAprobado($alumno,8,100) && $t1_a == 7 && $t2_a == 7 && $t3_a == 9) {
								if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
									if ($asignatura->codigo == 'ENEGDP457') {
										# APRUEBA GENERACIÓN DE POTENCIA PRELACION DE DINÁMICA DE MAQUINAS
										$t4_a_generacion_p = true;
									}elseif ($asignatura->codigo == 'DISDDM457') {
										# APRUEBA DISEÑO DE MÁQUINAS PRELACION DE DINÁMICA DE MAQUINAS
										$t4_a_diseno_mac = true;
									}elseif ($asignatura->codigo == 'PSIPSI468') {
										# APRUEBA PROYECTO SOCIO-INTEGRADOR IV PRELACION DE PROYECTO SOCIO-INTEGRADOR V
										$t4_a_psi_iv = true;
									}
								}else{
									array_push($uc_acursar, $asignatura);
								}
							}
							// else{
							// 	if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 1 && round($nota_final) >= 16) {
							// 		if ($asignatura->codigo == 'ENEGDP457') {
							// 			# APRUEBA GENERACIÓN DE POTENCIA PRELACION DE DINÁMICA DE MAQUINAS
							// 			$t4_a_generacion_p = true;
							// 		}elseif ($asignatura->codigo == 'DISDDM457') {
							// 			# APRUEBA DISEÑO DE MÁQUINAS PRELACION DE DINÁMICA DE MAQUINAS
							// 			$t4_a_diseno_mac = true;
							// 		}elseif ($asignatura->codigo == 'PSIPSI468') {
							// 			# APRUEBA PROYECTO SOCIO-INTEGRADOR IV PRELACION DE PROYECTO SOCIO-INTEGRADOR V
							// 			$t4_a_psi_iv = true;
							// 		}
							// 	}else{
							// 		array_push($uc_acursar, $asignatura);
							// 	}

							// }
						break;

						case 5:
							# code...
							if ($asignatura->aprueba == 0 && round($nota_final) <= 12 || $asignatura->aprueba == 1 && round($nota_final) <= 16) {
								if ($asignatura->codigo == 'DISDDM555') {
									if ($t4_a_generacion_p == true && $t4_a_diseno_mac == true) {
										# code...
										array_push($uc_acursar, $asignatura);
									}
								}elseif ($asignatura->codigo == 'PSIPSI555') {
									if ($t4_a_psi_iv ==  true) {
										# code...
										array_push($uc_acursar, $asignatura);
									}
								}elseif($t4_cursado >= 5){
									array_push($uc_acursar, $asignatura);
								}
							}
						break;

						default:
							# code...
						break;
					}

				break;

				case 65:
					// COMIENZA SISTEMAS DE CALIDAD Y AMBIENTE
					// if ($alumno->plan_id == 32) {
					// 	# code...
					// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					// }
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL

							if($this->CheckPIU($alumno) == true){
								$cya_a_ti++;
							}elseif (round($nota_final) < 12) {
								$cya_r_ti++; //REPROBO MATEMATICA TI
									array_push($uc_acursar, $asignatura);
								// 	if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
								// 	$alumno->update([
								// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
								// 	]);
								// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
								// }
							}else{
								$cya_a_ti++;
							}

						break;

						case 1:
							// TRAYECTO 1
							if ($cya_r_ti == 0) {
								// if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
								// 	$alumno->update([
								// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
								// 	]);
								// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
								// }
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									if($asignatura->codigo == "SCPSI3181106"){
										$cya_r_psi1 = 1;
									}
									array_push($uc_acursar, $asignatura);

								}

								if($asignatura->codigo == "SCPSI3181106" &&  round($nota_final) >= 16){
									$cya_a_psi1 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$cya_a_t1++;
									$aprueba_t1++;
								}
							}
						break;

						case 2:
							// TRAYECTO 2
							if ( $aprueba_t1 >= $this->porcentajeAprobado($alumno,1,65) && $cya_a_psi1 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);

								}

								if($asignatura->codigo == "SCPSI3181206" &&  round($nota_final) >= 16){
									$cya_a_psi2 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$aprueba_t2++;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($titulo == 1 || $aprueba_t2 >= $this->porcentajeAprobado($alumno,2,75) &&  $aprueba_t1 >= $this->porcentajeAprobado($alumno,1,90) && $cya_a_ti == $this->porcentajeAprobado($alumno,8,100) && $cya_a_psi2 == 1) {
								// if ($cya_a_t1 == 8 && $cya_a_ti == 5 && $cya_a_psi2 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
								// }

								if($asignatura->codigo == "SCPSII3303306" && round($nota_final) >= 16){
									$cya_a_psi3 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$aprueba_t3++;
								}
							}
						break;

						case 4:
							// TRAYECTO 4
							if ($aprueba_t3 >= $this->porcentajeAprobado($alumno,1,75) && $cya_a_psi3 == 1 || $cya_a_ti == $this->porcentajeAprobado($alumno,8,100) && $aprueba_t1 == $this->porcentajeAprobado($alumno,1,100) && $aprueba_t2 == $this->porcentajeAprobado($alumno,2,80)  && $aprueba_t3 >= $this->porcentajeAprobado($alumno,3,75) && $cya_a_psi3 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
							}
						break;

						default:
							// code...
							break;
					}
					// FIN SISTEMAS DE CALIDAD Y AMBIENTE
				break;

				case 70:
					// COMIENZA ORFREBERIA Y JOYERIA
					// if ($alumno->plan_id == 32) {
					// 	# code...
					// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					// }
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL

							if($this->CheckPIU($alumno) == true){
								$oyj_a_ti++;
							}elseif (round($nota_final) < 12) {
								$oyj_r_ti++;
								if($asignatura->codigo = "MATE00"){
									$oyj_r_mat = 1;
								}
									array_push($uc_acursar, $asignatura);
								// 	if($alumno->NotasTrayecto($alumno->Plan->Asignaturas->where('trayecto_id',1)->pluck('codigo'))->count() == 0 && $alumno->plan_id != $alumno->Pnf->Planes->sortByDesc('id')->first()->id){
								// 	$alumno->update([
								// 		'plan_id'  => $alumno->Pnf->Planes->sortByDesc('id')->first()->id
								// 	]);
								// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
								// }
							}else{
								$oyj_a_ti++;
							}

						break;

						case 1:
							// TRAYECTO 1
							if ($oyj_a_ti >= $this->porcentajeAprobado($alumno,8,75) && $oyj_r_mat == 0) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									if($asignatura->codigo == "PROY1367"){
										$oyj_r_psi1 = 1;
									}
									array_push($uc_acursar, $asignatura);
								}

								if($asignatura->codigo == "PROY1367" &&  round($nota_final) >= 16){
									$oyj_a_psi1 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$oyj_a_t1++;
									$aprueba_t1++;
								}
							}
						break;

						case 2:
							// TRAYECTO 2
							if ( $aprueba_t1 >= $this->porcentajeAprobado($alumno,1,65) && $oyj_a_psi1 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);

								}

								if($asignatura->codigo == "PROY2367" &&  round($nota_final) >= 16){
									$oyj_a_psi2 = 1;
								}
								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$aprueba_t2++;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($titulo == 1 || $aprueba_t2 == $this->porcentajeAprobado($alumno,2,100) &&  $aprueba_t1 == $this->porcentajeAprobado($alumno,1,100) && $oyj_a_ti == $this->porcentajeAprobado($alumno,8,100) && $oyj_a_psi2 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}

							if($asignatura->codigo == "PROY3367" &&  round($nota_final) >= 16){
								$oyj_a_psi3 = 1;
							}
								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$aprueba_t3++;
								}
							}

						break;

						case 4:
							// TRAYECTO 4
							if ( $aprueba_t2 >= $this->porcentajeAprobado($alumno,2,75) && $oyj_a_psi3 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
							}
						break;

						default:
							// code...
							break;
					}
					// FIN ORFREBERIA Y JOYERIA
				break;

				case 75:
					// COMIENZA INGENERIA DE MATERIALES INDUSTRIALES
					// if ($alumno->plan_id == 34) {
					// 	# code...
					// 	return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					// }
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL

							if($this->CheckPIU($alumno) == true){
								$imi_a_ti++;
							}elseif (round($nota_final) < 12) {
								$imi_r_ti++;
								if($asignatura->codigo = "75MAT015"){
									$imi_r_mat = 1;
								}
								array_push($uc_acursar, $asignatura);
							}else{
								$imi_a_ti++;
							}

						break;

						case 1:
							// TRAYECTO 1
							if ($imi_a_ti >= $this->porcentajeAprobado($alumno,8,75) && $imi_r_mat == 0) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									if($asignatura->codigo == "PROY1367"){
										$imi_r_psi1 = 1;
									}
									array_push($uc_acursar, $asignatura);
								}

								if($asignatura->codigo == "75PRY1318" &&  round($nota_final) >= 16){
									$imi_a_psi1 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$imi_a_t1++;
									$aprueba_t1++;
								}
							}
						break;

						case 2:
							// TRAYECTO 2
							if ($aprueba_t1 >= $this->porcentajeAprobado($alumno,1,65) && $imi_a_psi1 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);

								}

								if($asignatura->codigo == "75PRY2318" &&  round($nota_final) >= 16){
									$imi_a_psi2 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$aprueba_t2++;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($titulo == 1 || $aprueba_t2 >= $this->porcentajeAprobado($alumno,2,75) &&  $aprueba_t1 >= $this->porcentajeAprobado($alumno,1,90) && $imi_a_ti == $this->porcentajeAprobado($alumno,8,100) && $imi_a_psi2 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}

								if($asignatura->codigo == "75PST3318" &&  round($nota_final) >= 16){
									$imi_a_psi3 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$aprueba_t3++;
								}
							}
						break;

						case 4:
							// TRAYECTO 4
							if ($aprueba_t3 >= $this->porcentajeAprobado($alumno,3,75) && $imi_a_psi3 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
							}
						break;

						default:
							// code...
							break;
					}
					// FIN INGENERIA DE MATERIALES INDUSTRIALES
				break;

				case 80:
					// COMIENZA HIGIENE Y SEGURIDAD LABORAL
					if ($alumno->plan_id == 35) {
						# code...
						return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					}
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL

							if($this->CheckPIU($alumno) == true){
								$hsl_a_ti++;
							}elseif (round($nota_final) < 12) {
								if($asignatura->codigo == "HSMAT144005"){
									$hsl_r_mat = 1;
								}
								if($asignatura->codigo == "HSDTE072002"){
									$hsl_r_dibujo = 1;
								}
								$hsl_r_ti++;
								array_push($uc_acursar, $asignatura);
							}else{
								$hsl_a_ti++;
							}

						break;

						case 1:
							// TRAYECTO 1
							if ($hsl_a_ti >= $this->porcentajeAprobado($alumno,8,75) && $hsl_r_mat == 0 && $hsl_r_dibujo == 0) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									if($asignatura->codigo == "HSPR1540118"){
										$hsl_r_psi1 = 1;
									}
									array_push($uc_acursar, $asignatura);
								}

								if($asignatura->codigo == "HSPR1540118" &&  round($nota_final) >= 16){
									$hsl_a_psi1 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$hsl_a_t1++;
									$aprueba_t1++;
								}
							}
						break;

						case 2:
							// TRAYECTO 2
							if ($aprueba_t1 >= $this->porcentajeAprobado($alumno,1,65) && $hsl_a_psi1 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);

								}

								if($asignatura->codigo == "HSPR2540218" &&  round($nota_final) >= 16){
									$hsl_a_psi2 = 1;
								}
								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$aprueba_t2++;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($titulo == 1 || $aprueba_t2 >= $this->porcentajeAprobado($alumno,2,75) &&  $aprueba_t1 = $this->porcentajeAprobado($alumno,1,90) && $hsl_a_ti == $this->porcentajeAprobado($alumno,8,100) && $hsl_a_psi2 ==1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
							}

							if($asignatura->codigo == "HSPR3540318" &&  round($nota_final) >= 16){
								$hsl_a_psi3 = 1;
							}
							if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
								$aprueba_t3++;
							}
						break;

						case 4:
							// TRAYECTO 4
							if ($aprueba_t3 >= $this->porcentajeAprobado($alumno,3,75) && $hsl_a_psi3 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
							}
						break;

						default:
							// code...
							break;
					}
					// FIN HIGIENE Y SEGURIDAD LABORAL
				break;

				case 85:
					// return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL

							if($this->CheckPIU($alumno) == true){
								$aprueba_ti++;
							}elseif (round($nota_final) < 12) {
								if($asignatura->codigo == "1900-MAT-08"){
									$qui_r_mat = 1;
								}
								if($asignatura->codigo == "1900-QUI-08"){
									$qui_r_qui = 1;
								}
								$hsl_r_ti++;
								array_push($uc_acursar, $asignatura);
							}else{
								$aprueba_ti++;
							}

						break;

						case 1:
							// TRAYECTO UNO

							if ($aprueba_ti >= $this->porcentajeAprobado($alumno,8,75) && $qui_r_mat == 0 && $qui_r_qui == 0) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									if($asignatura->codigo == "HSPR1540118"){
										$hsl_r_psi1 = 1;
									}
									array_push($uc_acursar, $asignatura);
								}

								if($asignatura->codigo == "1910-PRO-08" &&  round($nota_final) >= 16){
									$hsl_a_psi1 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$aprueba_t1++;
								}
							}

						break;
						default:
						# code...
							break;
					}

				break;

				case 90:
					return abort(404);
					return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
				break;

				case 95:
					return abort(404);
					return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index');
				break;

				default:
					return abort(404);
					break;
			}
		}


		return view('panel.estudiantes.inscripciones.regulares.uc_inscribir',['alumno' => $alumno, 'uc_acursar' => $uc_acursar]);
	}

	public function store(Request $request)
	{
		// return dd($request);
		$request->validate(
			[
				'uc_a_inscribir' => 'required|array|min:1'
			]
		);
		// return '';
		try {
			DB::beginTransaction();
				$alumno = Alumno::find($request->alumno_id);
				$periodo = Periodo::where('estatus',0)->first();
				$inscrito = Inscrito::updateOrCreate(
					[
						'periodo_id' => $periodo->id,
						'alumno_id' => $alumno->id,
					],
					['fecha' => Carbon::now()]
				);
				foreach ($request->seccion as $key => $seccion) {
					if (array_key_exists($key,$request->uc_a_inscribir)) {
						$asignaturas = Asignatura::whereIn('id',$request->uc_a_inscribir[$key])->get();
						$seccion_db = Seccion::find($seccion);
						$seccion_db->update(['cupos' => ($seccion_db->cupos - 1) ]);
						foreach ($asignaturas as $key => $asignatura) {
							$uc_cohortes = DesAsignaturaDocenteSeccion::where('seccion_id',$seccion)
							->whereIn('des_asignatura_id', $asignatura->DesAsignaturas->pluck('id'))
							->where('estatus','ACTIVO')->get();
							foreach ($uc_cohortes as $key => $uc_cohorte) {
								Inscripcion::create([
									'desasignatura_docente_seccion_id' => $uc_cohorte->id,
									'inscrito_id' => $inscrito->id,
									'alumno_id' => $alumno->id
								]);
							}
						}
					}
				}

				// TODO: CAMBIAR EL ID DEL PERIODO EN LAS INSCRIPCIONES

				Ingreso::updateOrCreate(
					[
						'alumno_id' => $alumno->id,
						'periodo_id' => $periodo->id,
						'tipo' => ($alumno->CheckPeriodo(6)) ? 'REGULAR' : 'REINGRESO',
					], //TODO: EL VALOR QUE NO SE ACTUALIZA
					[
						'estatus' => 'INSCRITO' ,
					]
				);
			DB::commit();
			return redirect()->route('panel.estudiante.inscripciones.regulares.index')->with('jet_mensaje','inscripcion realizada con exito');
		} catch (\Throwable $th) {
			DB::rollback();
			return redirect()->route('panel.estudiante.inscripciones.regulares.index')->with('jet_error',$th->getMessage());
		}
		// return dd($request);
	}

	public function secciones_nuevos()
	{
		$alumno = Auth::user()->Alumno;
		$secciones = Seccion::where('cupos','>',0)->where('trayecto_id',8)->where('estatus','ACTIVA')
		->where('nucleo_id',$alumno->nucleo_id)
		->where('pnf_id',$alumno->pnf_id)
		->where('plan_id',$alumno->plan_id)
		->get();

		return view('panel.estudiantes.inscripciones.nuevos.index',['secciones' => $secciones]);
	}

	public function seleccionar_seccion(Request $request)
	{
		$seccion = Seccion::find($request->seccion_id);
		if ($seccion) {
			if ($seccion->cupos > 0) {
				return view('panel.estudiantes.inscripciones.nuevos.uc_inscribir',['seccion' => $seccion, 'alumno' => Auth::user()->Alumno]);
			}
		}

		return back();
	}
	public function uc_inscribir_nuevos()
	{
		$alumno = Alumno::where('cedula',Auth::user()->cedula)->first();

		$pnf = $alumno->Pnf;
		$plan = $alumno->Plan;

		return $alumno->Plan->Asignaturas->where('trayecto_id',8);
	}

	public function guardar(Request $request)
	{
		// return dd($request);
		$request->validate(
			[
				'uc_a_inscribir' => 'required|array|min:1'
			]
		);
		// return '';
		try {
			DB::beginTransaction();
				$alumno = Alumno::find($request->alumno_id);
				$periodo = Periodo::where('estatus',0)->first();
				Ingreso::updateOrCreate(
					[
						'alumno_id' => $alumno->id,
						'periodo_id' =>$periodo->id,
						'tipo' => 'REINGRESO',
					], //TODO: EL VALOR QUE NO SE ACTUALIZA
					[
						'estatus' => 'INSCRITO' ,
					]
				);
				$inscrito = Inscrito::updateOrCreate(
					[
						'periodo_id' => $periodo->id,
						'alumno_id' => $alumno->id,
					],
					['fecha' => Carbon::now()]
				);
				$seccion_db = Seccion::find($request->seccion_id);
				$seccion_db->update(['cupos' => ($seccion_db->cupos - 1) ]);
				$seccion_db = Seccion::find($request->seccion_id);
				foreach ($seccion_db->Plan->Asignaturas->where('trayecto_id',8) as $key => $asignatura) {
					$uc_cohortes = DesAsignaturaDocenteSeccion::where('seccion_id',$seccion_db->id)
					->whereIn('des_asignatura_id', $asignatura->DesAsignaturas->pluck('id'))
					->where('estatus','ACTIVO')->get();
					foreach ($uc_cohortes as $key => $uc_cohorte) {
						Inscripcion::updateOrCreate([
							'desasignatura_docente_seccion_id' => $uc_cohorte->id,
							'inscrito_id' => $inscrito->id,
							'alumno_id' => $alumno->id
						]);
					}
				}
			DB::commit();
			return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index')->with('jet_mensaje','inscripcion realizada con exito');
		} catch (\Throwable $th) {
			DB::rollback();
			return redirect()->route('panel.estudiante.inscripciones.nuevo-ingreso.index')->with('jet_error',$th->getMessage());
		}
		// return dd($request);
	}
}
