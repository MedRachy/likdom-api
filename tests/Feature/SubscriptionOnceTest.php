<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Subscription;
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
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $location = [
            'long' => 1234,
            'lat' => 5678
        ];

        $this->postJson('/api/create/reservation', [
            'start_date' => '2022-11-30',
            'start_time' => '09:00',
            'nbr_hours' => 2,
            'nbr_employees' => 1,
            'location' => json_encode($location),
            'city' => 'Mohammedia',
            'price' => 230
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'start_date' => '2022-11-30',
        ]);
    }

    public function test_confirm_subscription()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $subscription = Subscription::factory()
            ->for($user)
            ->justOnce()
            ->create();
        $response = $this->putJson('/api/confirm/' . $subscription->id);

        $response->assertStatus(200)
            ->assertJsonPath('message', 'confirmed');
        $this->assertEquals(1, $subscription->fresh()->confirmed);
    }

    public function test_get_subscription_total_price()
    {
        // --------- valid inputs : 
        $nbr_hours = 2;
        $nbr_employees = 1;
        // total expected = 150 
        $response =  $this->getJson('/api/get_total_price/' . $nbr_hours . '/' . $nbr_employees);

        $response->assertStatus(200)
            ->assertJsonPath('total_price', 150);
        // ---------- unvalid inputs : 
        $nbr_hours = 1;
        $nbr_employees = 0;
        // total expected = 150 
        $response =  $this->getJson('/api/get_total_price/' . $nbr_hours . '/' . $nbr_employees);

        $response->assertStatus(403)
            ->assertJsonPath('message', 'unvalid inputs');
    }
}
