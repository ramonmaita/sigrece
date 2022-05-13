<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCorreccion extends Model
{
    use HasFactory;

	protected $fillable = [
		'solicitante_id',
		'admin_id',
		'jefe_id',
		'desasignatura_id',
		'periodo',
		'seccion',
		'estatus_jefe',
		'estatus_admin',
		'motivo',
		'observacion',
		'observacion_admin',
		'fecha',
	];

	public function Solicitante()
	{
		return $this->hasOne(User::class,'id','solicitante_id');
	}
	public function Jefe()
	{
		return $this->hasOne(User::class,'id','jefe_id');
	}
	public function DesAsignatura()
	{
		return $this->belongsTo(DesAsignatura::class,'desasignatura_id','id');
	}
	public function Detalles()
	{
		return $this->hasMany(SolicitudCorreccionDetalle::class);
	}
}
