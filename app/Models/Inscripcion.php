<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class Inscripcion extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
	use SoftDeletes; //Implementamos

	protected $fillable = ['desasignatura_docente_seccion_id','inscrito_id','alumno_id'];

	protected $dates = ['deleted_at']; //Registramos la nueva columna

	public function generateTags(): array
    {
        return [

            $this->Alumno->nombres,
            $this->Alumno->apellidos,
        ];
    }

	public function RelacionDocenteSeccion()
	{
		return $this->hasOne(DesAsignaturaDocenteSeccion::class,'id','desasignatura_docente_seccion_id');
	}

	public function Alumno()
	{
		return $this->belongsTo(Alumno::class);
	}
}
