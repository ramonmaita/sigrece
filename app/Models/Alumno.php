<?php

namespace App\Models;

use App\Http\Livewire\Admin\Per;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\HistoricoNota;
class Alumno extends Model
{
    use HasFactory;
	use SoftDeletes;

	protected $fillable =[
		'cedula','p_nombre','s_nombre','p_apellido','s_apellido','sexo','escivil','nacionalidad','fechan','lugarn','pnf_id','plan_id','nucleo_id','tipo','imagen'
	];

    public function getNombresAttribute()
	{
	    return $this->p_nombre . ' ' . $this->s_nombre;
	}

	public function getApellidosAttribute()
	{
	    return $this->p_apellido . ' ' . $this->s_apellido;
	}

	public function InfoContacto()
	{
		return $this->hasOne(InformacionContacto::class);
	}
	public function InfoMedica()
	{
		return $this->hasOne(InformacionMedica::class);
	}
	public function InfoLaboral()
	{
		return $this->hasOne(InformacionLaboral::class);
	}
	public function InfoComplementaria()
	{
		return $this->hasOne(InformacionComplementaria::class);
	}
	public function ActualizacionDatos()
	{
		return $this->hasOne(ActualizacionDato::class);
	}

	public function Nucleo()
	{
		return $this->belongsTo(Nucleo::class,'nucleo_id','id');
	}

	public function NotaUc($cedula_docente,$periodo,$seccion,$cod_desasignatura)
	{
		// return $this->cedula;
		// return HistoricoNota::find(5454);
		return $hn = HistoricoNota::where('cedula_estudiante',$this->cedula)
							->where('cedula_docente',$cedula_docente)
							->where('periodo',"$periodo")
							->where('cod_desasignatura',$cod_desasignatura)
							->where('seccion',$seccion)
							// ->groupBy('cedula_estudiante')
							// ->orderBy('cedula_estudiante','asc')
							->first();
	}

	public function Pnf()
	{
		return $this->belongsTo(Pnf::class);
	}

	public function Plan()
	{
		return $this->belongsTo(Plan::class);
	}

	public function Inscrito()
	{
		return $this->hasMany(Inscrito::class);
	}

	public function InscritoActual()
	{
		$periodo = Periodo::where('estatus',0)->first();
		return $this->hasMany(Inscrito::class)->where('periodo_id',$periodo->id)->first();
	}

	public function Inscripcion()
	{
		return $this->hasMany(Inscripcion::class)->with('RelacionDocenteSeccion');
	}

	public function Usuario()
	{
		return $this->hasOne(User::class,'cedula','cedula');
	}

	// TODO: QUITAR SI NO VOY A USAR
	public function Periodos()
    {
        // return $this->hasMany(HistoricoNota::class,'cedula_estudiante','cedula')->where('especialidad',$this->Pnf->codigo)->groupBy('periodo')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC');
        return $this->hasMany(HistoricoNota::class,'cedula_estudiante','cedula')->groupBy('periodo')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC');
    }

	public function Historico()
    {
        return $this->hasMany(HistoricoNota::class,'cedula_estudiante','cedula')->where('especialidad',$this->Pnf->codigo)->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC');
    }
	public function TimeLine()
    {
        return $this->hasMany(HistoricoNota::class,'cedula_estudiante','cedula')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC');
    }

	public function ultimo_periodo($cod_asignatura)
    {
        return collect(HistoricoNota::where('especialidad',$this->Pnf->codigo)->where('cedula_estudiante',$this->cedula)->where('cod_asignatura',$cod_asignatura)->OrderByRaw(' cod_desasignatura ASC, nro_periodo ASC')->where('estatus',0)->get())->last();
    }

	public function Notas($cod_asignatura , $nro_periodo)
	{
		return HistoricoNota::where('nro_periodo',$nro_periodo)->where('especialidad',$this->Pnf->codigo)->where('cedula_estudiante',$this->cedula)->where('cod_asignatura',$cod_asignatura)->OrderByRaw(' cod_desasignatura ASC, nro_periodo ASC')->where('estatus',0)->groupBy('cod_desasignatura')->get();
	}

	public function NotasPIU($cod_asignatura , $nro_periodo)
	{
		return HistoricoNota::where('nro_periodo',$nro_periodo)->where('cedula_estudiante',$this->cedula)->where('cod_asignatura',$cod_asignatura)->OrderByRaw(' cod_desasignatura ASC, nro_periodo ASC')->where('estatus',0)->groupBy('cod_desasignatura')->get();
	}

	public function ultimo_periodoPIU($cod_asignatura)
    {
        return collect(HistoricoNota::where('cedula_estudiante',$this->cedula)->where('cod_asignatura',$cod_asignatura)->OrderByRaw(' cod_desasignatura ASC, nro_periodo ASC')->where('estatus',0)->get())->last();
    }

	public function CheckPeriodo($periodo)
	{
		$periodo = Periodo::find($periodo);
		return $this->hasMany(Inscrito::class)->where('periodo_id',$periodo->id)->first();
	}

	public function NotasTrayecto($cod_asignaturas)
	{
		return HistoricoNota::where('especialidad',$this->Pnf->codigo)->where('cedula_estudiante',$this->cedula)->whereIn('cod_asignatura',$cod_asignaturas)->OrderByRaw(' cod_desasignatura ASC, nro_periodo ASC')->where('estatus',0)->groupBy('cod_desasignatura')->get();
	}

	public function IngresoActual()
	{
		$periodo = Periodo::where('estatus',0)->first();
		return $this->hasMany(Ingreso::class)->where('periodo_id',$periodo->id)->first();
	}

	public function NotasActividades($actividades)
	{
		return ActividadNota::whereIn('actividad_id',$actividades)->where('alumno_id',$this->id)->sum('nota');
	}

	public function PIU()
    {
		$cod_asignaturas = ['PB000','BA000','VPP000','ID000','RP000'];
        return $this->hasMany(HistoricoNota::class,'cedula_estudiante','cedula')->whereIn('cod_asignatura',$cod_asignaturas)->groupBy('cod_asignatura')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC');
    }

	public function Escala($nota)
	{
		if($nota <= 5.99) { return "01"; }
		if($nota >= 6 && $nota <= 10.99) { return "02"; }
		if($nota >= 11 && $nota <= 15.99) { return "03"; }
		if($nota >= 16 && $nota <= 20.99) { return "04"; }
		if($nota >= 21 && $nota <= 25.99) { return "05"; }
		if($nota >= 26 && $nota <= 30.99) { return "06"; }
		if($nota >= 31 && $nota <= 35.99) { return "07"; }
		if($nota >= 36 && $nota <= 40.99) { return "08"; }
		if($nota >= 41 && $nota <= 45.99) { return "09"; }
		if($nota >= 46 && $nota <= 50.99) { return "10"; }
		if($nota >= 51 && $nota <= 55.99) { return "11"; }
		if($nota >= 56 && $nota <= 60.99) { return "12"; }
		if($nota >= 61 && $nota <= 65.99) { return "13"; }
		if($nota >= 66 && $nota <= 70.99) { return "14"; }
		if($nota >= 71 && $nota <= 75.99) { return "15"; }
		if($nota >= 76 && $nota <= 80.99) { return "16"; }
		if($nota >= 81 && $nota <= 85.99) { return "17"; }
		if($nota >= 86 && $nota <= 90.99) { return "18"; }
		if($nota >= 91 && $nota <= 95.99) { return "19"; }
		if($nota >= 96 && $nota <= 100) { return "20"; }
	}

}
