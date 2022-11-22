<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_update_user_name_email()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $response = $this->postJson('/api/user/update', [
            'email' => 'newEmail@gmail.com',
            'name' => 'new-name',
        ]);

        $response->assertOk();
        $this->assertEquals('new-name', $user->fresh()->name);
        $this->assertEquals('newEmail@gmail.com', $user->fresh()->email);
    }

    public function test_api_update_user_email_must_be_unique()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $Testuser = User::factory()->create(['email' => 'Testuser@gmail.com']);

        $response = $this->postJson('/api/user/update', [
            'email' => $Testuser->email,
            'name' => 'new-name',
        ]);

        $response->assertStatus(400);
        $response->assertJsonPath('message.email.0', 'The email has already been taken.');
    }
}
