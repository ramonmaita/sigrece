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
        return $this->hasMany(HistoricoNota::class,'cedula_estudiante','cedula')->where('especialidad',$this->Pnf->codigo)->groupBy('periodo')->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC');
    }

	public function Historico()
    {
        return $this->hasMany(HistoricoNota::class,'cedula_estudiante','cedula')->where('especialidad',$this->Pnf->codigo)->OrderByRaw('nro_periodo ASC, cod_desasignatura ASC');
    }

	public function ultimo_periodo($cod_asignatura)
    {
        return collect(HistoricoNota::where('especialidad',$this->Pnf->codigo)->where('cedula_estudiante',$this->cedula)->where('cod_asignatura',$cod_asignatura)->OrderByRaw(' cod_desasignatura ASC, nro_periodo ASC')->where('estatus',0)->get())->last();
    }

	public function Notas($cod_asignatura , $nro_periodo)
	{
		return HistoricoNota::where('nro_periodo',$nro_periodo)->where('especialidad',$this->Pnf->codigo)->where('cedula_estudiante',$this->cedula)->where('cod_asignatura',$cod_asignatura)->OrderByRaw(' cod_desasignatura ASC, nro_periodo ASC')->where('estatus',0)->groupBy('cod_desasignatura')->get();
	}

}
