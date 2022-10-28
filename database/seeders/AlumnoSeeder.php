<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Alumno::factory()
			->count(30)
			->create();
    }
}
