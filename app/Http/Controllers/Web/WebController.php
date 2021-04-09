<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActualizacionDato;
use App\Models\Alumno;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebController extends Controller
{
	public function cambiar_rol($rol)
	{
		session(['rol' => $rol]);
		$panel = Str::lower($rol);
		switch ($rol) {
			case 'Docente':
				return redirect()->route('panel.'.$panel.'.index');
				break;
			case 'Estudiante':
				return redirect()->route('panel.'.$panel.'.index');
				break;
			default:
				return redirect()->route('panel.index');
				break;
		}
		// return redirect()->route('panel.'.$panel.'.index');
	}
    public function index_estudiante_actualizar()
	{
		$actual = Carbon::now();
		// $inicio = Carbon::create(2021, 4, 7, 8, 30, 00);
		$inicio = Carbon::create(2021, 4, 8, 8, 30, 00);
		$fin = Carbon::create(2021, 4, 23, 23, 59, 00);
		if($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin)){
			return view('web.estudiantes.index');
		}else{
			abort(404);
		}
	}

	public function search_estudiante_actualizar(Request $request)
	{
		$request->validate([
			'nacionalidad' => 'required',
			'cedula' => 'required|numeric|digits_between:6,9'
		]);
		$alumno  = Alumno::where('cedula',$request->cedula)->where('nacionalidad',$request->nacionalidad)->first();
		$actulaizo_datos = ActualizacionDato::where('alumno_id',$alumno->id)->first();
		if($actulaizo_datos){
			return back()->with('jet_error','Ya realizó la actualización de datos. Inicie sesión para mas opciones.');
		}
		if($alumno){

			switch ($alumno->Pnf->codigo) {
				case 40:
										//   año  mes dia hora minuto segundo
					$inicio = Carbon::create(2021, 4, 16, 0, 0, 0);
					break;
				case 45:
										//   año  mes dia hora minuto segundo
					$inicio = Carbon::create(2021, 4, 19, 0, 0, 0);
					break;
				case 50:
										//   año  mes dia hora minuto segundo
					$inicio = Carbon::create(2021, 4, 13, 0, 0, 0);
					break;
				case 55:
										//   año  mes dia hora minuto segundo
					$inicio = Carbon::create(2021, 4, 12, 0, 0, 0);
					break;
				case 60:
										//   año  mes dia hora minuto segundo
					$inicio = Carbon::create(2021, 4, 15, 0, 0, 0);
					break;
				case 65:
										//   año  mes dia hora minuto segundo
					$inicio = Carbon::create(2021, 4, 9, 0, 0, 0);
					break;
				case 70:
										//   año  mes dia hora minuto segundo
					$inicio = Carbon::create(2021, 4, 21, 0, 0, 0);
					break;
				case 75:
										//   año  mes dia hora minuto segundo
					$inicio = Carbon::create(2021, 4, 8, 0, 0, 0);
					break;
				case 80:
										//   año  mes dia hora minuto segundo
					$inicio = Carbon::create(2021, 4, 8, 8, 30, 0);
					break;

				default:
					# code...
					break;
			}
			$actual = Carbon::now();
			$fin = Carbon::create(2021, 4, 23, 0, 0, 0);
			if($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin)){
				$id_encriptado = encrypt($alumno->id);
				return redirect()->route('actualizar-datos.show-form',['id_encriptado' => $id_encriptado]);
			}else{
				$inicio = Carbon::parse($inicio)->diffForHumans();
				$mensaje = "El sistema aperturará  $inicio para el PNF en ".$alumno->Pnf->nombre;
				return back()->with('jet_error',$mensaje);
			}
			// return view('web.estudiantes.buscar_estudiante',['alumno' => $alumno]);
		}else{
			$mensaje = "La Cédula:  <b class='mx-2 underline'>".$request->nacionalidad."-".$request->cedula."</b> no se encuenta en nuestros registros.";
			return back()->with('jet_error',$mensaje);
		}
	}

	public function show_form_actualizar_estudiante($id_encriptado)
	{
		$id_desencriptado = decrypt($id_encriptado);
		$alumno  = Alumno::find($id_desencriptado);
		return view('web.estudiantes.buscar_estudiante',['alumno' => $alumno]);
	}
}
