<?php

use App\Models\EmailList;
use App\Models\Subscriber;
use App\Notifications\ConfirmSubscriptionNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

test("subscribers can subscribe to a list", function () {
    $list = EmailList::factory()->create();
    Notification::fake();

    $response = $this->postJson(route('subscriber.store', $list->id, ), [
        'email' => 'sbc@gmail.com',
        'name'  => 'Sarthak',
    ]);

    // Assert
    Notification::assertSentOnDemand(ConfirmSubscriptionNotification::class);

    $response->assertOk();
    $this->assertDatabaseHas('subscribers', [
        'email' => 'sbc@gmail.com',
    ]);
});

test("user can confirm their subscription by using this link on email", function () {
    $list = EmailList::factory()->create();
    Notification::fake();

    $this->postJson(route('subscriber.store', $list->id), [
        'email' => 'abc@gmail.com',
    ]);

    $subscriber = Subscriber::first();

    $url = URL::signedRoute('subscriber.confirm', ['subscriber' => $subscriber->email]);

    $this->getJson($url)
        ->assertOk()
        ->assertSee('Subscription confirmed');

    $this->assertNotNull($subscriber->fresh()->confirmed_at);
});

test('subscriber can unsubscribe from a list', function () {
    // Arrange
    $list = EmailList::factory()->create();
    Notification::fake();
    $this->postJson(route('subscriber.store', $list->id), [
        'email'           => 'abc@gmai.com',
        'confirmed_at'    => now(),
        'unsubscribed_at' => null,
    ]);

    $subscriber = Subscriber::first();

    // Act
    $url = URL::signedRoute('subscriber.unsubscribe', ['subscriber' => $subscriber->email]);

    $this->getJson($url)
        ->assertOk()
        ->assertSee('Unsubscribed');

    $this->assertNotNull($subscriber->fresh()->unsubscribed_at);
});
