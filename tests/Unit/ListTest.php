<?php

use App\Models\EmailList;
use App\Models\User;

test('list belongs to a user', function () {
    User::factory()->create();
    $list = EmailList::factory()->create();

    $this->assertInstanceOf(User::class, $list->user());
});

test('when user is deleted then email list of that user also deleted', function () {
    $user = User::factory()->create();
    $list = EmailList::factory()->create(['user_id' => $user->id]);

    $user->delete();

    $this->assertNull(EmailList::find($list->id));
    $this->assertdatabaseMissing('email_lists', ['id' => $list->id]);
});
