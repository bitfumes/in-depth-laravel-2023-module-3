<?php

use App\Models\EmailList;
use App\Notifications\ConfirmSubscriptionNotification;
use Illuminate\Support\Facades\Notification;

test("subscribers can subscribe to a list", function () {
    $list = EmailList::factory()->create();
    Notification::fake();

    $response = $this->postJson(route('subscriber.store', [
        'email'   => 'sbc@gmail.com',
        'name'    => 'Sarthak',
        'list_id' => $list->id,
    ]));

    // Assert
    Notification::assertSentOnDemand(ConfirmSubscriptionNotification::class);

    $response->assertOk();
    $this->assertDatabaseHas('subscribers', [
        'email' => 'sbc@gmail.com',
    ]);
});
