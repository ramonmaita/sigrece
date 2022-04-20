<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesAsignatura extends Model
{
    use HasFactory;

    protected $fillable = [
    	'asignatura_id',
        'codigo',
        'nombre',
        'tri_semetre',
        'observacion'
    ];

    public function Asignatura()
    {
    	return $this->belongsTo(Asignatura::class);
    }

	public function RelacionDocente()
	{
		return $this->hasOne(DesAsignaturaDocenteSeccion::class,'des_asignatura_id','id');
	}

	public function estatus_carga($seccion,$periodo)
	{
		return CargaNota::where('seccion',$seccion)->where('periodo',$periodo)->where('cod_desasignatura',$this->codigo)->first();
	}

}
