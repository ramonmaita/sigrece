@csrf

<label for="" class="uppercase text-gray-700 text-xs">
    Pregunta
</label>
<label class="text-xs text-red-600">
    @error('pregunta')
    {{ $message }}
    @enderror
</label>
<input type="text" name="pregunta" class="rounded border-gray-200 w-full mb-4" value="{{ old('pregunta', $faq->pregunta) }}">

<label class="uppercase text-gray-700 text-xs">
    Respuesta
</label>
<label class="text-xs text-red-600">
    @error('respuesta')
    {{ $message }}
    @enderror
</label>
<textarea name="respuesta" rows="5" class="rounded border-gray-200 w-full mb-4">
    {{ old('respuesta', $faq->respuesta) }}
</textarea>

<div class="flex justify-between items-center">
    <a href="{{ route('preguntas-frecuentes') }}" class="text-indigo-600">Volver</a>
    <input type="submit" value="Enviar" class="bg-gray-800 text-white rounded px-4 py-2">
</div>
