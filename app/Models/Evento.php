<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

	protected $fillable = ['periodo_id','evento_padre','nombre','descripcion','inicio','fin','tipo','aplicar','pnf' ];
}
