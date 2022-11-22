<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service' => 'menage',
            'nbr_hours' => 1,
            'nbr_employees' => 1,
        ];
    }

    /**
     * Indicate that the model's type should be just one time.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function justOnce()
    {
        return $this->state(function (array $attributes) {
            return [
                'just_once' => true,
                'start_date' => '2022-12-10',
                'start_time' => '09:00',
                'nbr_hours' => 2,
            ];
        });
    }
}
