<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{
    /** @test */
    public function it_cannot_access_dashboard_without_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app')
                    ->assertPathIs('/app/login');
        });
    }

    /** @test */
    public function it_can_access_dashboard_via_a_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1), backpack_guard_name())
                    ->visit('/app/dashboard')
                    ->waitForText('Jadual Hari', 25)
                    ->assertSee('Jadual Hari '.$this->daysOfWeek()[now()->dayOfWeek])
                    ->assertSee('Naufal')
                    ->assertSee('Sarah')
                    ->assertSee('Syafiq');
        });
    }

    /** @test */
    public function it_can_access_timetime_on_dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1), backpack_guard_name())
                    ->visit('/app/dashboard')
                    ->press('Isnin')
                    ->waitForText('Jadual Hari Isnin', 25)
                    ->within('@1-schedule', function (Browser $browser) {
                        $browser->assertSee('1:30PM - 3:30PM');
                    });
        });
    }

    /** @test */
    public function it_can_access_public_timetable()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($user = User::find(1), backpack_guard_name())
                    ->visit('/app/dashboard')
                    ->waitForText('Jadual Hari', 25)
                    ->assertSee('Simpan pautan ini dalam pelayar anak anda:')
                    ->assertSee(url("/s/{$user->public_slug}"))
                    ->assertSee(url("/c/{$user->public_slug}.ical"));

            $browser->click('@public-schedule')
                ->assertPathIs("/s/{$user->public_slug}")
                ->waitForText('Jadual Hari', 25)
                ->assertSee('Jadual Hari '.$this->daysOfWeek()[now()->dayOfWeek])
                ->assertSee('Naufal')
                ->assertSee('Sarah')
                ->assertSee('Syafiq');
        });
    }

    /**
     * List of days of week.
     *
     * @return array
     */
    protected function daysOfWeek()
    {
        return ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu', 'Ahad'];
    }
}
