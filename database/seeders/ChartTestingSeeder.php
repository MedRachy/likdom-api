<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChartTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for ($i = 1; $i <= 3; $i++) {
        //     $user = User::factory()->create();
        //     $sub = Subscription::factory()
        //         ->confirmed()
        //         ->forOffer($i)
        //         ->for($user)
        //         ->create([
        //             'start_date' =>  Carbon::now()->addDays(2)->format('Y-m-d')
        //         ]);
        //     Contract::factory()
        //         ->for($user)
        //         ->for($sub)
        //         ->create();
        // }
        // for ($i = 1; $i <= 4; $i++) {
        //     $user = User::factory()->create();
        //     $sub = Subscription::factory()
        //         ->confirmed()
        //         ->forOffer($i)
        //         ->for($user)
        //         ->create([
        //             'start_date' =>  Carbon::now()->addDays(3)->format('Y-m-d')
        //         ]);
        //     Contract::factory()
        //         ->for($user)
        //         ->for($sub)
        //         ->create();
        // }
        // for ($i = 1; $i <= 2; $i++) {
        //     $user = User::factory()->create();
        //     $sub = Subscription::factory()
        //         ->confirmed()
        //         ->forOffer($i)
        //         ->for($user)
        //         ->create([
        //             'start_date' =>  Carbon::now()->addDays(4)->format('Y-m-d')
        //         ]);
        //     Contract::factory()
        //         ->for($user)
        //         ->for($sub)
        //         ->create();
        // }
        // -------------
        // user confirme a reservation : pending
        for ($i = 0; $i <= 4; $i++) {
            Subscription::factory()
                ->justOnce()
                ->confirmed()
                ->for(User::factory()->create())
                ->create([
                    'start_date' =>  Carbon::now()->addDays(2)->format('Y-m-d')
                ]);
        }
        for ($i = 0; $i <= 2; $i++) {
            Subscription::factory()
                ->justOnce()
                ->confirmed()
                ->for(User::factory()->create())
                ->create([
                    'start_date' =>  Carbon::now()->addDays(4)->format('Y-m-d')
                ]);
        }
        for ($i = 0; $i <= 5; $i++) {
            Subscription::factory()
                ->justOnce()
                ->confirmed()
                ->for(User::factory()->create())
                ->create([
                    'start_date' =>  Carbon::now()->addDays(3)->format('Y-m-d')
                ]);
        }
    }
}
