<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContractsTest extends TestCase
{

    use RefreshDatabase;
    /**
     * Contracts test.
     *
     * @return void
     */
    public function test_can_store_contract()
    {

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $subscription = Subscription::factory()->for($user)->create();


        $response = $this->postJson('/api/create/contract', [
            'subscription_id' => $subscription->id,
            'manager_name' => 'a manager name',
            'company_name' => 'my company',
            'adress' => 'a valid adress',
            'city' => 'Mohammedia',
            'rc_number' => '123 456 789',
            'capital' => '50000'
        ]);

        $this->assertDatabaseHas('contracts', [
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'manager_name' => 'a manager name',
        ]);

        // $response->dump();
        $response->assertStatus(200);
    }
}
