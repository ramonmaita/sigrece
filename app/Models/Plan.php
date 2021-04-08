<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Plan extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['pnf_id', 'codigo','nombre', 'observacion'];


    public function Pnf()
    {
    	return $this->belongsTo(Pnf::class);
    }

    public function Asignaturas()
    {
    	return $this->hasMany(Asignatura::class);
    }

	public function getCohorteAttribute()
	{
		switch ($this->observacion) {
			case 'ANUAL':
				return 'AÑO';
				break;
			case 'SEMESTRAL':
				return 'SEMESTRE';
				break;
			case 'TRIMESTRAL':
				return 'TRIMESTRE';
					break;
			default:
				return $this->observacion;
				break;
		}
	}
}
