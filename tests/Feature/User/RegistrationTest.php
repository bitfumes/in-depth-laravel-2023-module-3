<?php

namespace Tests\Feature\User;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_after_successful_registration_user_exists_in_db(): void
    {
        Artisan::call('migrate');
        // Arrange
        $data = [
            'email'                 => 'abc@gmail.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'name'                  => 'Sarthak',
        ];
        // Act
        $response = $this->post('/api/user/register', $data);

        // Assert
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name'  => $data['name'],
        ]);
    }
}
