<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActualizacionDato extends Model
{
    use HasFactory;

	protected $fillable = ['alumno_id','estatus'];

	public function Alumno()
	{
		return $this->belongsTo(Alumno::class);
	}
}
