<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Pnf extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['codigo','nombre','acronimo', 'observacion'];

    public function Nucleos()
    {
    	return $this->belongsToMany(Nucleo::class)->withTimestamps();
    }

    public function Planes()
    {
    	return $this->hasMany(Plan::class);
    }

	public function Secciones()
	{
		return $this->hasMany(Seccion::class);
	}
}
