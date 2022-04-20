<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable =[
    	'trayecto_id', 'pnf_id', 'plan_id', 'codigo', 'nombre', 'credito', 'aprueba', 'observacion'
    ];

    public function Plan()
    {
    	return $this->belongsTo(Plan::class);
    }

	public function Pnf()
    {
    	return $this->belongsTo(Pnf::class);
    }

    public function DesAsignaturas()
    {
    	return $this->hasMany(DesAsignatura::class);
    }

    public function Trayecto()
    {
        return $this->belongsTo(Trayecto::class);
    }

	public function RelacionSeccionDocente()
	{
		return DesAsignaturaDocenteSeccion::whereIn('des_asignatura_id', $this->DesAsignaturas->pluck('id'))->groupBy('seccion_id')->get();
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
}
