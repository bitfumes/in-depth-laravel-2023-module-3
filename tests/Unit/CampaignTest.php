<?php

use App\Models\Campaign;
use App\Models\CampaignEmail;
use App\Models\EmailList;

test('campaign belongs to a list', function () {
    $campaign = Campaign::factory()
        ->for(EmailList::factory(), 'list')
        ->create();

    $this->assertInstanceOf(EmailList::class, $campaign->list);
});

test('campaign has many fields', function () {
    $campaign = Campaign::factory()->raw();

    $this->assertArrayHasKey('name', $campaign);
    $this->assertArrayHasKey('subject', $campaign);
    $this->assertArrayHasKey('content', $campaign);
    $this->assertArrayHasKey('scheduled_at', $campaign);
    $this->assertArrayHasKey('status', $campaign);
    $this->assertArrayHasKey('total_recipients', $campaign);
    $this->assertArrayHasKey('delivered', $campaign);
    $this->assertArrayHasKey('opens', $campaign);
    $this->assertArrayHasKey('clicks', $campaign);
    $this->assertArrayHasKey('unsubscribes', $campaign);
    $this->assertArrayHasKey('bounces', $campaign);
    $this->assertArrayHasKey('complaints', $campaign);
    $this->assertArrayHasKey('from_name', $campaign);
    $this->assertArrayHasKey('from_email', $campaign);
    $this->assertArrayHasKey('type', $campaign);
});

test("campaign can have many campaignemails", function () {
    $campaign = Campaign::factory()->create();

    CampaignEmail::factory()->create([
        'campaign_id' => $campaign->id,
    ]);

    $this->assertInstanceOf(CampaignEmail::class, $campaign->emails->first());
});
