<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionOnceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * test store once subscription.
     *
     * @return void
     */
    public function test_can_store_subscription()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $location = [
            'long' => 1234,
            'lat' => 5678
        ];

        $response = $this->postJson('/api/subscription/create/once', [
            'start_date' => '2022-11-30',
            'start_time' => '09:00',
            'nbr_hours' => '02:00',
            'nbr_employees' => 1,
            'location' => json_encode($location)
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'start_date' => '2022-11-30',
        ]);
    }

    public function test_get_available_hours()
    {
        $date = '2022-11-30';
        // employee factory
        // subscription factory 

        $response = $this->getJson('/api/get/available/hours/' . $date);

        $response->dump();
    }
}
