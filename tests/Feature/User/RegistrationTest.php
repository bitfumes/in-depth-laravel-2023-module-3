<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public $data;

    public function setup() :void
    {
        parent::setup();

        $this->data = [
            'email'                 => 'abc@gmail.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'name'                  => 'Sarthak',
        ];
    }

    /**
     * A basic feature test example.
     */
    public function test_after_successful_registration_user_exists_in_db(): void
    {
        // Act
        $response = $this->postJson(route('user.register'), $this->data);

        // Assert
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => $this->data['email'],
            'name'  => $this->data['name'],
        ]);
    }

    public function test_password_field_has_to_be_encrypted()
    {
        // Act
        $this->postJson(route('user.register'), $this->data);

        // Assert
        $user = User::latest()->first();
        $this->assertTrue(Hash::check($this->data['password'], $user->password));
    }

    public function test_while_registration_all_field_is_required()
    {
        // Arrange
        $this->withExceptionHandling();

        // Act
        $response = $this->postJson(route('user.register'), []);

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrorFor('email');
        $response->assertJsonValidationErrorFor('name');
        $response->assertJsonValidationErrorFor('password');
    }

    public function test_while_registration_email_has_to_be_valid_email()
    {
        // Arrange
        $this->withExceptionHandling();

        // Act
        $response = $this->postJson(route('user.register'), [
            'email' => 'abc',
        ]);

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrorFor('email');
        $this->assertEquals($response->json('errors.email.0'), "The email field must be a valid email address.");
    }

    public function test_while_registration_password_must_be_confirmed()
    {
        // Arrange
        $this->withExceptionHandling();

        // Act
        $response = $this->postJson(route('user.register'), [
            'password' => 'password',
        ]);

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrorFor('password');
        $this->assertEquals($response->json('errors.password.0'), "The password field confirmation does not match.");
    }
}
