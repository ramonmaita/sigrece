<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InformacionContacto extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

	protected $fillable = [
		'alumno_id',
		'estado_id',
		'municipio_id',
		'parroquia_id',
		'direccion',
		'telefono',
		'facebook',
		'instagram',
		'twitter',
		'correo',
		'correo_alternativo',
	];

	public function Estado()
	{
		return $this->belongsTo(Estado::class);
	}
	public function Municipio()
	{
		return $this->belongsTo(Municipio::class);
	}
	public function Parroquia()
	{
		return $this->belongsTo(Parroquia::class);
	}
}
