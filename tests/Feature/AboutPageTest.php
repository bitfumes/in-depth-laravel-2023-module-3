<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutPageTest extends TestCase
{
    public function test_user_can_visit_about_page(): void
    {
        $response = $this->get('/about');
        $response->assertSee('About Page');
    }
}
