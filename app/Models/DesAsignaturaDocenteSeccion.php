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
}
