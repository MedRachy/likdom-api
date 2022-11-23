<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => 'offer label',
            'name' => 'offer name',
            'description' => 'offer descriptions',
            'nbr_passages' => 1,
            'start_price' => 200,
            'user_type' => 'pro'
        ];
    }

    /**
     * Indicate that the model's type should be pro offer.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function ProOffer($passages = 1)
    {
        return $this->state(function (array $attributes) use ($passages) {
            return [
                'nbr_passages' => $passages,
                'user_type' => 'pro'
            ];
        });
    }

    /**
     * Indicate that the model's type should be part offer.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function PartOffer($passages = 1)
    {
        return $this->state(function (array $attributes) use ($passages) {
            return [
                'nbr_passages' => $passages,
                'user_type' => 'part'
            ];
        });
    }
}
