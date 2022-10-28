<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    }

    public function store(Request $request)
    {

		$request->validate([
            'tipo' => 'required',
        ]);

		$alumno = Alumno::find($request->alumno_id);

        $beca = new Beca;
		$beca->tipo = $request->tipo;

		$alumno->beca()->save($beca);

        return redirect()->route('panel.estudiantes.becas');
    }

    public function show($id)
    {
        return Alumno::find($id)->beca;
    }

    public function edit($id)
    {
		$beca = Beca::find($id);
        return view('panel.admin.becas.edit', ["beca" => $beca]);
    }

    public function update(Request $request, Beca $beca)
    {
		$beca->update([
			"tipo" => $request->tipo
		]);
		return view('panel.admin.becas.index');
    }

    public function destroy($id)
    {
        //
    }
}
