<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Solicitud extends Model implements Auditable
{
    use HasFactory;
 	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

    protected $fillable = ['solicitante_id','admin_id','jefe_id','desasignatura_id', 'periodo','seccion','tipo', 'estatus','motivo','observacion','fecha'];
	protected $dates = ['deleted_at']; //Registramos la nueva columna

	public function Detalles()
	{
		return $this->hasMany(SolicitudDetalle::class);
	}

	public function DetalleRetiro()
	{
		return $this->hasOne(SolicitudDetalle::class);
	}

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
}
