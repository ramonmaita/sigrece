<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InformacionComplementaria extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

	protected $fillable = [
		'alumno_id',
		'carnet_patria',
		'pertenece_etnia',
		'etnia',
		'madre',
		'tlf_madre',
		'padre',
		'tlf_padre',
		'equipos',
		'internet',
		'ingreso',
	];
}
