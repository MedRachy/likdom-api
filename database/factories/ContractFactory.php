<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'manager_name' => $this->faker->name(),
            'company_name' => $this->faker->company(),
            'adress' => $this->faker->address(),
            'city' => $this->faker->randomElement(['Mohammedia', 'Casablanca']),
            'rc_number' => $this->faker->numberBetween(10000, 70000),
            // 'cin_number' => 'xxxxxxxx',
            'capital' => $this->faker->numberBetween(30000, 50000),
        ];
    }
}
