<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable =[
    	'trayecto_id', 'pnf_id', 'plan_id', 'codigo', 'nombre', 'credito', 'aprueba', 'observacion'
    ];

    public function Plan()
    {
    	return $this->belongsTo(Plan::class);
    }

	public function Pnf()
    {
    	return $this->belongsTo(Pnf::class);
    }

    public function DesAsignaturas()
    {
    	return $this->hasMany(DesAsignatura::class);
    }

    public function Trayecto()
    {
        return $this->belongsTo(Trayecto::class);
    }

	public function RelacionSeccionDocente()
	{
		return DesAsignaturaDocenteSeccion::whereIn('des_asignatura_id', $this->DesAsignaturas->pluck('id'))->groupBy('seccion_id')->get();
	}
}
