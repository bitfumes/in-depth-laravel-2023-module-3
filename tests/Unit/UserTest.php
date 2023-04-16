<?php

namespace Tests\Unit;

use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_instructor_name(): void
    {
        $name = (new User())->instructorName();
        $this->assertEquals($name, 'Sarthak Shrivastava');
    }

    public function test_user_has_many_lists()
    {
        $user = User::factory()->create();
        EmailList::factory()->count(3)->create(['user_id' => $user->id]);

        expect($user->lists->first())->toBeInstanceOf(EmailList::class);
        expect($user->lists)->toHaveCount(3);
    }

    public function test_user_has_many_campaigns()
    {
        $user = User::factory()->create();
        Campaign::factory()->count(3)->create(['user_id' => $user->id]);

        expect($user->campaigns->first())->toBeInstanceOf(Campaign::class);
        expect($user->campaigns)->toHaveCount(3);
    }
}
