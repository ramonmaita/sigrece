<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Pregunta;

class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pregunta::factory()
			->count(6)
			->create();
    }
}
