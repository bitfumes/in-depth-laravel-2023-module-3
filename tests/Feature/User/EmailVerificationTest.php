<?php

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Notification;

test("after_successful_registration_user_exists_in_db", function () {
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
