<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_new_user_can_register()
    {

        $response = $this->postJson('/api/register', [
            'name' => 'TestUser',
            'phone' => '644320021',
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
}
