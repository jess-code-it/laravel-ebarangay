<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    public function test_landing_page_shows_public_navigation(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('eBarangay');
        $response->assertSee('/AboutUs', false);
        $response->assertSee('/FAQ', false);
    }

    public function test_about_page_renders(): void
    {
        $response = $this->get('/AboutUs');

        $response->assertOk();
        $response->assertSee('About eBarangay');
    }

    public function test_faq_page_renders(): void
    {
        $response = $this->get('/FAQ');

        $response->assertOk();
        $response->assertSee('Frequently asked questions');
    }
}
