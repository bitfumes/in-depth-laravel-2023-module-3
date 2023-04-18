<?php

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

test("after_successful_registration_user_will_get_verify_email", function () {
    // Arrange
    Notification::fake();
    $this->data = [
        'email'                 => 'abc@gmail.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
        'name'                  => 'Sarthak',
    ];

    // Act
    $response = $this->postJson(route('user.register'), $this->data);
    $user     = User::find(1);

    // Assert
    Notification::assertSentTo($user, VerifyEmailNotification::class);
});

test("user can click on verify email link and email will be verified", function () {
    // Arrage
    $user = User::factory()->create(['email_verified_at' => null]);

    // Act
    $url      = URL::signedRoute('user.verify', ['email' => $user->email]);
    $response = $this->get($url);

    // Assert
    $response->assertRedirect();
    $this->assertNotNull($user->fresh()->email_verified_at);
});
