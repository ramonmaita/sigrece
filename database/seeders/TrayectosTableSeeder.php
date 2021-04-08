<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class TrayectosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trayectos = array(
			array(
				"id" => 1,
				"nombre" => "I",
				"observacion" => "TRAYECTO UNO",
			),
			array(
				"id" => 2,
				"nombre" => "II",
				"observacion" => "TRAYECTO DOS",
			),
			array(
				"id" => 3,
				"nombre" => "III",
				"observacion" => "TRAYECTO TRES",
			),
			array(
				"id" => 4,
				"nombre" => "IV",
				"observacion" => "TRAYECTO CUATRO",
			),
			array(
				"id" => 5,
				"nombre" => "V",
				"observacion" => "TRAYECTO CINCO",
			),
			array(
				"id" => 7,
				"nombre" => "N",
				"observacion" => "NIVELACION",
			),
			array(
				"id" => 8,
				"nombre" => "INICIAL",
				"observacion" => "TRAYECTO INICIAL",
			),
		);
        DB::table('trayectos')->insert($trayectos);
    }
}
