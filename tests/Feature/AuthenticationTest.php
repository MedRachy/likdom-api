<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_user_can_authenticate()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'phone' => $user->phone,
            'password' => 'password',
        ]);
        $response->assertOk(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('access-token')
            );
    }

    public function test_api_user_cannot_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'phone' => $user->phone,
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(422);
    }
}
