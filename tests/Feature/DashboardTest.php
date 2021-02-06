<?php

namespace Tests\Feature;

use App\Models\User;
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

    /** @test */
    public function it_can_access_dashboard_via_a_user()
    {
        $response = $this->actingAs(User::find(1), backpack_guard_name())
            ->get('app/dashboard')
            ->assertSee('Jadual Hari {{selectedDayName}}');
    }
}
