<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graduando extends Model
{
	use HasFactory;

	protected $fillable = ['cedula', 'apellidos', 'nombres', 'nacionalidad', 'pnf', 'n_periodo', 'periodo', 'titulo', 'egreso', 'libro', 'nro_titulo', 'nro_acta', 'ira', 'ida', 'posicion', 'f_nacimiento', 'l_nacimiento', 'sexo'];

	public function numero_letras($numero)
	{

		switch ($numero) {
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

			case 21:
				return 'VEINTIUNO';
				break;
			case 22:
				return 'VEINTIDÓS';
				break;
			case 23:
				return 'VEINTITRÉS';
				break;
			case 24:
				return 'VEINTICUATRO';
				break;
			case 25:
				return 'VEINTICINCO';
				break;
			case 26:
				return 'VEINTISÉIS';
				break;
			case 27:
				return 'VEINTISIETE';
				break;
			case 28:
				return 'VEINTIOCHO';
				break;
			case 29:
				return 'VEINTINUEVE';
				break;
			case 30:
				return 'TREINTA';
				break;
			case 31:
				return 'TREINTA Y UNO';
				break;
			default:
				return 'CERO';
				break;
		}
	}

	public function Alumno()
	{
		return $this->belongsTo(Alumno::class, 'cedula', 'cedula');
	}
}
