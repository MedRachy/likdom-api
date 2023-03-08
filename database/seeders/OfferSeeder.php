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
                'label' => 'Offre N°1',
                'name' => 'Offre N°1',
                'description' => '1 passage par semaine',
                'nbr_passages' => 1,
                'start_price' => 300,
                'user_type' => 'pro'
            ],
            [
                'id' => 2,
                'label' => 'Offre N°2',
                'name' => 'Offre N°2',
                'description' => '2 passages par semaine',
                'nbr_passages' => 2,
                'start_price' => 600,
                'user_type' => 'pro'
            ],
            [
                'id' => 3,
                'label' => 'Offre N°3',
                'name' => 'Offre N°3',
                'description' => '3 passages par semaine',
                'nbr_passages' => 3,
                'start_price' => 900,
                'user_type' => 'pro'
            ],
            [
                'id' => 4,
                'label' => 'Offre N°4',
                'name' => 'Offre Personnalisable',
                'description' => 'Vos passages sur mesure',
                'nbr_passages' => null,
                'start_price' => 300,
                'user_type' => 'pro'
            ],
            [
                'id' => 5,
                'label' => 'Offre N°1',
                'name' => 'Offre N°1',
                'description' => '1 passage par semaine',
                'nbr_passages' => 1,
                'start_price' => 440,
                'user_type' => 'part'
            ],
            [
                'id' => 6,
                'label' => 'Offre N°2',
                'name' => 'Offre N°2',
                'description' => '3 passages par semaine',
                'nbr_passages' => 3,
                'start_price' => 1320,
                'user_type' => 'part'
            ],
            [
                'id' => 7,
                'label' => 'Offre N°3',
                'name' => 'Offre N°3',
                'description' => '6 passages par semaine',
                'nbr_passages' => 6,
                'start_price' => 2640,
                'user_type' => 'part'
            ],
            [
                'id' => 8,
                'label' => 'Offre N°4',
                'name' => 'Offre Personnalisable',
                'description' => 'Vos passages sur mesure',
                'nbr_passages' => null,
                'start_price' => 440,
                'user_type' => 'part'
            ],
        ]);
    }
}
