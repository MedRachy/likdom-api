<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/user/update-password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_new_password_must_match()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/user/update-password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'wrong-password',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('message.password.0', 'The password confirmation does not match.');
    }

    public function test_current_password_must_be_correct()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/user/update-password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('message.current_password.0', 'The provided password does not match your current password.');
    }
}
