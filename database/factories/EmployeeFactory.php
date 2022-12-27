<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'last_name' => $this->faker->name(),
            'first_name' => $this->faker->firstName(),
            'phone' => $this->faker->phoneNumber(),
            'adress' => $this->faker->address(),
            'city' => $this->faker->randomElement(['Mohammedia', 'Casablanca']),
            'date_birth' => $this->faker->date(),
            //   'availability' =>  $this->faker->randomElement(['disponible', 'conge', 'autre']),
            'sex' =>  $this->faker->randomElement(['F', 'M']),
            'speciality' =>  'menage'
        ];
    }
}
