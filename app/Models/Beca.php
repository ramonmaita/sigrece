<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Alumno;

class Beca extends Model
{
    use HasFactory;
	use SoftDeletes;

	protected $fillable = ['tipo','alumno_id'];

	public function alumno()
	{
		return $this->belongsTo(Alumno::class);
	}
}
