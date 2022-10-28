<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BecaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo' => 'ESTUDIO',
			'alumno_id' => $this->faker->unique()->numberBetween(1, 30)
        ];
    }
}
