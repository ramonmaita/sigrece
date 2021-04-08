<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Inscrito extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

	protected $fillable = ['periodo_id','alumno_id','fecha'];

	public function Inscripcion()
	{
		return $this->hasMany(Inscripcion::class);
	}
}
