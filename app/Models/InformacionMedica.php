<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InformacionMedica extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

	protected $fillable = [
		'alumno_id',
		'posee_discapacidad',
		'discapacidad',
		'posee_enfermedad',
		'enfermedad',
		'llamar_emergencia',
	];
}
