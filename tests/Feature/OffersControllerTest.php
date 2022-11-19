<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OffersControllerTest extends TestCase
{
    /**
     * test get offers data.
     *
     * @return void
     */
    public function test_get_pro_offers()
    {
        $response = $this->getJson('/api/offers/pro');

        $response->assertOk()
            ->assertJsonFragment(['user_type' => 'pro'])
            ->assertJsonCount(3, 'data');
    }

    public function test_get_part_offers()
    {
        $response = $this->getJson('/api/offers/part');

        $response->assertOk()
            ->assertJsonFragment(['user_type' => 'part'])
            ->assertJsonCount(3, 'data');
    }
}
