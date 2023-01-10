<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Beca;

class BecaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Beca::factory()
			->count(20)
			->create();
    }
}
