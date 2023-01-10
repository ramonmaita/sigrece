<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignado extends Model
{
    use HasFactory;


	public function Pnf()
	{
		return $this->belongsTo(Pnf::class);
	}

	public function Alumno()
	{
		return $this->hasOne(Alumno::class,'cedula','cedula');
	}

	public function Inscrito()
	{
		$alumno = Alumno::find($this->id);
		return $alumno->InscritoActual;
	}
}
