<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use DB;
class PlanesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planes = array(
			array(
				"id" => 1,
				"pnf_id" => 1,
				"codigo" => 9,
				"nombre" => "MALLA 2009",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 2,
				"pnf_id" => 1,
				"codigo" => 13,
				"nombre" => "MALLA 2013",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 3,
				"pnf_id" => 1,
				"codigo" => 14,
				"nombre" => "MALLA 2014",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 4,
				"pnf_id" => 1,
				"codigo" => 15,
				"nombre" => "MALLA 2015",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 5,
				"pnf_id" => 1,
				"codigo" => 16,
				"nombre" => "MALLA 2016",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 6,
				"pnf_id" => 2,
				"codigo" => 10,
				"nombre" => "MALLA 2010",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 7,
				"pnf_id" => 2,
				"codigo" => 13,
				"nombre" => "MALLA 2013",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 8,
				"pnf_id" => 2,
				"codigo" => 14,
				"nombre" => "MALLA 2014",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 9,
				"pnf_id" => 2,
				"codigo" => 15,
				"nombre" => "MALLA 2015",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 10,
				"pnf_id" => 2,
				"codigo" => 16,
				"nombre" => "MALLA 2016",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 11,
				"pnf_id" => 2,
				"codigo" => 17,
				"nombre" => "MALLA 2017",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 12,
				"pnf_id" => 3,
				"codigo" => 9,
				"nombre" => "MALLA 2009",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 13,
				"pnf_id" => 3,
				"codigo" => 13,
				"nombre" => "MALLA 2013",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 14,
				"pnf_id" => 3,
				"codigo" => 14,
				"nombre" => "MALLA 2014",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 15,
				"pnf_id" => 4,
				"codigo" => 9,
				"nombre" => "MALLA 2009",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 16,
				"pnf_id" => 4,
				"codigo" => 13,
				"nombre" => "MALLA 2013",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 17,
				"pnf_id" => 4,
				"codigo" => 14,
				"nombre" => "MALLA 2014",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 18,
				"pnf_id" => 5,
				"codigo" => 9,
				"nombre" => "MALLA 2009",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 19,
				"pnf_id" => 5,
				"codigo" => 13,
				"nombre" => "MALLA 2013",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 20,
				"pnf_id" => 5,
				"codigo" => 14,
				"nombre" => "MALLA 2014",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 21,
				"pnf_id" => 5,
				"codigo" => 15,
				"nombre" => "MALLA 2015",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 22,
				"pnf_id" => 6,
				"codigo" => 12,
				"nombre" => "MALLA 2012",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 23,
				"pnf_id" => 6,
				"codigo" => 14,
				"nombre" => "MALLA 2014",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 24,
				"pnf_id" => 7,
				"codigo" => 16,
				"nombre" => "MALLA 2015",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 25,
				"pnf_id" => 12,
				"codigo" => 19,
				"nombre" => "MALLA 2019",
				"observacion" => "NINGUNA",
			),
			array(
				"id" => 26,
				"pnf_id" => 13,
				"codigo" => 19,
				"nombre" => "MALLA 2019",
				"observacion" => "NINGUNA",
			),
		);

		DB::table('plans')->insert($planes);
		// Plan::create($planes);

    }
}
