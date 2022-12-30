<?php

namespace Database\Seeders;

use App\Models\Contract;
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
        // subscription confirmed with contract 
        for ($i = 1; $i <= 4; $i++) {
            $user = User::factory()->create();
            $sub = Subscription::factory()
                ->confirmed()
                ->forOffer($i)
                ->for($user)
                ->create([
                    'start_date' =>  Carbon::now()->addDays(2 + $i)->format('Y-m-d')
                ]);
            Contract::factory()
                ->for($user)
                ->for($sub)
                ->create();
        }
    }
}
