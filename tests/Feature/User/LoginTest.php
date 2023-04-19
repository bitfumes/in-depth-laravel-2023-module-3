<?php

namespace Tests\Feature\User;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_user_can_login_with_email_and_password()
    {
        // Arrage
        $user = User::create([
            'email'    => 'abc@gmail.com',
            'password' => bcrypt('password'),
            'name'     => 'Sarthak',
        ]);
        $user->email_verified_at = now();
        $user->save();

        // Act
        $response = $this->postJson(route('user.login'), ['email' => $user->email, 'password' => 'password']);

        // Assert
        $this->assertArrayHasKey('token', $response->json());
    }

    public function test_user_login_has_validation_for_email_and_password()
    {
        // Arrage
        $this->withExceptionHandling();
        $user = User::create([
            'email'    => 'abc@gmail.com',
            'password' => bcrypt('password'),
            'name'     => 'Sarthak',
        ]);

        // Act
        $response = $this->postJson(route('user.login'), []);

        // Assert
        $response->assertJsonValidationErrorFor('password');
        $response->assertJsonValidationErrorFor('email');
    }

    public function test_user_token_will_be_removed_on_logout()
    {
        $user = User::factory()->create();

        $this->postJson(route('user.login'), ['email' => $user->email, 'password' => 'password']);

        $this->assertDatabasehas('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);

        Sanctum::actingAs($user);
        $this->postJson(route('user.logout'));
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_user_will_not_able_to_login_if_not_verified_email()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->postJson(route('user.login'), [
            'email' => $user->email, 'password' => 'password',
        ]);

        $response->assertStatus(401);
    }
}
