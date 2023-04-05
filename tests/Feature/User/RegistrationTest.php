<?php

namespace Tests\Feature\User;

use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_after_successful_registration_user_exists_in_db(): void
    {
        // Arrange
        $data = [
            'email'                 => 'abc@gmail.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'name'                  => 'Sarthak',
        ];
        // Act
        $this->post(route('user.register'), $data);
        // Assert
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name'  => $data['name'],
        ]);
    }
}
