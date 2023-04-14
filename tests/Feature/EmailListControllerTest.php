<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('logged in user can create a new list', function () {
    // Arrange
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    // Act
    $this->postJson(route('email-lists.store'), [
        'name' => 'My List',
    ]);

    // Assert
    $this->assertDatabaseHas('email_lists', [
        'name'    => 'My List',
        'user_id' => $user->id,
    ]);
});

test("guests can't create a new list", function () {
    // Act
    $this->withExceptionHandling();

    $this->postJson(route('email-lists.store'), [
        'name' => 'My List',
    ])->assertUnauthorized();
});
