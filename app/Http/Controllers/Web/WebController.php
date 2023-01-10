<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActualizacionDato;
use App\Models\Alumno;
use App\Models\Asignado;
use App\Models\Evento;
use App\Models\Graduando;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

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
			case 'Coordinador':
				return redirect()->route('panel.'.$panel.'.index');
				break;
			case 'Auxiliar':
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
		$actual = \Carbon\Carbon::now()->toDateTimeString();
		$evento_actualizacion_datos_activo = false;
		$evento_actualizacion_datos = Evento::where('tipo','ACTUALIZACION DE DATOS')
		->where('evento_padre',0)
		->where('inicio','<=',$actual)
		->where('fin','>=',$actual)
		->orderBy('id','desc')
		->first();
		if($evento_actualizacion_datos){
			$evento_actualizacion_datos_activo = true;
		}
		if($evento_actualizacion_datos_activo){
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
		$actual = \Carbon\Carbon::now()->toDateTimeString();
		$evento_actualizacion_datos_activo = false;
		$evento_actualizacion_datos = Evento::where('tipo','ACTUALIZACION DE DATOS')
		->where('evento_padre',0)
		->where('inicio','<=',$actual)
		->where('fin','>=',$actual)
		->orderBy('id','desc')
		->first();
		if($evento_actualizacion_datos){
			$evento_actualizacion_datos_activo = true;
		}

		$alumno  = Alumno::where('cedula',$request->cedula)->where('nacionalidad',$request->nacionalidad)->first();
		$actulaizo_datos = ActualizacionDato::where('alumno_id',$alumno->id)->where('estatus','ACTUALIZADO')->where('updated_at','>=',$evento_actualizacion_datos->inicio)->first();
		if($actulaizo_datos){
			return back()->with('jet_error','Ya realizó la actualización de datos. Inicie sesión para mas opciones.');
		}
		if($alumno){

			// switch ($alumno->Pnf->codigo) {
			// 	case 40:
			// 							//   año  mes dia hora minuto segundo
			// 		$inicio = Carbon::create(2021, 4, 16, 0, 0, 0);
			// 		break;
			// 	case 45:
			// 							//   año  mes dia hora minuto segundo
			// 		$inicio = Carbon::create(2021, 4, 19, 0, 0, 0);
			// 		break;
			// 	case 50:
			// 							//   año  mes dia hora minuto segundo
			// 		$inicio = Carbon::create(2021, 4, 13, 0, 0, 0);
			// 		break;
			// 	case 55:
			// 							//   año  mes dia hora minuto segundo
			// 		$inicio = Carbon::create(2021, 4, 12, 0, 0, 0);
			// 		break;
			// 	case 60:
			// 							//   año  mes dia hora minuto segundo
			// 		$inicio = Carbon::create(2021, 4, 15, 0, 0, 0);
			// 		break;
			// 	case 65:
			// 							//   año  mes dia hora minuto segundo
			// 		$inicio = Carbon::create(2021, 4, 9, 0, 0, 0);
			// 		break;
			// 	case 70:
			// 							//   año  mes dia hora minuto segundo
			// 		$inicio = Carbon::create(2021, 4, 21, 0, 0, 0);
			// 		break;
			// 	case 75:
			// 							//   año  mes dia hora minuto segundo
			// 		$inicio = Carbon::create(2021, 4, 8, 0, 0, 0);
			// 		break;
			// 	case 80:
			// 							//   año  mes dia hora minuto segundo
			// 		$inicio = Carbon::create(2021, 4, 8, 8, 30, 0);
			// 		break;

			// 	default:
			// 		# code...
			// 		break;
			// }
			$actual = \Carbon\Carbon::now()->toDateTimeString();
			$evento_actualizacion_datos_activo = false;
			$evento_actualizacion_datos = Evento::where('tipo','ACTUALIZACION DE DATOS')
			->where('evento_padre',0)
			->where('inicio','<=',$actual)
			->where('fin','>=',$actual)
			->orderBy('id','desc')
			->first();
			if($evento_actualizacion_datos){
				$evento_actualizacion_datos_activo = true;
			}
			if($evento_actualizacion_datos_activo == true){
				$id_encriptado = encrypt($alumno->id);
				return redirect()->route('actualizar-datos.show-form',['id_encriptado' => $id_encriptado]);
			}else{
				$inicio = Carbon::parse($evento_actualizacion_datos->inicio)->diffForHumans();
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


	// TODO: NUEVO INGRESO


	public function index_nuevo_ingreso()
	{
		$actual = Carbon::now();
		// $inicio = Carbon::create(2021, 4, 7, 8, 30, 00);
		$inicio = Carbon::create(2021, 9, 27, 8, 30, 00);
		$fin = Carbon::create(2021, 10, 15, 23, 59, 00);
		// $fin = Carbon::create(2021, 4, 23, 23, 59, 00);
		if($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin) || Auth::user()->hasRole('Admin')){
			return view('web.nuevo_ingreso.asignados.index');
		}else{
			abort(404);
		}
	}

	public function search_asignado(Request $request)
	{
		$request->validate([
			'nacionalidad' => 'required',
			'cedula' => 'required|numeric|digits_between:6,9'
		]);
		$alumno  = Alumno::where('cedula',$request->cedula)->where('nacionalidad',$request->nacionalidad)->first();
		$id = ($alumno) ? $alumno->id : '' ;
		$actulaizo_datos = ActualizacionDato::where('alumno_id',$id)->first();
		$nuevo = Asignado::where('cedula',$request->cedula)->first();
		if($actulaizo_datos){
			return back()->with('jet_error','Ya realizó la actualización de datos. Inicie sesión para mas opciones.');
		}
		if($nuevo){

			$actual = Carbon::now();
			$inicio = Carbon::create(2021, 9, 27, 8, 30, 00);
			$fin = Carbon::create(2021, 10, 15, 23, 59, 00);
			if($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin) || Auth::user()->hasRole('Admin')){
				$id_encriptado = encrypt($nuevo->id);
				return redirect()->route('nuevo-ingreso.asignados.show-form',['id_encriptado' => $id_encriptado]);
			}else{
				$inicio = Carbon::parse($inicio)->diffForHumans();
				$mensaje = "El sistema aperturará  $inicio para el PNF en ".$nuevo->Pnf->nombre;
				return back()->with('jet_error',$mensaje);
			}
			// return view('web.estudiantes.buscar_estudiante',['alumno' => $alumno]);
		}else{
			$mensaje = "La Cédula:  <b class='mx-2 underline'>".$request->nacionalidad."-".$request->cedula."</b> no se encuenta en nuestros registros.";
			return back()->with('jet_error',$mensaje);
		}
	}

	public function show_form_asignado($id_encriptado)
	{
		$id_desencriptado = decrypt($id_encriptado);
		$nuevo  = Asignado::find($id_desencriptado);
		return view('web.nuevo_ingreso.asignados.form',['nuevo' => $nuevo]);
	}

	public function verifcar_graduando($nacionalidad, $cedula)
	{
		$titulos = Graduando::where('cedula',$cedula)->orderBy('egreso','asc')->get();
		$graduando = Graduando::where('cedula',$cedula)->orderBy('egreso','asc')->first();

		return view('web.verificar_titulo.ver_detalles',['titulos' => $titulos, 'graduando' => $graduando]);
	}


	// FLOTANTE

	public function show_form_flotante()
	{
		$actual = Carbon::now();
		$inicio = Carbon::create(2022, 2, 21, 8, 30, 00);
		// $fin = Carbon::create(2022, 2, 25, 23, 59, 00);
		$fin = Carbon::create(2022, 3, 9, 23, 59, 00);
		if($actual->greaterThanOrEqualTo($inicio) == true && $actual->lessThanOrEqualTo($fin) ){
			return view('web.nuevo_ingreso.flotante.index');
		}else{
			abort(404);
		}
	}
}
