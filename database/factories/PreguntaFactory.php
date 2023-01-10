<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PreguntaFactory extends Factory
{
	protected $model = \App\Models\Pregunta::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pregunta' => $this->faker->text(20),
			'respuesta' => $this->faker->text(200)
        ];
    }
}
