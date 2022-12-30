<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // create an admin user
            AdminUsersSeeder::class,
            // create list of offers 
            OfferSeeder::class,
            // subscription with offers test
            SubscriptionsSeeder::class,
            // reservations 
            ReservationsSeeder::class
        ]);
    }
}
