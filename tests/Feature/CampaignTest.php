<?php

use App\Models\Campaign;
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

test("campaign can be updated", function () {
    $campaign = Campaign::factory()->create()->toArray();
    $user     = User::factory()->create();
    Sanctum::actingAs($user);

    $this->putJson(route('campaign.update', $campaign['id']), [
        ...$campaign,
        'name' => 'Updated Campaign',
    ])->assertOk();

    $this->assertDatabaseHas('campaigns', [
        'id'   => $campaign['id'],
        'name' => 'Updated Campaign',
    ]);
});

test("campaign can be deleted", function () {
    $campaign = Campaign::factory()->create();
    $user     = User::factory()->create();
    Sanctum::actingAs($user);

    $this->deleteJson(route('campaign.destroy', $campaign->id))->assertStatus(204);

    $this->assertDatabaseMissing('campaigns', [
        'id' => $campaign->id,
    ]);
});

test("user can list all the campaigns", function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $campaigns = Campaign::factory()->count(2)->create([
        'user_id' => $user->id,
    ]);
    Campaign::factory()->count(2)->create();

    $response = $this->getJson(route('campaign.index'));

    $response->assertOk();
    $response->assertJsonCount(2, 'data');
});
