<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pregunta;

class PreguntasController extends Controller
{
    public function index()
	{
		$preguntas = Pregunta::all();
		return view('layouts.faqs.index', ["faqs" => $preguntas]);
	}

	public function create(Pregunta $faq)
	{
		return view('layouts.faqs.create', ['faq' => $faq]);
	}

	public function store(Request $request)
    {
		$request->validate([
            'pregunta' => 'required',
            'respuesta' => 'required',
        ]);

        $faq = Pregunta::create([
            "pregunta" => $request->pregunta,
            "respuesta" => $request->respuesta,
        ]);

        return redirect()->route('preguntas-frecuentes')->with('jet_mensaje','Pregunta agregada con exito');
    }

	public function edit(Pregunta $faq)
	{
		return view('layouts.faqs.edit', ['faq' => $faq]);
	}

	public function update(Request $request, Pregunta $faq)
	{
		$request->validate([
            'pregunta' => 'required',
            'respuesta' => 'required',
        ]);

        $faq->update([
            "pregunta" => $request->pregunta,
            "respuesta" => $request->respuesta,
        ]);

        return redirect()->route('preguntas-frecuentes')->with('jet_mensaje','Pregunta actualizada con exito');
	}

	public function destroy(Pregunta $faq)
    {
        $faq->delete();

        return back();
    }
}