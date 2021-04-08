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

	public function FunctionName()
	{
		return $this->hasMany(DesAsignaturaDocenteSeccion::class,'id','des_asignatura_id');
	}

}
