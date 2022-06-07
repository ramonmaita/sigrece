<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\DesAsignatura;
use App\Models\Asignatura;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricoNota extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

    protected $fillable = [
       	'periodo',
       	'nro_periodo',
       	'cedula_estudiante',
        'cod_desasignatura',
        'cod_asignatura',
        'nombre_asignatura',
       	'nota',
        'observacion',
        'seccion',
       	'especialidad',
       	'cedula_docente',
        'docente',
        'tipo',
       	'estatus',
    ];
	protected $dates = ['deleted_at']; //Registramos la nueva columna

    public function DesAsignatura()
    {
      return $this->belongsTo(DesAsignatura::class,'cod_desasignatura','codigo');
    }

	public function Asignatura()
    {
      return $this->belongsTo(Asignatura::class,'cod_asignatura','codigo');
    }

	public function AsignaturaYPIU()
    {
		switch ($this->Alumno->pnf_id) {
			case 1:
				$plan_piu = 27;
				break;
			case 2:
				$plan_piu = 28;
				break;
			case 3:
				$plan_piu = 29;
				break;
			case 4:
				$plan_piu = 30;
				break;
			case 5:
				$plan_piu = 31;
				break;
			case 6:
				$plan_piu = 32;
				break;
			case 7:
				$plan_piu = 33;
				break;
			case 12:
				$plan_piu = 34;
				break;
			case 13:
				$plan_piu = 35;
				break;
			case 14:
				$plan_piu = 36;
				break;
			case 15:
				$plan_piu = 37;
				break;
			case 16:
				$plan_piu = 38;
				break;

			default:
				# code...
				break;
		}
		$plan =	($this->Alumno->PIU->count() > 0) ?[$this->Alumno->plan_id,$plan_piu] : [$this->Alumno->plan_id] ;
      	return $this->belongsTo(Asignatura::class,'cod_asignatura','codigo')->whereIn('plan_id',$plan);
    }

    public function Alumno()
    {
    	return $this->belongsTo(Alumno::class,'cedula_estudiante','cedula');
    }

	public function Docente()
	{
		return $this->belongsTo(Docente::class,'cedula_docente','cedula');
	}

	public function estatus_carga($seccion,$periodo,$cod_desasignatura)
	{
		return CargaNota::where('seccion',$seccion)->where('periodo',$periodo)->where('cod_desasignatura',$cod_desasignatura)->first();
	}

	public function letras($nota)
    {
        switch ($nota) {
            case 1:
                return 'UNO';
                break;
            case 2:
                return 'DOS';
                break;
            case 3:
                return 'TRES';
                break;
            case 4:
                return 'CUATRO';
                break;
            case 5:
                return 'CINCO';
                break;
            case 6:
                return 'SEIS';
                break;
            case 7:
                return 'SIETE';
                break;
            case 8:
                return 'OCHO';
                break;
            case 9:
                return 'NUEVE';
                break;
            case 10:
                return 'DIEZ';
                break;
            case 11:
                return 'ONCE';
                break;
            case 12:
                return 'DOCE';
                break;
            case 13:
                return 'TRECE';
                break;
            case 14:
                return 'CATORCE';
                break;
            case 15:
                return 'QUINCE';
                break;
            case 16:
                return 'DIECISÉIS';
                break;
            case 17:
                return 'DIECISIETE';
                break;
            case 18:
                return 'DIECIOCHO';
                break;
            case 19:
                return 'DIECINUEVE';
                break;
            case 20:
                return 'VEINTE';
                break;

            default:
                return 'CERO';
                break;
        }
    }

	public function nota_trimestre()
    {
        return HistoricoNota::where('cedula_estudiante',$this->cedula_estudiante)->where('cod_asignatura',$this->cod_asignatura)->OrderByRaw(' cod_desasignatura ASC, nro_periodo ASC')->where('estatus',0)->groupBy('cod_desasignatura')->get();
    }
}
