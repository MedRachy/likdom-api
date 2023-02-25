<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    // use RefreshDatabase;

    public function test_api_password_can_be_updated()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $response = $this->postJson('/api/user/update-password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_api_new_password_must_match()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $response = $this->postJson('/api/user/update-password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'wrong-password',
        ]);
        $response->assertStatus(400);
        $response->assertJsonPath('message.password.0', 'The password confirmation does not match.');
    }

    public function test_api_current_password_must_be_correct()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $response = $this->postJson('/api/user/update-password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $response->assertStatus(400);
        $response->assertJsonPath('message.current_password.0', 'The provided password does not match your current password.');
    }
}
