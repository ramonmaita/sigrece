<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class DesAsignaturaDocenteSeccion extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'desasignatura_docente_seccion';

	public function Seccion()
	{
		return $this->hasOne(Seccion::class,'id','seccion_id');
	}

	public function DesAsignatura()
	{
		return $this->belongsTo(DesAsignatura::class,'des_asignatura_id','id');
	}

	public function Inscritos()
	{
		// return $this->hasOneThrough(Inscripcion::class, Inscrito::class,
		// 'inscripcion_id', // Foreign key on the owners table...
		// 	'desasignatura_docente_seccion_id', // Foreign key on the cars table...
		// 	'id', // Local key on the mechanics table...
		// 	'id' // Local key on the cars table...
		// );
		return $this->hasMany(Inscripcion::class,'desasignatura_docente_seccion_id','id')->groupBy('alumno_id');
	}
	public function Docente()
	{
		return $this->belongsTo(Docente::class);
	}


	public function Actividades()
	{
		return $this->hasMany(Actividad::class,'desasignatura_docente_seccion_id','id');
	}


	public function NotasActividades()
	{
		return ActividadNota::whereIn('actividad_id',$this->Actividades->pluck('id'))->get();
	}
}
