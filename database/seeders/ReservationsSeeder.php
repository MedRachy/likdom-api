<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user confirme a reservation : pending
        for ($i = 0; $i <= 4; $i++) {
            Subscription::factory()
                ->justOnce()
                ->confirmed()
                ->for(User::factory()->create())
                ->create([
                    'start_date' =>  Carbon::now()->addDays($i + 1)->format('Y-m-d')
                ]);
        }
    }
}
