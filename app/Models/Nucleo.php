<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Nucleo extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nucleo','locacion','estatus'];

    public function Pnfs()
    {
    	return $this->belongsToMany(Pnf::class)->withTimestamps();
    }

    public function Secciones()
    {
    	return $this->hasMany(Seccion::class);
    }
}
