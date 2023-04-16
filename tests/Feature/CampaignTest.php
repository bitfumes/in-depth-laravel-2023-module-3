<?php

use App\Models\EmailList;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test("user can create new campaign", function () {
    $user = User::factory()->create();
    $list = EmailList::factory()->create();
    Sanctum::actingAs($user);

    // Arrange
    $data = [
        'name'       => 'Test Campaign',
        'subject'    => 'Test Subject',
        'content'    => 'Hi this is my first test email',
        'from_name'  => 'Sarthak',
        'from_email' => 'abcd@gmail.com',
        'list_id'    => $list->id,
    ];

    // Act
    $response = $this->postJson(route('campaign.store'), $data);

    // Assert
    $response->assertCreated();
    $this->assertDatabaseHas('campaigns', $data);
});
