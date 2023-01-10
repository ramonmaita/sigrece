<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;


	protected $fillable = ['desasignatura_docente_seccion_id', 'actividad','descripcion','porcentaje','fecha','seccion_id','desasignatura_id'];

	public function Notas()
	{
		return $this->hasMany(ActividadNota::class);
	}

	public function Nota($alumno_id)
	{
		// return ActividadNota::where()
		return $this->hasMany(ActividadNota::class)->where('actividad_id',$this->id)->where('alumno_id',$alumno_id)->first();
	}

	public function Relacion()
	{
		// return $this->hasOneThrough(Inscripcion::class, Inscrito::class,
		// 'inscripcion_id', // Foreign key on the owners table...
		// 	'desasignatura_docente_seccion_id', // Foreign key on the cars table...
		// 	'id', // Local key on the mechanics table...
		// 	'id' // Local key on the cars table...
		// );
		return $this->belongsTo(DesAsignaturaDocenteSeccion::class,'desasignatura_docente_seccion_id','id');
	}
}
