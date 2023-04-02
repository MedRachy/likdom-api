<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_new_user_can_register()
    {
        $name =  $this->faker->name();

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/register', [
            'name' =>  $name,
            'phone' =>  '644320000',
            'email' =>  $this->faker->email(),
            'password' => 'password',
            'password_confirmation' => 'password',
            // 'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $response->assertOk(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('access-token')
                    ->has('user')
            )
            ->assertJsonPath('user.name', $name);
        // $this->assertAuthenticated('sanctum');
    }

    public function test_check_register_validation()
    {
        $user = User::factory()->create([
            'phone' => '644320011',
            'email' => 'email_test@teste.com'
        ]);

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/register', [
            'name' =>   $this->faker->name(),
            'phone' =>  $user->phone,
            'email' =>  $user->email,
            'password' => 'password',
            'password_confirmation' => 'wrong-password',
            // 'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('phone')
            ->assertJsonValidationErrorFor('email')
            ->assertJsonValidationErrorFor('password');
    }
}
