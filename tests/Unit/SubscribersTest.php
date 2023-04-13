<?php

use App\Models\EmailList;
use App\Models\Subscriber;

test('subscriber belongs to a list', function () {
    $subscriber = Subscriber::factory()
        ->for(EmailList::factory())
        ->create();

    $this->assertInstanceOf(EmailList::class, $subscriber->emaillist);
});
