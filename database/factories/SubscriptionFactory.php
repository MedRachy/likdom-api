<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'nbr_hours' => 1,
            'nbr_employees' => 1,
            'city' => $this->faker->randomElement(['Mohammedia', 'Casablanca']),
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
                'start_time' =>  $this->faker->randomElement(['07:00', '08:00', '09:00', '10:00']),
                'nbr_hours' => 2,
                'nbr_months' => null,
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

    /**
     * Indicate that the model's relations for an offer.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forOffer($offer_id)
    {
        // Likyoum
        if ($offer_id == 1) {
            $passages = collect([["day" => "Lundi", "time" => '09:00']]);
        }
        // Likmeta
        elseif ($offer_id == 2) {
            $passages =  collect(
                [
                    ["day" => "Lundi", "time" => '09:00'],
                    ["day" => "Mercredi", "time" => '10:00'],
                ]
            );
        }
        // offer_3
        elseif ($offer_id == 3) {
            $passages =  collect(
                [
                    ["day" => "Lundi", "time" => '09:00'],
                    ["day" => "Mardi", "time" => '10:00'],
                    ["day" => "Mercredi", "time" => '09:00'],
                ]
            );
        }
        // offer_4
        elseif ($offer_id == 4) {
            $passages =  collect(
                [
                    ["day" => "Lundi", "time" => '09:00'],
                    ["day" => "Mardi", "time" => '10:00'],
                    ["day" => "Mercredi", "time" => '09:00'],
                    ["day" => "Jeudi", "time" => '10:00'],
                    ["day" => "Vendredi", "time" => '09:00'],
                    ["day" => "Samedi", "time" => '10:00'],
                ]
            );
        }
        return $this->state(function (array $attributes) use ($offer_id, $passages) {
            return [
                'offer_id' => $offer_id,
                'passages' => $passages,
                'end_date' => Carbon::parse($attributes['start_date'])->addMonths($attributes['nbr_months']),
            ];
        });
    }
}
