<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /** @test */
    public function it_can_register_a_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/register')
                    ->waitForText('Pendaftaran', 25)
                    ->type('name', 'Mior Muhammad Zaki')
                    ->type('email', 'crynobone@gmail.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Daftar')
                    ->waitForText('Jadual Hari', 25)
                    ->assertPathIs('/app/dashboard');

            $browser->logout(backpack_guard_name());
        });
    }

    /** @test */
    public function it_cannot_register_a_user_with_incorrect_password_confirmation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/register')
                    ->waitForText('Pendaftaran', 25)
                    ->type('name', 'Mior Muhammad Zaki')
                    ->type('email', 'crynobone@gmail.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'foobar')
                    ->press('Daftar')
                    ->waitFor('.invalid-feedback')
                    ->assertSee('The password confirmation does not match.');
        });
    }

    /** @test */
    public function it_cannot_register_a_user_with_conflicting_email_address()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/register')
                    ->waitForText('Pendaftaran', 25)
                    ->type('name', 'Fake Zulfa')
                    ->type('email', 'zulfajuniadi@gmail.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Daftar')
                    ->waitFor('.invalid-feedback')
                    ->assertSee('The email has already been taken.');
        });
    }

    /** @test */
    public function it_cannot_register_a_user_without_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/register')
                    ->waitForText('Pendaftaran', 25)
                    ->type('name', 'Mior Muhammad Zaki')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Daftar')
                    ->waitFor('.invalid-feedback')
                    ->assertSee('The email field is required.');
        });
    }

    /** @test */
    public function it_cannot_register_a_user_without_name()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/register')
                    ->waitForText('Pendaftaran', 25)
                    ->type('email', 'crynobone@gmail.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('Daftar')
                    ->waitFor('.invalid-feedback')
                    ->assertSee('The name field is required.');
        });
    }


    /** @test */
    public function it_cannot_register_a_user_without_password()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/register')
                    ->waitForText('Pendaftaran', 25)
                    ->type('name', 'Mior Muhammad Zaki')
                    ->type('email', 'crynobone@gmail.com')
                    ->press('Daftar')
                    ->waitFor('.invalid-feedback')
                    ->assertSee('The password field is required.');
        });
    }
}
