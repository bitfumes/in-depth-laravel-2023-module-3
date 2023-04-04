<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_instructor_name(): void
    {
        $name = (new User())->instructorName();
        $this->assertEquals($name, 'Sarthak Shrivastava');
    }
}
