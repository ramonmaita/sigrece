<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PreguntaSeguridad extends Model
{
    use HasFactory;

	protected $table = "preguntas_seguridad";

	protected $fillable = [
		"pregunta",
		"respuesta"
	];

	public function setRespuestaAttribute($value)
	{
    	$this->attributes['respuesta'] = Hash::make(strtolower(trim($value)));
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
