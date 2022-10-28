<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

		$names = explode(' ', $this->faker->name());
        return [
			'cedula' => $this->faker->randomNumber(5, true),
			'p_nombre' => $names[0],
			's_nombre' => $names[2] ?? null,
			'p_apellido' => $names[1],
			's_apellido' => $names[3] ?? null,
			'sexo' => null,
			'escivil' => null,
			'nacionalidad' => 'Venezolano',
			'fechan' => $this->faker->date(),
			'lugarn' => null,
			'pnf_id' => 1,
			'plan_id' => 1,
			'nucleo_id' => 1,
			'tipo' => 12,
			'imagen' => null
        ];
    }
}
