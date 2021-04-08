<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CargaNota extends Model implements Auditable
{
    use HasFactory;
	use \OwenIt\Auditing\Auditable;

	protected $fillable = ['fecha','periodo','seccion','cedula_docente','docente','cod_desasignatura','user_id'];


	public function User()
	{
		return $this->belongsTo(User::class);
	}
}
