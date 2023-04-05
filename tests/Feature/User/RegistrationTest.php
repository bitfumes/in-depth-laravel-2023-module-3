<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public $data;

    public function setup() :void
    {
        parent::setup();
        Artisan::call('migrate');

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
        $response = $this->postJson('/api/user/register', $this->data);

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
        $this->postJson('/api/user/register', $this->data);

        // Assert
        $user = User::latest()->first();
        $this->assertTrue(Hash::check($this->data['password'], $user->password));
    }

    public function test_while_registration_email_field_is_required()
    {
        // Arrange
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
