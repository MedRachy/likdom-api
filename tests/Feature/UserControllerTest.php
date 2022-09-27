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

        $response->assertOk(200)
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
        $response->assertOk(200)
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


    public function test_api_password_can_be_updated()
    {
        if (!Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        Sanctum::actingAs($user = User::factory()->create());

        $response = $this->postJson('/api/user/update_password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }
}
