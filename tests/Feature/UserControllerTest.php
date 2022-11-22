<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;
use Laravel\Sanctum\Sanctum;


class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_api_get_logged_in_user_data()
    {
        if (!Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        $user = User::factory()->create(['email' => 'TesteUser@gmail.com']);
        Sanctum::actingAs($user,  ['*']);

        $response = $this->getJson('/api/user');

        $response->assertOk()
            ->assertJsonPath('data.email', 'TesteUser@gmail.com');
    }
}
