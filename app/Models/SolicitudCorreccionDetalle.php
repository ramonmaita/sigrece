<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCorreccionDetalle extends Model
{
    use HasFactory;

	protected $fillable = [
		'solicitud_correccion_id',
		'alumno_id',
		'actividad_id',
		'nota_anterior',
		'nota_nueva',
		'estatus_jefe',
		'estatus_admin',
	];
	public function Alumno()
	{
		return $this->belongsTo(Alumno::class);
	}
}
