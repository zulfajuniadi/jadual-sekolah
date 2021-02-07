<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /** @test */
    public function it_can_login_a_valid_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/login')
                ->waitForText('Log Masuk', 25)
                ->type('email', 'zulfajuniadi@gmail.com')
                ->type('password', 'password')
                ->press('Log Masuk')
                ->waitForText('Jadual Hari', 25)
                ->assertPathIs('/app/dashboard')
                ->assertAuthenticatedAs(User::find(1), backpack_guard_name());

            $browser->logout(backpack_guard_name());
        });
    }

    /** @test */
    public function it_cannot_login_an_invalid_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/login')
                ->waitForText('Log Masuk', 25)
                ->type('email', 'syafiq@gmail.com')
                ->type('password', 'password')
                ->press('Log Masuk')
                ->waitFor('.invalid-feedback', 25)
                ->assertSee('These credentials do not match our records.');
        });
    }
}
