<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Illuminate\Database\Seeder;

class PeriodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Periodo::create([
			'nro' => 32,
			'nombre' => '2017-1',
			'observacion' => '2017-1',
			'estatus' => 1
		]);

		Periodo::create([
			'nro' => 33,
			'nombre' => '2018',
			'observacion' => '2018',
			'estatus' => 1
		]);

		Periodo::create([
			'nro' => 35,
			'nombre' => '2019',
			'observacion' => '2019',
			'estatus' => 1
		]);

		Periodo::create([
			'nro' => 36,
			'nombre' => 'CIU-2019',
			'observacion' => 'CIU-2019',
			'estatus' => 1
		]);

		Periodo::create([
			'nro' => 37,
			'nombre' => '2020',
			'observacion' => '2020',
			'estatus' => 0
		]);
    }
}
