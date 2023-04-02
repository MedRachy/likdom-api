<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_block_unauthorized_api_key_client()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'X-API-KEY' => 'wrong-api-key',
        ])->postJson('/api/login', [
            'phone' => $user->phone,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
    }

    public function test_user_can_authenticate()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/login', [
            'phone' => $user->phone,
            'password' => 'password',
        ]);
        $response->assertOk(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('access-token')
            );
    }

    public function test_user_cannot_authenticate_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/login', [
            'phone' => $user->phone,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }
}
