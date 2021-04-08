<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class PnfsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pnfs = array(
			array(
				"id" => 1,
				"codigo" => 40,
				"nombre" => "ELECTRICIDAD",
				"acronimo" => "P.N.F.E",
				"observacion" => "PROGRAMA NACIONAL DE FORMACION EN ELECTRICIDAD",
			),
			array(
				"id" => 2,
				"codigo" => 45,
				"nombre" => "GEOCIENCIAS",
				"acronimo" => "P.N.F.G",
				"observacion" => "PROGRAMA NACIONAL DE FORMACION EN GEOCIENCIAS",
			),
			array(
				"id" => 3,
				"codigo" => 50,
				"nombre" => "INFORMATICA",
				"acronimo" => "P.N.F.I",
				"observacion" => "PROGRAMA NACIONAL DE FORMACION EN INFORMATICA",
			),
			array(
				"id" => 4,
				"codigo" => 55,
				"nombre" => "MANTENIMIENTO",
				"acronimo" => "P.N.F.MTTO",
				"observacion" => "PROGRAMA NACIONAL DE FORMACION EN MANTENIMIENTO",
			),
			array(
				"id" => 5,
				"codigo" => 60,
				"nombre" => "MECANICA",
				"acronimo" => "P.N.F.MEC",
				"observacion" => "PROGRAMA NACIONAL DE FORMACION EN MECANICA",
			),
			array(
				"id" => 6,
				"codigo" => 65,
				"nombre" => "SISTEMAS DE CALIDAD Y AMBIENTE",
				"acronimo" => "P.N.F.SCYA",
				"observacion" => "PROGRAMA NACIONAL DE FORMACION EN SISTEMA DE CALIDAD Y AMBIENTE",
			),
			array(
				"id" => 7,
				"codigo" => 70,
				"nombre" => "ORFEBRERIA Y JOYERIA",
				"acronimo" => "P.N.F.OYJ",
				"observacion" => "PROGRAMA NACIONAL DE FORMACION EN ORFREBERIA Y JOYERIA",
			),
			array(
				"id" => 8,
				"codigo" => 20,
				"nombre" => "ELECTRICIDAD",
				"acronimo" => "ELEC",
				"observacion" => "IUTEB CARRERA",
			),
			array(
				"id" => 9,
				"codigo" => 25,
				"nombre" => "GEOLOGÍA Y MINAS",
				"acronimo" => "GYM",
				"observacion" => "IUTEB CARRERA",
			),
			array(
				"id" => 10,
				"codigo" => 30,
				"nombre" => "MECÁNICA",
				"acronimo" => "MEC",
				"observacion" => "IUTEB CARRERA",
			),
			array(
				"id" => 11,
				"codigo" => 30,
				"nombre" => "SISTEMAS INDUSTRIALES",
				"acronimo" => "SI",
				"observacion" => "IUTEB CARRERA",
			),
			array(
				"id" => 12,
				"codigo" => 75,
				"nombre" => "INGENIERÍA EN MATERIALES INDUSTRIALES",
				"acronimo" => "P.N.F. IMI",
				"observacion" => "PROGRAMA NACIONAL DE FORMACION EN INGENIERÍA EN MATERIALES INDUSTRIALES",
			),
			array(
				"id" => 13,
				"codigo" => 80,
				"nombre" => "HIGIENE Y SEGURIDAD LABORAL",
				"acronimo" => "P.N.F.HSL",
				"observacion" => "PROGRAMA NACIONAL DE FORMACION EN HIGIENE Y SEGURIDAD LABORAL",
			),
		);

		// Pnf::create($pnfs);
		DB::table('pnfs')->insert($pnfs);
    }
}
