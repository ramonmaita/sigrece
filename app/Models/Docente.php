<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Docente extends Model implements Auditable
{
    use HasFactory;
 	use \OwenIt\Auditing\Auditable;

    protected $fillable = ['cedula','nombres','apellidos', 'nacionalidad','sexo','fechan', 'estatus'];

    public function Secciones()
    {
        return $this->belongsToMany(Seccion::class,'desasignatura_docente_seccion','des_asignatura_id','seccion_id','docente_id')->withTimestamps();
    }

	public function getNombreCompletoAttribute()
	{
	    return $this->nombres . ' ' . $this->apellidos;
	}

	public function User()
	{
		return $this->hasOne(User::class, 'cedula', 'cedula');
	}
}
