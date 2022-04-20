<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadNota extends Model
{
    use HasFactory;

	protected $fillable = ['actividad_id','alumno_id','nota','estatus'];
}
