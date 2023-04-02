<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;


class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_get_logged_in_user_data()
    {
        $user = User::factory()->create(['email' => 'TesteUser@gmail.com']);
        Sanctum::actingAs($user,  ['*']);

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->getJson('/api/user');

        $response->assertOk()
            ->assertJsonPath('data.email', 'TesteUser@gmail.com');
    }

    public function test_phone_validation()
    {
        $user = User::factory()->create(['phone' => '644320022']);
        Sanctum::actingAs($user,  ['*']);

        $phone_valid = '611223344';
        $phone_unvalid = '61122334455';
        // valid phone
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->getJson('/api/user/validate-phone?phone=' . $phone_valid);

        $response->assertOk();
        // unvalid phone : size:9
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->getJson('/api/user/validate-phone?phone=' . $phone_unvalid);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('phone');

        // unvalid phone : must be unique
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->getJson('/api/user/validate-phone?phone=' . $user->phone);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('phone');
    }

    public function test_phone_check_existence()
    {
        $user = User::factory()->create(['phone' => '644320011']);

        $phone_valid = '611223344';
        $phone_unvalid = '61122334455';

        // valid phone and exist
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->getJson('/api/phone-check?phone=' . $user->phone);

        $response->assertOk();

        // unvalid phone and dont exist : size:9
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->getJson('/api/phone-check?phone=' . $phone_unvalid);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('phone');

        // valid phone but dont exist
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->getJson('/api/phone-check?phone=' . $phone_valid);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('phone');
    }

    public function test_password_check()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,  ['*']);

        // password correct
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/user/password-check', [
            'password' => 'password',
        ]);
        $response->assertOk();

        // incorrect password
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/user/password-check', [
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(422);
    }
}
