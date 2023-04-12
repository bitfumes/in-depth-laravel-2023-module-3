<?php

it('test_user_can_visit_about_page', function () {
    $response = $this->get('/about');
    $response->assertSee('About Pae');
});
