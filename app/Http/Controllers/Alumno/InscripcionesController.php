<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Inscripcion;
use App\Models\Inscrito;
use App\Models\Periodo;
use App\Models\Seccion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InscripcionesController extends Controller
{
    public function uc_incribir_regulares()
	{
		// return dd($request);
		$alumno = Alumno::where('cedula',Auth::user()->cedula)->first();
		// return $alumno->InscritoActual()->Inscripcion;
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
					// array_push($incritas,$asignatura->id);
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

		// TODO: ELECTRICIDAD
		$e_r_mat = 0; //reprobo matematica TI
		$e_r_fisi = 0; //reprobo fisica TI
		$e_r_uc_ti = 0; // unidades reprobadas aparte de MAT y MF
		$e_a_uc_ti = 0; // unidades reprobadas aparte de MAT y MF
		$e_r_tde = 0; //reprobo taller de elec T1
		$e_r_psi1 = 0; //reprobo psi T1
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

		// TODO: INGENERIA DE MATERIALES INDUSTRIALES
		$imi_r_ti = 0;
		$imi_a_ti = 0;
		$imi_a_psi1 = 0;
		$imi_a_t1 = 0;
		$imi_a_psi2 = 0;
		$imi_a_psi3 = 0;

		// TODO: HIGIENE Y SEGURIDAD LABORAL
		$hsl_r_ti = 0;
		$hsl_a_ti = 0;
		$hsl_a_psi1 = 0;
		$hsl_a_t1 = 0;
		$hsl_a_psi2 = 0;
		$hsl_a_psi3 = 0;

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
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL
							switch ($asignatura->codigo) {
								case '01MAT000':
									# MATEMATICA TI
									if (round($nota_final) < 12) {
										$e_r_mat = 1; //REPROBO MATEMATICA TI
										array_push($uc_acursar, $asignatura);

									}
								break;

								case '01MFI000':
									# FISICA TI
									if (round($nota_final) < 12) {
										$e_r_fisi = 1; //REPROBO FISICA TI
										array_push($uc_acursar, $asignatura);

									}
								break;

								default:
									if (round($nota_final) < 12) {
										$e_r_uc_ti++; //REPROBO TI
										array_push($uc_acursar, $asignatura);
									}else{
										$e_a_uc_ti++; //APROBO TI

									}
								break;
							}

						break;
							// FIN TRAYECTO INICIAL

							//TRAYECTO 1
						case 1:
						// echo round($nota_final)." $asignatura->nombre <br>";
							if ($e_r_fisi == 0 && $e_r_mat == 0 && $e_a_uc_ti >= 2  && round($nota_final) < 12 && $asignatura->aprueba == 0 || $e_r_fisi == 0 && $e_r_mat == 0 && $e_a_uc_ti >= 2  && round($nota_final) < 16 && $asignatura->aprueba == 1 ) {
									if ($asignatura->codigo == "01TDE105" && $asignatura->aprueba < 12 || $asignatura->codigo == "01PSI106" && $asignatura->aprueba < 16 ) {
										# code...
										$e_r_tde = 1; //REPROBO TALLER DE ELECTRICIDAD T1
									}
										array_push($uc_acursar, $asignatura);
								}

							if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
								# APRUEBA T1
								$e_a_uc_t1++; //APROBO TI

							}
						break;

							// FIN TRAYECTO 1

						case 2:
							// TRAYECTO 2
							// echo "$e_r_tde <br>";
							if (round($nota_final) < 12 && $asignatura->aprueba == 0 && $e_r_tde == 0 && $e_r_fisi == 0 && $e_r_mat == 0 && $e_a_uc_ti >= 2 || round($nota_final) < 16 && $asignatura->aprueba == 1 && $e_r_tde == 0 && $e_r_fisi == 0 && $e_r_mat == 0 && $e_a_uc_ti >= 2  ) {
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
							if ($e_a_uc_t3 == 8 || $e_a_uc_tn == 5) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {

									if ($asignatura->codigo =="01PSI407" && round($nota_final) < 16 ) {
										$e_r_psi4 = 1; // reprobo proyecto
									}


									array_push($uc_acursar, $asignatura);
								}

							}
						break;

						case 5:
							# TRAYECTO 5
							if ($e_r_psi4 == 0 && $e_a_uc_t3 == 8 || $e_a_uc_tn == 5) {
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

					switch ($asignatura->trayecto_id) {
						case 8:
							# TRAYECTO INICIAL
							if ($asignatura->aprueba == 0 && round($nota_final) >= 12) {
								$gcs_a_ti++;
							}else{
								array_push($uc_acursar, $asignatura);
							}
						break;

						case 1:
							# TRAYECTO 1
							if ($gcs_a_ti >= 3 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $gcs_a_ti >= 3 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								# code...
								array_push($uc_acursar, $asignatura);
							}else{
								$gcs_a_t1++;
							}
							if ($asignatura->codigo == "PGT17" && round($nota_final) >= 16) {
								# code...
								$gcs_a_pst1 = 1;
							}
						break;

						case 2:
							# TRAYECTO 2
							if ($gcs_a_ti >= 3 && $gcs_a_pst1 == 1 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $gcs_a_ti >= 3 && $gcs_a_pst1 == 1 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								# code...
								array_push($uc_acursar, $asignatura);
							}else{
								$gcs_a_t2++;
							}
							if ($asignatura->codigo == "PGT27" && round($nota_final) >= 16) {
								# code...
								$gcs_a_pst2 = 1;
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($gcs_a_t1 == 7 && $gcs_a_t2 == 7 && $gcs_a_ti >= 5 && $gcs_a_pst2 == 1 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $gcs_a_t1 == 7 && $gcs_a_t2 == 7 &&  $gcs_a_ti >= 5 && $gcs_a_pst2 == 1 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								# code...
								array_push($uc_acursar, $asignatura);
							}
							if ($asignatura->codigo == "PGT37" && round($nota_final) >= 16) {
								# code...
								$gcs_a_pst3 = 1;
							}
						break;

						case 4:
							# TRAYECTO 4
							if ( $gcs_a_t1 == 7 && $gcs_a_t2 == 7 && $gcs_a_ti >= 5 && $gcs_a_pst3 == 1 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $gcs_a_t1 == 7 && $gcs_a_t2 == 7 && $gcs_a_ti >= 5 && $gcs_a_pst3 == 1 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								# code...
								array_push($uc_acursar, $asignatura);
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
					switch ($asignatura->trayecto_id) {
						case 8:
							# TRAYECTO INICIAL
							if ($asignatura->aprueba == 0 && round($nota_final) >=  12 ) {
								$inf_a_ti++;
							}else{
								array_push($uc_acursar, $asignatura);
							}
						break;

						case 1:
							# TRAYECTO 1
							if ($inf_a_ti >= 3 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $inf_a_ti >= 3 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								array_push($uc_acursar, $asignatura);
							}
							if ($asignatura->codigo == "PTP139" && round($nota_final) >= 16) {
								$inf_a_pst1 = 1;
							}
						break;

						case 2:
							# TRAYECTO 2
							if ($inf_a_ti >= 3 && $inf_a_pst1 == 1 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $inf_a_ti >= 3 && $inf_a_pst1 == 1 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								array_push($uc_acursar, $asignatura);
							}
							if ($asignatura->codigo == "PTP239" && round($nota_final) >= 16) {
								$inf_a_pst2 = 1;
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($inf_a_ti >= 3 && $inf_a_pst2 == 1 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $inf_a_ti >= 3 && $inf_a_pst2 == 1 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								# code...
								array_push($uc_acursar, $asignatura);
							}
							if ($asignatura->codigo == "PTP339" && round($nota_final) >= 16) {
								$inf_a_pst3 = 1;
							}
						break;

						case 4:
							# TRAYECTO 4
							if ( $inf_a_ti >= 3 && $inf_a_pst3 == 1 && $asignatura->aprueba == 0 && round($nota_final) < 12 || $inf_a_ti >= 3 && $inf_a_pst3 == 1 && $asignatura->aprueba == 1 && round($nota_final) < 16) {
								array_push($uc_acursar, $asignatura);
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
					switch ($asignatura->trayecto_id) {
						case 8:
							# TRAYECTO INICIAL

								switch ($asignatura->codigo ) {
									case "MTMA004":
										if (round($nota_final) < 12) {
											$mtto_r_mat = 1; //REPROBO MATEMATICA TI
											array_push($uc_acursar, $asignatura);

										}
									break;

									default:
										if (round($nota_final) < 12) {
											$mtto_r_uc_ti++; //REPROBO TI
											array_push($uc_acursar, $asignatura);
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
							if ($mtto_r_mat == 0 && $mtto_a_uc_ti >= 3 && round($nota_final) < 12 && $asignatura->aprueba == 0 || $mtto_r_mat == 0 && $mtto_a_uc_ti >= 3 && round($nota_final) < 16 && $asignatura->aprueba == 1 ) {
								array_push($uc_acursar, $asignatura);

							}
							if ($asignatura->codigo == "MIPR10112" && round($nota_final) >= 16) {
								$mtto_a_psi1 = 1;
							}
						break;

						case 2:
							// TRAYECTO 2
							if ($mtto_a_psi1 == 1 && round($nota_final) < 12 && $asignatura->aprueba == 0 || $mtto_a_psi1 == 1 && round($nota_final) < 16 && $asignatura->aprueba == 1 ) {
								array_push($uc_acursar, $asignatura);
							}

							if ($asignatura->codigo == "MIPR20412" && round($nota_final) >= 16) {
								$mtto_a_psi2 = 1;
							}
						break;

						case 7:
							# TRAYECTO DE NIVELACION
							if ($mtto_a_uc_ti == 0) {
								if (round($nota_final) > 12) {
									$mtto_a_uc_tn++; //aprobo tn
								}else{
									array_push($uc_acursar, $asignatura);

								}
							}
						break;

						case 3:
							// TRAYECTO 3
							if ($mtto_a_uc_tn == 4 || $mtto_a_psi2 == 1 && round($nota_final) < 12 && $asignatura->aprueba == 0 || $mtto_a_psi2 == 1 && round($nota_final) < 16 && $asignatura->aprueba == 1 ) {

								array_push($uc_acursar, $asignatura);
							}

							if ($asignatura->codigo == "MTPR30712" && round($nota_final) >= 16) {
								$mtto_a_psi3 = 1;
							}
						break;

						case 4:
							// TRAYECTO 4
							if ($mtto_a_psi3 == 1 && round($nota_final) < 12 && $asignatura->aprueba == 0 || $mtto_a_psi3 == 1 && round($nota_final) < 16 && $asignatura->aprueba == 1 ) {
								array_push($uc_acursar, $asignatura);
							}
						break;
					}
					// FIN MANTENIMIENTO
				break;

				// TODO: FALTA MECANICA
				case 60:

					switch ($asignatura->trayecto_id) {
						case 8:
							# TRAYECTO INICIAL
							if ($asignatura->codigo == 'CBAMAT060' && round($nota_final) >= 12) {
								# APRUEBA MATEMATICA PARA CURSAR T1
								$ti_matematica = 1;
							}elseif ($asignatura->codigo != 'CBAMAT060' && $asignatura->aprueba == 0 && round($nota_final) >= 12) {
								$ti_porcentaje_aprobado++;
							}else{
								array_push($uc_acursar, $asignatura);
							}
							// echo $asignatura->nombre.': '.$notas.'<br>';
						break;

						case 1:
							# TRAYECTO 1
							// 75% APROBADO DE TI INCULIDO MATEMATICA
							$ti_porcentaje_aprobado += $ti_matematica;
							if($ti_porcentaje_aprobado >= 3){
								if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {
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
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {

										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;
								case 'DISMAP268':
									if($t1_a_fisica == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {
											// APRUEBA MECÁNICA APLICADA PRECACION DE DISEÑO DE ELEMENTOS MECÁNICOS
											$t2_a_mec_aplicada = true;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'PSIPSI257':
									if($t1_a_psi_i == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {
											// APRUEBA PROYECTO SOCIO-INTEGRADOR II PRECACION DE PROYECTO SOCIO-INTEGRADOR III
											$t2_a_psi_ii = true;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'MYMTME257':
									if($t1_a_dibujo_mecanico == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {
											// APRUEBA TALLER MECANIZADO PRECACION DE DISEÑO DE ELEMENTOS MECÁNICOS
											$t2_a_mec_aplicada = true;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'ENETER268':
									if($t1_a_fisica == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {

										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								default:
									# RESTO DE LAS UC DE T1 QUE NO TIENEN PRELACION
									if($t1_cursado >= 5){
										array_push($uc_acursar, $asignatura);
									}
								break;
							}

						break;

						case 3:
							switch ($asignatura->codigo) {
								case 'DISDEM354':
									# code...
									if ($t2_a_mec_aplicada == true && $t2_a_mec_aplicada == true) {
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {

										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;
								case 'AUTEIA354':
									if($t1_a_fisica == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {

										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'PSIPSI354':
									if($t2_a_psi_ii == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {
											// APRUEBA PROYECTO SOCIO-INTEGRADOR II PRECACION DE PROYECTO SOCIO-INTEGRADOR III
											$t3_a_psi_iii = true;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'ENEMHI354':
									if($t1_a_fisica == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {
											// APRUEBA TALLER MECANIZADO PRECACION DE DISEÑO DE ELEMENTOS MECÁNICOS
											// $t2_a_mec_aplicada = true;
										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								case 'MYMCNC354':
									if($t2_a_mec_aplicada == true){
										if ($asignatura->aprueba == 0 && round($nota_final) >= 12 || $asignatura->aprueba == 0 && round($nota_final) >= 16) {

										}else{
											array_push($uc_acursar, $asignatura);
										}
									}
								break;

								default:
									# RESTO DE LAS UC DE T1 QUE NO TIENEN PRELACION
									if($t2_cursado >= 5){
										array_push($uc_acursar, $asignatura);
									}
								break;
							}
						break;

						case 4:
							if ($cursado >= 1) {
								$t4_cursado += 1;
							}
							if ($titulo == 1) {
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
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL

							if (round($nota_final) < 12) {
								$cya_r_ti++; //REPROBO MATEMATICA TI
									array_push($uc_acursar, $asignatura);
							}else{
								$cya_a_ti++;
							}

						break;

						case 1:
							// TRAYECTO 1
							if ($cya_r_ti == 0) {
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
								}
							}
						break;

						case 2:
							// TRAYECTO 2
							if ($cya_a_psi1 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);

								}

								if($asignatura->codigo == "SCPSI3181206" &&  round($nota_final) >= 16){
									$cya_a_psi2 = 1;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($cya_a_t1 == 8 && $cya_a_ti == 5 && $cya_a_psi2 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
							}

							if($asignatura->codigo == "SCPSII3303306" &&  round($nota_final) >= 16){
								$cya_a_psi3 = 1;
							}
						break;

						case 4:
							// TRAYECTO 4
							if ($cya_a_psi3 == 1) {
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
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL

							if (round($nota_final) < 12) {
								$oyj_r_ti++; //REPROBO MATEMATICA TI
									array_push($uc_acursar, $asignatura);
							}else{
								$oyj_a_ti++;
							}

						break;

						case 1:
							// TRAYECTO 1
							if ($oyj_a_ti >= 0) {
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
								}
							}
						break;

						case 2:
							// TRAYECTO 2
							if ($oyj_a_psi1 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);

								}

								if($asignatura->codigo == "PROY2367" &&  round($nota_final) >= 16){
									$oyj_a_psi2 = 1;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($oyj_a_t1 == 8 && $oyj_a_ti == 5 && $oyj_a_psi2 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
							}

							if($asignatura->codigo == "PROY3367" &&  round($nota_final) >= 16){
								$oyj_a_psi3 = 1;
							}
						break;

						case 4:
							// TRAYECTO 4
							if ($oyj_a_psi3 == 1) {
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
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL

							if (round($nota_final) < 12) {
								$imi_r_ti++;
								array_push($uc_acursar, $asignatura);
							}else{
								$imi_a_ti++;
							}

						break;

						case 1:
							// TRAYECTO 1
							if ($imi_a_ti >= 0) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									if($asignatura->codigo == "PROY1367"){
										$imi_r_psi1 = 1;
									}
									array_push($uc_acursar, $asignatura);
								}

								if($asignatura->codigo == "PROY1367" &&  round($nota_final) >= 16){
									$imi_a_psi1 = 1;
								}

								if (round($nota_final) >= 12 && $asignatura->aprueba == 0 || round($nota_final) >= 16 && $asignatura->aprueba == 1) {
									$imi_a_t1++;
								}
							}
						break;

						case 2:
							// TRAYECTO 2
							if ($imi_a_psi1 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);

								}

								if($asignatura->codigo == "PROY2367" &&  round($nota_final) >= 16){
									$imi_a_psi2 = 1;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($imi_a_t1 == 8 && $imi_a_ti == 5 && $imi_a_psi2 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
							}

							if($asignatura->codigo == "PROY3367" &&  round($nota_final) >= 16){
								$imi_a_psi3 = 1;
							}
						break;

						case 4:
							// TRAYECTO 4
							if ($imi_a_psi3 == 1) {
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
					switch ($asignatura->trayecto_id) {
						case 8:
							// TRAYECTO INICIAL

							if (round($nota_final) < 12) {
								$hsl_r_ti++;
								array_push($uc_acursar, $asignatura);
							}else{
								$hsl_a_ti++;
							}

						break;

						case 1:
							// TRAYECTO 1
							if ($hsl_a_ti >= 0) {
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
								}
							}
						break;

						case 2:
							// TRAYECTO 2
							if ($hsl_a_psi1 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);

								}

								if($asignatura->codigo == "HSPR2540218" &&  round($nota_final) >= 16){
									$hsl_a_psi2 = 1;
								}
							}
						break;

						case 3:
							# TRAYECTO 3
							if ($hsl_a_t1 == 8 && $hsl_a_ti == 5 && $hsl_a_psi2 == 1) {
								if (round($nota_final) < 12 && $asignatura->aprueba == 0 || round($nota_final) < 16 && $asignatura->aprueba == 1) {
									array_push($uc_acursar, $asignatura);
								}
							}

							if($asignatura->codigo == "HSPR3540318" &&  round($nota_final) >= 16){
								$hsl_a_psi3 = 1;
							}
						break;

						case 4:
							// TRAYECTO 4
							if ($hsl_a_psi3 == 1) {
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

				default:
					# code...
					break;
			}
		}


		return view('panel.estudiantes.inscripciones.regulares.uc_inscribir',['alumno' => $alumno, 'uc_acursar' => $uc_acursar]);
	}

	public function store(Request $request)
	{
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
			DB::commit();
			return redirect()->route('panel.estudiante.inscripciones.regulares.index')->with('jet_mensaje','inscripcion realizada con exito');
		} catch (\Throwable $th) {
			DB::rollback();
			return redirect()->route('panel.estudiante.inscripciones.regulares.index')->with('jet_error',$th->getMessage());
		}
		// return dd($request);
	}
}
