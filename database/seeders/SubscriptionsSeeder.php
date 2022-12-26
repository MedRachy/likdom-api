<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // offer_1
        Subscription::factory()
            ->confirmed()
            ->forOffer(1)
            ->for(User::factory()->create())
            ->create([
                'start_date' =>  Carbon::now()->addDays(2)->format('Y-m-d')
            ]);
        // offer_2
        Subscription::factory()
            ->confirmed()
            ->forOffer(2)
            ->for(User::factory()->create())
            ->create([
                'start_date' =>  Carbon::now()->addDays(3)->format('Y-m-d')
            ]);
        // offer_3
        Subscription::factory()
            ->confirmed()
            ->forOffer(3)
            ->for(User::factory()->create())
            ->create([
                'start_date' =>  Carbon::now()->addDays(4)->format('Y-m-d')
            ]);
    }
}
