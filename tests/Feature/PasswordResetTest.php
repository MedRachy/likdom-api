<?php

namespace Tests\Feature;

use App\Models\User;
// use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Support\Facades\Notification;
// use Laravel\Fortify\Features;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_reset_with_valid_phone()
    {
        $user = User::factory()->create(['phone' => '644320022']);
        $phone_unvalid = '61122334455';
        $phone_dont_exist = '611223344';

        // valid phone
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/reset-password', [
            'phone' => $user->phone,
            'password' => "new-pass",
            'password_confirmation' => "new-pass"
        ]);

        $response->assertOk();

        // unvalid phone : size:9
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/reset-password', [
            'phone' => $phone_unvalid,
            'password' => "new-pass",
            'password_confirmation' => "new-pass"
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('phone');

        // unvalid phone : no user found with this phone number 
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/reset-password', [
            'phone' => $phone_dont_exist,
            'password' => "new-pass",
            'password_confirmation' => "new-pass"
        ]);
        $response->assertStatus(422);
    }

    public function test_password_can_be_reset_with_valid_new_password()
    {
        $user = User::factory()->create(['phone' => '644320011']);
        // password valid 
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/reset-password', [
            'phone' => $user->phone,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $response->assertOk();

        // password must match
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/reset-password', [
            'phone' => $user->phone,
            'password' => 'new-password',
            'password_confirmation' => 'wrong-password',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('password');


        // password must be min:8
        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/reset-password', [
            'phone' => $user->phone,
            'password' => 'new-p',
            'password_confirmation' => 'new-p',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('password');
    }

    public function test_user_tokens_are_deleted_after_reset()
    {
        $user = User::factory()->create(['phone' => '644320033']);
        Sanctum::actingAs($user, ['*']);

        $response = $this->withHeaders([
            'X-API-KEY' => env('CLIENT_API_KEY'),
        ])->postJson('/api/reset-password', [
            'phone' => $user->phone,
            'password' => "new-pass",
            'password_confirmation' => "new-pass"
        ]);
        $response->assertOk();
        $this->assertCount(0, $user->fresh()->tokens);
    }
    // public function test_reset_password_link_screen_can_be_rendered()
    // {
    //     if (! Features::enabled(Features::resetPasswords())) {
    //         return $this->markTestSkipped('Password updates are not enabled.');
    //     }

    //     $response = $this->get('/forgot-password');

    //     $response->assertStatus(200);
    // }

    // public function test_reset_password_link_can_be_requested()
    // {
    //     if (! Features::enabled(Features::resetPasswords())) {
    //         return $this->markTestSkipped('Password updates are not enabled.');
    //     }

    //     Notification::fake();

    //     $user = User::factory()->create();

    //     $response = $this->post('/forgot-password', [
    //         'email' => $user->email,
    //     ]);

    //     Notification::assertSentTo($user, ResetPassword::class);
    // }

    // public function test_reset_password_screen_can_be_rendered()
    // {
    //     if (! Features::enabled(Features::resetPasswords())) {
    //         return $this->markTestSkipped('Password updates are not enabled.');
    //     }

    //     Notification::fake();

    //     $user = User::factory()->create();

    //     $response = $this->post('/forgot-password', [
    //         'email' => $user->email,
    //     ]);

    //     Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
    //         $response = $this->get('/reset-password/'.$notification->token);

    //         $response->assertStatus(200);

    //         return true;
    //     });
    // }

    // public function test_password_can_be_reset_with_valid_token()
    // {
    //     if (! Features::enabled(Features::resetPasswords())) {
    //         return $this->markTestSkipped('Password updates are not enabled.');
    //     }

    //     Notification::fake();

    //     $user = User::factory()->create();

    //     $response = $this->post('/forgot-password', [
    //         'email' => $user->email,
    //     ]);

    //     Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
    //         $response = $this->post('/reset-password', [
    //             'token' => $notification->token,
    //             'email' => $user->email,
    //             'password' => 'password',
    //             'password_confirmation' => 'password',
    //         ]);

    //         $response->assertSessionHasNoErrors();

    //         return true;
    //     });
    // }
}
