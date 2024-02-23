<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ComicsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(),
            'coleccion' => $this->faker->randomElement(['X-men', 'Doctor Muerte', 'Batman', 'Superman']),
            'genero' => $this->faker->randomElement(['Ficción', 'Bélico', 'Deportivo'])
        ];
    }
}