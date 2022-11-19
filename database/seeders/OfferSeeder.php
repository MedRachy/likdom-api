<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offers')->insert([
            [
                'id' => 1,
                'label' => 'offer label',
                'name' => 'offer name',
                'description' => 'offer descriptions',
                'nbr_passages' => 1,
                'start_price' => 200,
                'user_type' => 'pro'
            ],
            [
                'id' => 2,
                'label' => 'offer label',
                'name' => 'offer name',
                'description' => 'offer descriptions',
                'nbr_passages' => 2,
                'start_price' => 250,
                'user_type' => 'pro'
            ],            [
                'id' => 3,
                'label' => 'offer label',
                'name' => 'offer name',
                'description' => 'offer descriptions',
                'nbr_passages' => 3,
                'start_price' => 300,
                'user_type' => 'pro'
            ],            [
                'id' => 4,
                'label' => 'offer label',
                'name' => 'offer name',
                'description' => 'offer descriptions',
                'nbr_passages' => 1,
                'start_price' => 150,
                'user_type' => 'part'
            ],            [
                'id' => 5,
                'label' => 'offer label',
                'name' => 'offer name',
                'description' => 'offer descriptions',
                'nbr_passages' => 3,
                'start_price' => 200,
                'user_type' => 'part'
            ],            [
                'id' => 6,
                'label' => 'offer label',
                'name' => 'offer name',
                'description' => 'offer descriptions',
                'nbr_passages' => 6,
                'start_price' => 600,
                'user_type' => 'part'
            ],
        ]);
    }
}
