<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class Inscrito extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
	use SoftDeletes; //Implementamos

	protected $fillable = ['periodo_id','alumno_id','fecha'];

	public function Inscripcion()
	{
		return $this->hasMany(Inscripcion::class)->orderBy('desasignatura_docente_seccion_id');
	}

	public function Alumno()
	{
		return $this->belongsTo(Alumno::class);
	}
}
