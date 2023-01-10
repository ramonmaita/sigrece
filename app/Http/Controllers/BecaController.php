<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Beca;
use App\Models\Alumno;

class BecaController extends Controller
{
    public function index()
    {
		return view('panel.admin.becas.index');
    }

    public function create()
    {
		return view('panel.admin.becas.create');
    }

    public function store(Request $request)
    {

		try {
			$alumno = Alumno::where('cedula', $request->cedula)->first();

			$validator = Validator::make($request->all(), [
				'cedula' => [
					'required',
					Rule::exists('alumnos')
						->where('cedula', $request->cedula)
				],
				'tipo' => [
					'required',
					Rule::unique('becas')->where(function ($query) use ($alumno){
						return $query->where('alumno_id', @$alumno->id);
					})
				],
			]);

			if($validator->fails()) {
				return back()->withErrors($validator);
			}


			$beca = new Beca;
			$beca->tipo = $request->tipo;

			$alumno->beca()->save($beca);


			return redirect()->route('panel.estudiantes.becas.index')->with('jet_mensaje', 'Beca asignada con exito');

		} catch (\Throwable $th) {
			return redirect()->route('panel.estudiantes.becas.create')->with('error', $th->getMessage());
		}
    }

    public function edit($id)
    {
		$beca = Beca::find($id);
        return view('panel.admin.becas.edit', ["beca" => $beca]);
    }

    public function update(Request $request, Beca $beca)
    {
		try {
			$beca->update([
				"tipo" => $request->tipo
			]);
			return redirect()->route('panel.estudiantes.becas.index')->with('jet_mensaje', 'Beca actualizada con exito');
		} catch (\Throwable $th) {
			return redirect()->route('panel.estudiantes.becas.index')->with('error', $th->getMessage());
		}
    }

    public function destroy($id)
    {
        $beca = Beca::find($id);
		$beca->delete();

		return view('panel.admin.becas.index');
    }
}
