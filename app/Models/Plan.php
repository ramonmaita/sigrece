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

	public function uc_plan($titulo)
    {
        if ($titulo == 3) {
            if ($this->Pnf->id == 1 && $this->id == 5 || $this->Pnf->id == 5 && $this->id == 21) {
                return $asignaturas = Asignatura::whereIn('trayecto_id',[4,5])->where('plan_id', $this->id)->where('pnf_id', $this->Pnf->id)->sum('credito');
            }        }
        if ($titulo == 1) {
            if ($this->Pnf->id == 1 && $this->id == 5 || $this->Pnf->id == 5 && $this->id == 21) {
                return $asignaturas = Asignatura::whereIn('trayecto_id',[7,8,1,2,3])->where('plan_id', $this->id)->where('pnf_id', $this->Pnf->id)->sum('credito');
            }else{
                return $asignaturas = Asignatura::whereIn('trayecto_id',[8,1,2])->where('plan_id', $this->id)->where('pnf_id', $this->Pnf->id)->sum('credito');
            }
        }
        return $asignaturas = Asignatura::where('plan_id', $this->id)->where('pnf_id', $this->Pnf->id)->sum('credito');
    }
}
