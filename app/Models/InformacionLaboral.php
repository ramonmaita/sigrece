<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InformacionLaboral extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

	protected $fillable = [
		'alumno_id',
		'trabaja',
		'direccion',
		'telefono',
	];
}
