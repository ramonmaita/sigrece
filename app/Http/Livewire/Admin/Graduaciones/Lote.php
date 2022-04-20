<?php

namespace App\Http\Livewire\Admin\Graduaciones;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Graduando;
use App\Models\HistoricoNota;
use App\Models\Pnf;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Lote extends Component
{
	public $periodos = [], $tipo, $especialidad, $pnfs = [], $titulos = [], $titulo, $periodo;

	public $graduandos = [];
	public function mount()
	{
		$this->periodos = Graduando::groupBy('periodo')->get();
		$this->pnfs = Pnf::whereNotIn('codigo', ['20', '25', '30', '35'])->get();
	}

	public function render()
	{

		return view('livewire.admin.graduaciones.lote');
	}

	public function buscar()
	{
		$this->reset('graduandos');
		$this->emit('recargar_alertas');
		$this->validate(
			[
				'periodo' => 'required',
				'especialidad' => 'required',
				'titulo' => 'required',
			],
			[],
			[
				'especialidad' => 'PNF | Carrera'
			]
		);
		$this->graduandos = Graduando::where('pnf', $this->especialidad)->where('periodo', $this->periodo)->where('titulo', $this->titulo)->skip(0)->take(10)->get();

		// dd($this->graduandos);
	}

	public function updated($campo)
	{
		if ($campo == 'especialidad' || $campo == 'titulo') {
			$this->reset('graduandos');
		}
	}

	public function promedios()
	{
		$this->reset('graduandos');
		$this->emit('recargar_alertas');
		$this->validate(
			[
				'periodo' => 'required',
				'especialidad' => 'required',
				'titulo' => 'required',
			],
			[],
			[
				'especialidad' => 'PNF | Carrera'
			]
		);
		try {
			DB::beginTransaction();

			$aspirantes = Graduando::where('pnf', $this->especialidad)->where('periodo', $this->periodo)->where('titulo', $this->titulo)->where('ira',0)->get();

			// return dd($aspirantes);
			foreach ($aspirantes as $key => $aspirante) {
				$nota_promedio = 0;
				$creditos = 0;
				$creditos_totales = 0;
				$alumno = Alumno::where('cedula', $aspirante->cedula)->first();
				// $titulo = ($aspirante->titulo == 'TSU') ? 1 : 2;
				$titulo = $aspirante->titulo;
				// $graduando = Graduando::find($this->id);
				$g = 1;
				ini_set('max_execution_time', 4200);
				// $alumno = Alumno::where('cedula', $graduando->cedula)->first();

				if($alumno){

					// $creditos_totales = 0;
					if ($aspirante->titulo == 1) {
						if ($alumno->pnf_id == 1 && $alumno->plan_id == 5 || $alumno->pnf_id == 5 && $alumno->plan_id == 21) {

							$asignaturas = Asignatura::whereIn('trayecto_id', [7, 8, 1, 2, 3])->where('pnf_id', $alumno->Pnf->id)->where('plan_id', $alumno->Plan->id)->get();
						} else {

							$asignaturas = Asignatura::whereIn('trayecto_id', [8, 1, 2])->where('pnf_id', $alumno->Pnf->id)->where('plan_id', $alumno->Plan->id)->get();
						}

						// $asignaturas = Asignatura::where('codigo','APT1312')->get();
						$n = HistoricoNota::select('*', DB::raw(' count(*) as total'))->where('cedula_estudiante', $alumno->cedula)->where('especialidad', $alumno->Pnf->codigo)->where('estatus', 0)
							->groupBy('cod_asignatura')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC')->get();
					}


					if ($aspirante->titulo == 2) {
						$asignaturas = Asignatura::where('pnf_id', $alumno->Pnf->id)->where('plan_id', $alumno->Plan->id)->get();
						// $asignaturas = Asignatura::where('pnf_id',$alumno->Pnf->codigo)->where('trayecto_id','!=', 7)->where('plan',$alumno->Plan->codigo)->get();

						// $asignaturas = Asignatura::where('codigo','APT1312')->get();
						$n = HistoricoNota::select('*', DB::raw(' count(*) as total'))->where('cedula_estudiante', $alumno->cedula)->where('especialidad', $alumno->Pnf->codigo)->where('estatus', 0)
							->groupBy('cod_asignatura')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC')->get();
					} else {
						$n = HistoricoNota::select('*', DB::raw(' count(*) as total'))->where('cedula_estudiante', $alumno->cedula)->where('especialidad', $alumno->Pnf->codigo)->where('estatus', 0)
							->groupBy('cod_asignatura')->OrderByRaw('cod_desasignatura ASC, nro_periodo ASC')->get();
					}

					foreach ($asignaturas as $asig_a) {
						foreach ($alumno->Periodos as $periodo) {
							$c = count($asig_a->DesAsignaturas);
							'<b>' . $periodo->periodo . ' ' . $periodo->nro_periodo . '</b><br>';
							$creditos_periodo = 0;
							if ($this->ultima_notas($periodo->periodo, $alumno->cedula, $alumno->Pnf->codigo, $asig_a->codigo)[1] != 0) {
								$asig_a->Trayecto->nombre . ' ' . $asig_a->nombre . ' ' . round($this->ultima_notas($periodo->periodo, $alumno->cedula, $alumno->Pnf->codigo, $asig_a->codigo)[1] / $c) . ' UC: ' . $asig_a->credito . '<br>';
								if (round($this->ultima_notas($periodo->periodo, $alumno->cedula, $alumno->Pnf->codigo, $asig_a->codigo)[1] / $c) != 30) {
									$creditos_totales += $asig_a->credito;
									$creditos_periodo += $asig_a->credito;
								}
							}
							$creditos_periodo;
							'<hr>';
						}
					}
				// return dd($asignaturas);

					$n = 1;
					$t_n = 0;
					$t_c = 0;
					$nota_promedio = 0;
					$creditos_aprobados = 0;
					$creditos_plan = $alumno->Plan->uc_plan($titulo);

					foreach ($asignaturas as $asignatura) {
						$ul_p = $this->ultimo_periodo($alumno->cedula, $alumno->Pnf->codigo, $asignatura->codigo)[0];
						$nota_final = ($this->ultima_notas($ul_p, $alumno->cedula, $alumno->Pnf->codigo, $asignatura->codigo)[1] != 0) ?  round($this->ultima_notas($ul_p, $alumno->cedula, $alumno->Pnf->codigo, $asignatura->codigo)[1] / count($asignatura->DesAsignaturas)) : 1;
						if ($asignatura->Trayecto->id == 7 && $this->ultima_notas($ul_p, $alumno->cedula, $alumno->Pnf->codigo, $asignatura->codigo)[1] == 0) {
							// echo ultima_notas($ul_p,$alumno->cedula,$alumno->Pnf->codigo,$asignatura->codigo)[1];
							// $creditos_totales -= $asignatura->credito;
							$creditos_plan -= $asignatura->credito;
						} else {
							if ($nota_final != 30  && $nota_final != 0) {
								if ($alumno->tipo == 12 && @$asignatura->aprueba == 0 && round($nota_final) >= 12 || $alumno->tipo == 1 && @$asignatura->aprueba == 0 && round($nota_final) >= 12 || @$alumno->tipo == 12 &&  round($nota_final) >= 16 && @$asignatura->aprueba == 1 || @$alumno->tipo == 1 &&  round($nota_final) >= 16 && @$asignatura->aprueba == 1) {

									$nota_promedio = $nota_promedio + (round($nota_final) * @$asignatura->credito);
								}
								$creditos_aprobados += @$asignatura->credito;
								if ($alumno->tipo == 10 &&  round($nota_final) >= 10) {

									$nota_promedio = $nota_promedio + (round($nota_final) * @$asignatura->credito);
									// $creditos_aprobados += @$asignatura->credito;
								}
							} else {
								$creditos_plan -= @$asignatura->credito;
								// $creditos_totales -= @$asignatura->credito;
							}
							$t_c += $asignatura->credito;
							$t_n += $nota_final * $asignatura->credito;
						}
					}

					$ira = ($creditos_aprobados == 0 && $nota_promedio == 0) ? 0 : round($nota_promedio / $creditos_aprobados, 2);
					$ida = ($creditos_plan == 0 && $creditos_totales == 0) ? 0 : round($ira * ($creditos_plan / $creditos_totales), 2);

					Graduando::find($aspirante->id)->update(['ida' => $ida, 'ira' => $ira,'f_nacimiento' => $alumno->fechan]);
				}
			}
			// return dd($asignaturas);
			$this->graduandos = Graduando::where('pnf', $this->especialidad)->where('periodo', $this->periodo)->where('titulo', $this->titulo)->get();
			DB::commit();
			$this->emit('mensajes','success','success');
		} catch (\Throwable $th) {
			DB::rollback();
			$this->emit('mensajes','error',$th->getMessage());
		}

	}

	function ultimo_periodo($cedula_estudiante, $pnf, $cod_anual)
	{
		@$p = collect(HistoricoNota::select('periodo')->where('especialidad', $pnf)->where('cedula_estudiante', $cedula_estudiante)->where('cod_asignatura', $cod_anual)->OrderByRaw(' nro_periodo ASC')->where('estatus', 0)->get())->last();

		return [@$p->periodo, @$p->nro_periodo];
	}

	function ultima_notas($periodo,$cedula_estudiante,$pnf,$cod_anual)
{
    $a  = array(); //NOTAS DE LOS TRIMESTRES ->OrderBy('ASIGNATURA' ,'ASC')->OrderBy('PERIODO' ,'DESC')
    $nota_final  = array(); // SUMATORIA DE LOS TRIMESTRES
    $uc =  array(); //CONTADOR PARA MULTIPLICAR POR LAS UC
     $t_p =  HistoricoNota::where('especialidad',$pnf)->where('periodo',$periodo)->where('cedula_estudiante',$cedula_estudiante)->where('cod_asignatura',$cod_anual)->OrderByRaw(' nro_periodo ASC, cod_desasignatura ASC')->where('estatus',0)->groupBy('cod_desasignatura')->pluck('nota');


     $notas = '';
     $n = 0;
     foreach ($t_p as $nt) {
        $notas = $notas .' '. $nt;
        $n += $nt;
     }

    // if ($cod_anual ==="AAA133" || $cod_anual ==="AAA233" || $cod_anual ==="AAA333" || $cod_anual ==="AAA433"|| $cod_anual ==="CBATPE0309") {
    //     // $not = 20;
    //     // $nota_f = $not;
    //     // $contador = 1;

    //     $notas = 20;
    //     $n += 20;
    // }


     return [$notas,$n];

}
}
