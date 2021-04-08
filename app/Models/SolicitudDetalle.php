<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SolicitudDetalle extends Model implements Auditable
{
    use HasFactory;
 	use \OwenIt\Auditing\Auditable;

    protected $fillable = ['solicitud_id','alumno_id','admin_id', 'nota_e', 'nota','estatus','observacion'];

	public function Alumno()
	{
		return $this->belongsTo(Alumno::class);
	}


}
