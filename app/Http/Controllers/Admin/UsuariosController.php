<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RegistroUsuario;
use App\Models\Docente;
use App\Models\HistoricoNota;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.admin.usuarios.index',['usuarios' => User::all()]);
    }

	public function dataDocente(Request $request)
	{
		// return dd($request);
		$docentes = Docente::where('cedula','like',$request->term.'%')
					->orWhere('nombres','like',$request->term.'%')
					->orWhere('apellidos','like',$request->term.'%')
					->orderBy('cedula')
					->get();
		$a = [];
		foreach ($docentes as  $docente) {
			$a[] = ['id' => $docente->id, 'text' => $docente->cedula.' '.$docente->nombres.' '.$docente->apellidos];
		}

		return response()->json($a);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        return view('panel.admin.usuarios.show',['usuario' => $usuario, 'roles' => Role::all(),'permisos' => Permission::all()]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		Auth::loginUsingId($id);

		return redirect('panel/');
		return redirect()->route('panel.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        try {
            DB::beginTransaction();
                $usuario->roles()->sync($request->roles);
            DB::commit();

            return redirect()->route('panel.usuarios.index')->with('mensaje', 'Roles Asigandos Correctamente');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->with('error',$th->getMessage());
        }
    }
    public function permisos(Request $request, User $usuario)
    {
        try {
            DB::beginTransaction();
                $usuario->permissions()->sync($request->permisos);
            DB::commit();

            return redirect()->route('panel.usuarios.index')->with('mensaje', 'Permisos Asigandos Correctamente');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->with('error',$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

	public function generar_usuarios()
	{
		return abort(403);

		// DB::select('select * from users where active = ?', [1])
		$registros=0;
		$docentes = DB::table('docentes_totales')->where('estatus','ACTIVO')->get();
		foreach ($docentes as $key => $docente) {
			$password = Str::random(8);

			$usuario = User::create([
				'cedula' => $docente->cedula,
				'nombre' => $docente->nombres,
				'apellido' => $docente->apellidos,
				'email' => $docente->email,
				'password' => bcrypt($password)
			]);

			$usuario->roles()->sync([3]);
			Mail::to($usuario->email)->send(new RegistroUsuario($usuario,$password));
			$registros++;
		}
		return redirect()->route('panel.usuarios.index')->with('mensaje', "Se han Generado $registros usuarios con exito.");
	}

	public function agregar()
	{
		return abort(403);
		$estudiantes = array(
			23551021,
			25755866,
			26359519,
			26883819,
			27255494,
			27490445,
			28665471,
			28668514,
			28694459,
			28725914,
			30061971,
			30091525,
			30119347,
			30478377,
			30555159,
			30660688,
			30768587,
			30826174,
			30842310,
			30939694
		);
		// $estudiantes = array(
		// 	19382441,
		// 	20930069,
		// 	23584761,
		// 	26124165,
		// 	26500300,
		// 	26863429,
		// 	26863477,
		// 	27026171,
		// 	27255773,
		// 	27490648,
		// 	27838712,
		// 	27838929,
		// 	27956461,
		// 	28112267,
		// 	28112285,
		// 	28112959,
		// 	28112988,
		// 	28273016,
		// 	28273024,
		// 	28273052,
		// 	28273118,
		// 	28273132,
		// 	28273434,
		// 	28513742,
		// 	28556246,
		// 	28631132,
		// 	28631398,
		// 	28655705,
		// 	28665878,
		// 	28665964,
		// 	28694591,
		// 	28700309,
		// 	28708667,
		// 	28726290,
		// 	28726299,
		// 	28736069,
		// 	28736081,
		// 	28769079,
		// 	30365699
		// );

		try {
			DB::beginTransaction();

			foreach ($estudiantes as $key => $estudiante) {
				HistoricoNota::create([
					"periodo" => "2020",
					"nro_periodo" => 37,
					"cedula_estudiante" => $estudiante,
					"cod_desasignatura" => "T75-0-00-MAT19",
					"cod_asignatura" => "75MAT015",
					"nombre_asignatura" => "MATEMÁTICAS I",
					"nota" => 0,
					"observacion" => "POR CERRAR",
					"seccion" => "TI-IMI-1M",
					"especialidad" => 75,
					"cedula_docente" => 0,
					"docente" => "SIN ASIGNAR",
					"tipo" => "NORMAL",
					"estatus" => 1,
				]);
				HistoricoNota::create([
					"periodo" => "2020",
					"nro_periodo" => 37,
					"cedula_estudiante" => $estudiante,
					"cod_desasignatura" => "T75-0-00-PNC19",
					"cod_asignatura" => "75PNC011",
					"nombre_asignatura" => "PROYECTO NACIONAL Y NUEVA CIUDADANÍA",
					"nota" => 0,
					"observacion" => "POR CERRAR",
					"seccion" => "TI-IMI-1M",
					"especialidad" => 75,
					"cedula_docente" => 0,
					"docente" => "SIN ASIGNAR",
					"tipo" => "NORMAL",
					"estatus" => 1,
				]);
				HistoricoNota::create([
					"periodo" => "2020",
					"nro_periodo" => 37,
					"cedula_estudiante" => $estudiante,
					"cod_desasignatura" => "T75-0-00-IPN19",
					"cod_asignatura" => "75IPN011",
					"nombre_asignatura" => "INTRODUCCIÓN A LOS PROYECTOS Y AL PROGRAMA NACIONAL DE FORMACIÓN",
					"nota" => 0,
					"observacion" => "POR CERRAR",
					"seccion" => "TI-IMI-1M",
					"especialidad" => 75,
					"cedula_docente" => 0,
					"docente" => "SIN ASIGNAR",
					"tipo" => "NORMAL",
					"estatus" => 1,
				]);
				HistoricoNota::create([
					"periodo" => "2020",
					"nro_periodo" => 37,
					"cedula_estudiante" => $estudiante,
					"cod_desasignatura" => "T75-0-00-TEX19",
					"cod_asignatura" => "75TEX012",
					"nombre_asignatura" => "TALLER DE EXPRESIÓN ORAL Y ESCRITA",
					"nota" => 0,
					"observacion" => "POR CERRAR",
					"seccion" => "TI-IMI-1M",
					"especialidad" => 75,
					"cedula_docente" => 0,
					"docente" => "SIN ASIGNAR",
					"tipo" => "NORMAL",
					"estatus" => 1,
				]);

				// HistoricoNota::create([
				// 	"periodo" => "2020",
				// 	"nro_periodo" => 37,
				// 	"cedula_estudiante" => $estudiante,
				// 	"cod_desasignatura" => "S-60-01-DIM15",
				// 	"cod_asignatura" => "DISDIM157",
				// 	"nombre_asignatura" => "DIBUJO MECANICO",
				// 	"nota" => 0,
				// 	"observacion" => "POR CERRAR",
				// 	"seccion" => "T1-MEC-CAI",
				// 	"especialidad" => 60,
				// 	"cedula_docente" => 0,
				// 	"docente" => "SIN ASIGNAR",
				// 	"tipo" => "NORMAL",
				// 	"estatus" => 1,
				// ]);

				// HistoricoNota::create([
				// 	"periodo" => "2020",
				// 	"nro_periodo" => 37,
				// 	"cedula_estudiante" => $estudiante,
				// 	"cod_desasignatura" => "S-60-01-TDM15",
				// 	"cod_asignatura" => "MYMTMA157",
				// 	"nombre_asignatura" => "TECNOLOGIA DE LOS MATERIALES",
				// 	"nota" => 0,
				// 	"observacion" => "POR CERRAR",
				// 	"seccion" => "T1-MEC-CAI",
				// 	"especialidad" => 60,
				// 	"cedula_docente" => 0,
				// 	"docente" => "SIN ASIGNAR",
				// 	"tipo" => "NORMAL",
				// 	"estatus" => 1,
				// ]);

				// HistoricoNota::create([
				// 	"periodo" => "2020",
				// 	"nro_periodo" => 37,
				// 	"cedula_estudiante" => $estudiante,
				// 	"cod_desasignatura" => "S-60-01-FIS15",
				// 	"cod_asignatura" => "CBAFIS145",
				// 	"nombre_asignatura" => "FISICA",
				// 	"nota" => 0,
				// 	"observacion" => "POR CERRAR",
				// 	"seccion" => "T1-MEC-CAI",
				// 	"especialidad" => 60,
				// 	"cedula_docente" => 0,
				// 	"docente" => "SIN ASIGNAR",
				// 	"tipo" => "NORMAL",
				// 	"estatus" => 1,
				// ]);
				// HistoricoNota::create([
				// 	"periodo" => "2020",
				// 	"nro_periodo" => 37,
				// 	"cedula_estudiante" => $estudiante,
				// 	"cod_desasignatura" => "S-60-01-CAL15",
				// 	"cod_asignatura" => "CBACAL168",
				// 	"nombre_asignatura" => "CALCULO I",
				// 	"nota" => 0,
				// 	"observacion" => "POR CERRAR",
				// 	"seccion" => "T1-MEC-CAI",
				// 	"especialidad" => 60,
				// 	"cedula_docente" => 0,
				// 	"docente" => "SIN ASIGNAR",
				// 	"tipo" => "NORMAL",
				// 	"estatus" => 1,
				// ]);
				// HistoricoNota::create([
				// 	"periodo" => "2020",
				// 	"nro_periodo" => 37,
				// 	"cedula_estudiante" => $estudiante,
				// 	"cod_desasignatura" => "S-60-01-AYG15",
				// 	"cod_asignatura" => "CBAAYG134",
				// 	"nombre_asignatura" => "ALGEBRA Y GEOMETRIA",
				// 	"nota" => 0,
				// 	"observacion" => "POR CERRAR",
				// 	"seccion" => "T1-MEC-CAI",
				// 	"especialidad" => 60,
				// 	"cedula_docente" => 0,
				// 	"docente" => "SIN ASIGNAR",
				// 	"tipo" => "NORMAL",
				// 	"estatus" => 1,
				// ]);
				// HistoricoNota::create([
				// 	"periodo" => "2020",
				// 	"nro_periodo" => 37,
				// 	"cedula_estudiante" => $estudiante,
				// 	"cod_desasignatura" => "S-60-01-PSI15",
				// 	"cod_asignatura" => "PSIPSI157",
				// 	"nombre_asignatura" => "PROYECTO SOCIO-INTEGRADOR I",
				// 	"nota" => 0,
				// 	"observacion" => "POR CERRAR",
				// 	"seccion" => "T1-MEC-CAI",
				// 	"especialidad" => 60,
				// 	"cedula_docente" => 0,
				// 	"docente" => "SIN ASIGNAR",
				// 	"tipo" => "PROYECTO",
				// 	"estatus" => 1,
				// ]);
				// HistoricoNota::create([
				// 	"periodo" => "2020",
				// 	"nro_periodo" => 37,
				// 	"cedula_estudiante" => $estudiante,
				// 	"cod_desasignatura" => "S-60-01-PNI15",
				// 	"cod_asignatura" => "FSCPNI123",
				// 	"nombre_asignatura" => "PROYECTO NACIONAL E INDEPENDENCIA ECONOMICA",
				// 	"nota" => 0,
				// 	"observacion" => "POR CERRAR",
				// 	"seccion" => "T1-MEC-CAI",
				// 	"especialidad" => 60,
				// 	"cedula_docente" => 0,
				// 	"docente" => "SIN ASIGNAR",
				// 	"tipo" => "NORMAL",
				// 	"estatus" => 1,
				// ]);

			}
			DB::commit();
			return back()->with('mensaje','Estudiantes agregados con exito.');
		} catch (\Throwable $th) {
			DB::rollback();
			return back()->with('error',$th->getMessage());
		}
	}
}
