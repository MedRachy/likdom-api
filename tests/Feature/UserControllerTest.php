<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_new_users_can_register()
    {
        if (!Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        $response = $this->postJson('/api/register', [
            'name' => 'TestUser',
            'email' => 'TestUser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('access-token')
                    ->has('user')
            )
            ->assertJsonPath('user.name', 'TestUser');
        // $this->assertAuthenticated('sanctum');
    }

    public function test_api_user_can_authenticate()
    {
        if (!Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('access-token')
            );
    }

    public function test_api_user_cannot_authenticate_with_invalid_password()
    {
        if (!Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(422);
    }

    public function test_api_get_logged_in_user_data_using_token()
    {
        // 
    }
}
