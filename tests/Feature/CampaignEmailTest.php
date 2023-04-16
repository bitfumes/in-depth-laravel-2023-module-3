<?php

use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test("user can send newsletter email to campaign list subscribers", function () {
    // Arrange
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $list        = EmailList::factory()->create();
    $subscribers = Subscriber::factory()->count(5)->for($list, 'list')->create();
    $campaign    = Campaign::factory()->create(['list_id' => $list->id]);

    // Act
    $response = $this->postJson(route('campaign.send', $campaign->id));

    // Assert
    $response->assertStatus(200);

    $this->assertdatabaseHas('campaign_emails', [
        'campaign_id' => $campaign->id,
        'subject'     => $campaign->subject,
        'content'     => $campaign->content,
    ]);
});
