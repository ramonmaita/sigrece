<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Inscripcion extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

	protected $fillable = ['desasignatura_docente_seccion_id','inscrito_id','alumno_id'];

	public function RelacionDocenteSeccion()
	{
		return $this->hasOne(DesAsignaturaDocenteSeccion::class,'id','desasignatura_docente_seccion_id');
	}
}
