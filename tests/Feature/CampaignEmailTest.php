<?php

use App\Mail\CampaignMail;
use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;

test("user can send newsletter email to campaign list subscribers", function () {
    // Arrange
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    Mail::fake();

    $list = EmailList::factory()->create();
    Subscriber::factory()->for($list, 'list')->create([
        'email' => 'sarthak+test1@bitfumes.com',
    ]);
    Subscriber::factory()->for($list, 'list')->create([
        'email' => 'sarthak+test2@bitfumes.com',
    ]);
    $campaign = Campaign::factory()->create([
        'list_id'      => $list->id,
        'scheduled_at' => null,
        'from_email'   => 'sarthak@bitfumes.com',
    ]);

    // Act
    $response = $this->postJson(route('campaign.send', $campaign->id));

    // Assert
    $response->assertStatus(200);
    Mail::assertQueued(CampaignMail::class, 2);
    $this->assertdatabaseHas('campaign_emails', [
        'campaign_id' => $campaign->id,
        'subject'     => $campaign->subject,
        'content'     => $campaign->content,
    ]);
});
