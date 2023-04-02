<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_update_user_name_and_email()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $newName = $this->faker->name();
        $newEmail = $this->faker->email();

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->putJson('/api/user/update', [
            'email' => $newEmail,
            'name' => $newName,
        ]);

        $response->assertOk();
        $this->assertEquals($newName, $user->fresh()->name);
        $this->assertEquals($newEmail, $user->fresh()->email);
    }

    public function test_user_email_must_be_unique()
    {
        Sanctum::actingAs(User::factory()->create());
        $Testuser = User::factory()->create();
        $emailTaken = $Testuser->email;

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->putJson('/api/user/update', [
            'email' => $emailTaken,
            'name' => 'new-name',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('message.email.0', 'The email has already been taken.');
    }

    public function test_update_user_phone()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $newphone = $this->faker->randomNumber(9);

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->putJson('/api/user/update-phone', [
            'phone' => $newphone
        ]);

        $response->assertOk();
        $this->assertEquals($newphone, $user->fresh()->phone);
    }

    public function test_user_phone_must_be_valid()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $Testuser = User::factory()->create();
        $phoneTaken = $Testuser->phone;
        $phone_unvalid = '61122334455';

        // phone unvalid : must be unique
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->putJson('/api/user/update-phone', [
            'phone' => $phoneTaken
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('phone');

        // phone unvalid : size:9
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->putJson('/api/user/update-phone', [
            'phone' => $phone_unvalid
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('phone');
    }
}
