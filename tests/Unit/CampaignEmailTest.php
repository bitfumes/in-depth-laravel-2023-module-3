<?php

use App\Models\Campaign;
use App\Models\CampaignEmail;

test('campaign emails belongs to a campaign', function () {
    $campaignemail = CampaignEmail::factory()
        ->for(Campaign::factory())
        ->create();

    $this->assertInstanceOf(Campaign::class, $campaignemail->campaign);
});

test('campaign email has many fields', function () {
    $campaignEmail = CampaignEmail::factory()->raw();

    $this->assertArrayHasKey('sent_at', $campaignEmail);
    $this->assertArrayHasKey('opened_at', $campaignEmail);
    $this->assertArrayHasKey('clicked_at', $campaignEmail);
    $this->assertArrayHasKey('unsubscribed_at', $campaignEmail);
    $this->assertArrayHasKey('bounced_at', $campaignEmail);
    $this->assertArrayHasKey('complained_at', $campaignEmail);
});
