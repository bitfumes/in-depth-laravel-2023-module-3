<?php

use App\Models\EmailList;
use App\Models\Subscriber;

test('subscriber belongs to a list', function () {
    $subscriber = Subscriber::factory()
        ->for(EmailList::factory(), 'list')
        ->create();

    $this->assertInstanceOf(EmailList::class, $subscriber->list);
});

test("subscriber table has many fields", function () {
    $subscriber = Subscriber::factory()->create();

    $this->assertArrayHasKey('email', $subscriber->toArray());
    $this->assertArrayHasKey('name', $subscriber->toArray());
    $this->assertArrayHasKey('status', $subscriber->toArray());
    $this->assertArrayHasKey('confirmed_at', $subscriber->toArray());
    $this->assertArrayHasKey('unsubscribed_at', $subscriber->toArray());
    $this->assertArrayHasKey('meta', $subscriber->toArray());
});
