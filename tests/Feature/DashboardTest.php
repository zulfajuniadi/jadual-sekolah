<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /** @test */
    public function it_cannot_access_dashboard_without_login()
    {
        $this->get('app')
            ->assertRedirect('app/login');
    }
}
