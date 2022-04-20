<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    use HasFactory;

	protected $fillable = ['user_id','pnf_id'];


	public function Pnf()
	{
		return $this->belongsTo(Pnf::class);
	}
}
