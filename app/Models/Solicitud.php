<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Solicitud extends Model implements Auditable
{
    use HasFactory;
 	use \OwenIt\Auditing\Auditable;

    protected $fillable = ['solicitante_id','admin_id','desasignatura_id', 'periodo','seccion','tipo', 'estatus','motivo','observacion','fecha'];

	public function Detalles()
	{
		return $this->hasMany(SolicitudDetalle::class);
	}

	public function Solicitante()
	{
		return $this->hasOne(User::class,'id','solicitante_id');
	}

	public function DesAsignatura()
	{
		return $this->belongsTo(DesAsignatura::class,'desasignatura_id','id');
	}
}
