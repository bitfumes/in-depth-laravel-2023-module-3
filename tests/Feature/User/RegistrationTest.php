<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
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
        $response = $this->postJson('/api/user/register', $data);

        // Assert
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name'  => $data['name'],
        ]);
    }

    public function test_password_field_has_to_be_encrypted()
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
        $this->postJson('/api/user/register', $data);

        // Assert
        $user = User::latest()->first();
        $this->assertTrue(Hash::check($data['password'], $user->password));
    }

    public function test_while_registration_email_field_is_required()
    {
        // Arrange
        Artisan::call('migrate');
        $this->withExceptionHandling();

        // Act
        $response = $this->postJson('/api/user/register', []);

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrorFor('email');
        $response->assertJsonValidationErrorFor('name');
        $response->assertJsonValidationErrorFor('password');
    }
}
