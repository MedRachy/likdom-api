<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubscriptionsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test subscriptions.
     *
     * @return void
     */
    public function test_get_all_user_subscriptions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $offer = Offer::factory()->ProOffer(3)->create();
        Subscription::factory(5)->for($offer)->for($user)->create();
        Subscription::factory()->for($offer)->for($user)->Concluded()->create();

        $response = $this->getJson('/api/get/subscriptions');
        $response->assertJsonCount(5, 'data')
            ->assertJsonPath('data.0.user_id', $user->id)
            ->assertJsonPath('data.0.offer.id', $offer->id);
    }

    public function test_get_all_user_concluded_subscriptions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $offer = Offer::factory()->ProOffer(3)->create();
        Subscription::factory(2)->for($offer)->for($user)->Validated()->create();
        Subscription::factory(2)->for($offer)->for($user)->Concluded()->create();

        $response = $this->getJson('/api/get/subscriptions/concluded');
        $response->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.user_id', $user->id)
            ->assertJsonPath('data.0.status', 'concluded')
            ->assertJsonPath('data.0.offer.id', $offer->id);
    }

    public function test_can_store_subscription()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $location = [
            'long' => 1234,
            'lat' => 5678
        ];

        $passages = [
            ["day" => "Lundi", "time" => '09:00'],
            ["day" => "Mercredi", "time" => '10:00'],
            ["day" => "Vendredi", "time" => '11:00']
        ];

        $response =    $this->postJson('/api/create/subscription', [
            'start_date' => '2022-11-30',
            'nbr_hours' => 2,
            'nbr_employees' => 1,
            'nbr_months' => 1,
            'passages' => json_encode($passages),
            'location' => json_encode($location),
            'city' => 'Mohammedia',
            'price' => 300
        ]);

        // $response->dump();

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'start_date' => '2022-11-30'
        ]);
    }

    public function test_get_pro_subscription_total_price()
    {
        // --------- valid inputs : 
        $nbr_hours = 2;
        $nbr_employees = 1;
        $nbr_passages = 3;
        // total expected = 150 
        $response =  $this->getJson('/api/get_pro_total_price/' . $nbr_hours .
            '/' .  $nbr_employees .
            '/' . $nbr_passages);

        $response->assertStatus(200)
            ->assertJsonPath('total_price', 1800);
        // ---------- unvalid inputs : 
        $nbr_hours = 1;
        $nbr_employees = 0;
        // total expected = 150 
        $response =  $this->getJson('/api/get_pro_total_price/' . $nbr_hours .
            '/' .  $nbr_employees .
            '/' . $nbr_passages);

        $response->assertStatus(403)
            ->assertJsonPath('message', 'unvalid inputs');
    }

    public function test_get_part_subscription_total_price()
    {
        // --------- valid inputs : 
        $nbr_hours = 2;
        $nbr_employees = 1;
        $nbr_passages = 1;
        // total expected = 150 
        $response =  $this->getJson('/api/get_pro_total_price/' . $nbr_hours .
            '/' .  $nbr_employees .
            '/' . $nbr_passages);

        $response->assertStatus(200)
            ->assertJsonPath('total_price', 600);
        // ---------- unvalid inputs : 
        $nbr_hours = 1;
        $nbr_employees = 0;
        // total expected = 150 
        $response =  $this->getJson('/api/get_pro_total_price/' . $nbr_hours .
            '/' .  $nbr_employees .
            '/' . $nbr_passages);

        $response->assertStatus(403)
            ->assertJsonPath('message', 'unvalid inputs');
    }

    public function test_recap_page_cannot_return_sub_if_not_authenticated()
    {
        $subscription = Subscription::factory()
            ->for(User::factory())
            ->create();
        $response = $this->getJson('/api/recap/' . $subscription->id);
        $response->assertStatus(401)
            ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_recap_page_cannot_return_sub_if_sub_dont_belong_to_authenticated_user()
    {

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Sanctum::actingAs($user1);
        $subscription = Subscription::factory()
            ->for($user2)
            ->create();
        $response = $this->getJson('/api/recap/' . $subscription->id);

        $response->assertStatus(403)
            ->assertJsonPath('message', 'Not authorized.');
    }

    public function test_recap_page_return_sub()
    {
        $user = User::factory()->create();
        $offer = Offer::factory()->ProOffer(3)->create();

        Sanctum::actingAs($user);
        $subscription = Subscription::factory()
            ->for($user)
            ->for($offer)
            ->create();
        $response = $this->getJson('/api/recap/' . $subscription->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $subscription->id)
            ->assertJsonPath('data.offer.nbr_passages', $offer->nbr_passages);

        $response->dump();
    }
}
