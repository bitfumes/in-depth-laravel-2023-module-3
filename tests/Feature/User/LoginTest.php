<?php

namespace Tests\Feature\User;

use App\Models\User;
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
}
