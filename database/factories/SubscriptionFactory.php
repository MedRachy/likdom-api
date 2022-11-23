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
            'city' => 'Mohammedia',
            'nbr_months' => 1
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

    /**
     * confirmed state : confirmed by the user and waiting for admin to validate 
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function Confirmed()
    {
        return $this->state(function (array $attributes) {
            return [
                "status" => "pending",
                "confirmed" => true
            ];
        });
    }

    /**
     * validated state : confirmed by the user and validated by the amdin .
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function Validated()
    {
        return $this->state(function (array $attributes) {
            return [
                "status" => "valid",
                "confirmed" => true
            ];
        });
    }

    /**
     * concluded state : was confirmed by the user and concluded by the admin
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function Concluded()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'concluded',
                'confirmed' => true
            ];
        });
    }
}
