<?php

use App\Models\Campaign;
use App\Models\EmailList;

test('campaign belongs to a list', function () {
    $campaign = Campaign::factory()
        ->for(EmailList::factory(), 'list')
        ->create();

    $this->assertInstanceOf(EmailList::class, $campaign->list);
});
