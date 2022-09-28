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

        $response = $this->postJson('/api/user/update-password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }
    public function test_api_new_password_must_match()
    {
        if (!Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

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
        if (!Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        Sanctum::actingAs($user = User::factory()->create());

        $response = $this->postJson('/api/user/update-password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $response->assertStatus(400);
        $response->assertJsonPath('message.current_password.0', 'The provided password does not match your current password.');
    }

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

    public function test_api_update_user_adresse_ville()
    {
        Sanctum::actingAs($user = User::factory()->create());

        $response = $this->postJson('/api/user/update-adresse', [
            'adresse' => 'Rachidia 1 NR 225',
            'ville' => 'Mohammedia',
        ]);

        $response->assertOk();
        $this->assertEquals('Rachidia 1 NR 225', $user->fresh()->adresse);
        $this->assertEquals('Mohammedia', $user->fresh()->ville);
    }
}
