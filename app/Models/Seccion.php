<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use DB;

class Seccion extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nucleo_id','pnf_id','periodo_id','trayecto_id', 'plan_id','cupos','nombre','turno','observacion','estatus'];

    public function Plan()
    {
    	return $this->belongsTo(Plan::class);
    }

    public function Pnf()
    {
    	return $this->belongsTo(Pnf::class);
    }

    public function Nucleo()
    {
    	return $this->belongsTo(Nucleo::class);
    }

    public function Trayecto()
    {
    	return $this->belongsTo(Trayecto::class);
    }

    public function Periodo()
    {
    	return $this->belongsTo(Periodo::class);
    }

    public function Docentes()
    {
        return $this->belongsToMany(Docente::class,'desasignatura_docente_seccion')->withPivot('seccion_id','des_asignatura_id', 'docente_id','estatus')->withTimestamps();
    }

    public function DesAsignaturas()
    {
        // return DB::table('desasignatura_docente_seccion')->where('seccion_id',$this->id)->get();
        // return $thsi->has
        return $this->belongsToMany(DesAsignatura::class,'desasignatura_docente_seccion')->withPivot('id','seccion_id','des_asignatura_id', 'docente_id','estatus')->where('estatus','ACTIVO')->withTimestamps();
    }

    public function checkDesAsignaturas($value='')
    {
        if ($value == '') {
            return $this->DesAsignaturas->where('estatus','ACTIVO')->count();
        }else{
            return $this->DesAsignaturas->where('id',$value)->where('estatus','ACTIVO')->count();
        }
    }

    public function checkDocente($docente_id,$des_asignatura_id)
    {
        return DB::table('desasignatura_docente_seccion')->where('docente_id',$docente_id)->where('seccion_id',$this->id)->where('des_asignatura_id',$des_asignatura_id)->count();
        return $this->DesAsignaturas->first()->wherePivot('docente_id',0)->groupBy('docente_id');
        return $this->Docentes->where('id',$value)->count();
        if($this->Docentes->where('docente_id',$value)->groupBy('docente_id')->count() > 0){
            return true;
        }else{
            return false;
        }

        // if ($value == '') {
        //     return $this->Docentes->count();
        // }else{
        //     return $this->Docentes->where('id',$value)->count();
        // }

    }

    public function checkAsignatura($value='')
    {
        $desasignatura = $this->DesAsignaturas->where('asignatura_id',$value)->first();
        // $duc = dd($desasignatura->pivot->estatus);
        // return $duc;
        // return dd($desasignatura->Asignatura->DesAsignaturas->pluck('id'));
        // return dd($this->DesAsignaturas->where('asignatura_id',$value)->first());
        // return dd(DB::table('desasignatura_docente_seccion')->where('estatus','ACTIVO')->where('seccion_id',$this->id)->whereIn('des_asignatura_id',$this->DesAsignaturas->pluck('id')));
        // $this->DesAsignaturas->where('asignatura_id',$value)->groupBy('asignatura_id')->count() > 0 && DB::table('desasignatura_docente_seccion')->where('estatus','ACTIVO')->where('seccion_id',$this->id)->whereIn('des_asignatura_id',$duc )->count() > 0
        if( $desasignatura  &&  $desasignatura->pivot->estatus == 'ACTIVO'){
            return true;
        }else{
            return false;
        }
        // if ($value == '') {

        //     return $this->DesAsignaturas->count();
        // }else{
        // }
        // $seccion->DesAsignaturas->where('id',210)->first()->Asignatura
    }

	public function ConsultarDocente($docente_id,$des_asignatura_id)
    {
        return DesAsignaturaDocenteSeccion::where('docente_id',$docente_id)->where('seccion_id',$this->id)->where('des_asignatura_id',$des_asignatura_id)->first();

    }

	public function Docente($des_asignatura_id)
    {
        return DesAsignaturaDocenteSeccion::where('seccion_id',$this->id)->where('des_asignatura_id',$des_asignatura_id)->first();

    }
}
