<?php

namespace Tests\Browser;

use App\Models\Child;
use App\Models\Scopes\MyChildScope;
use Database\Factories\ChildFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ChildrenTest extends DuskTestCase
{
    /** @test */
    public function it_can_list_children_by_user()
    {
        $secondaryUser = UserFactory::new()->create();
        $secondaryChild = ChildFactory::new()->guardian($secondaryUser)->create();

        $this->browse(function (Browser $browser) use ($secondaryUser, $secondaryChild) {
            $browser->loginAs($secondaryUser, backpack_guard_name())
                    ->visit('/app/child')
                    ->waitForText('Showing 1 to 1 of 1 entries.', 25)
                    ->assertSee($secondaryChild->name)
                    ->assertDontSee('Naufal')
                    ->assertDontSee('Sarah')
                    ->assertDontSee('Syafiq');

            $browser->logout(backpack_guard_name());
        });
    }

    /** @test */
    public function it_can_show_empty_list_for_user_without_children()
    {
        $secondaryUser = UserFactory::new()->create();

        $this->browse(function (Browser $browser) use ($secondaryUser) {
            $browser->loginAs($secondaryUser, backpack_guard_name())
                    ->visit('/app/child')
                    ->waitForText('No entries.', 25)
                    ->assertSee('No data available in table')
                    ->assertDontSee('Naufal')
                    ->assertDontSee('Sarah')
                    ->assertDontSee('Syafiq');

            $browser->logout(backpack_guard_name());
        });
    }

    /** @test */
    public function it_can_create_children_for_a_user()
    {
        $secondaryUser = UserFactory::new()->create();

        $this->browse(function (Browser $browser) use ($secondaryUser) {
            $browser->loginAs($secondaryUser, backpack_guard_name())
                    ->visit('/app/child')
                    ->waitForText('No entries.', 25)
                    ->assertSee('No data available in table')
                    ->clickLink('Tambah Anak')
                    ->waitForText('Add Anak', 25)
                    ->waitForText('Save and back', 25)
                    ->type('name', 'Odin Hassan')
                    ->press('Save and back')
                    ->waitForText('Showing 1 to 1 of 1 entries.', 25)
                    ->assertSee('Odin Hassan');

            $browser->logout(backpack_guard_name());
        });

        $this->assertDatabaseHas('children', [
            'user_id' => $secondaryUser->getKey(),
            'name' => 'Odin Hassan',
        ]);
    }

    /** @test */
    public function it_cannot_create_children_for_a_user_without_a_name()
    {
        $secondaryUser = UserFactory::new()->create();

        $this->browse(function (Browser $browser) use ($secondaryUser) {
            $browser->loginAs($secondaryUser, backpack_guard_name())
                    ->visit('/app/child')
                    ->waitForText('No entries.', 25)
                    ->assertSee('No data available in table')
                    ->clickLink('Tambah Anak')
                    ->waitForText('Add Anak', 25)
                    ->waitForText('Save and back', 25)
                    ->press('Save and back')
                    ->waitFor('.invalid-feedback', 25)
                    ->assertSee('The name field is required.');

            $browser->logout(backpack_guard_name());
        });
    }

    /** @test */
    public function it_can_update_children_by_user()
    {
        $secondaryUser = UserFactory::new()->create();
        $secondaryChild = ChildFactory::new()->guardian($secondaryUser)->create();

        $this->browse(function (Browser $browser) use ($secondaryUser, $secondaryChild) {
            $browser->loginAs($secondaryUser, backpack_guard_name())
                    ->visit('/app/child')
                    ->waitForText('Showing 1 to 1 of 1 entries.', 25)
                    ->assertSee($secondaryChild->name)
                    ->clickLink('Kemaskini')
                    ->waitForText('Edit Anak', 25)
                    ->waitForText('Save and back', 25)
                    ->type('name', 'Odin Hassan')
                    ->press('Save and back')
                    ->waitForText('Showing 1 to 1 of 1 entries.', 25)
                    ->assertSee('Odin Hassan');

            $browser->logout(backpack_guard_name());
        });

        $this->assertDatabaseHas('children', [
            'user_id' => $secondaryUser->getKey(),
            'name' => 'Odin Hassan',
        ]);
    }

    /** @test */
    public function it_can_remove_children_by_user()
    {
        $secondaryUser = UserFactory::new()->create();
        $secondaryChild = ChildFactory::new()->guardian($secondaryUser)->create();

        $this->browse(function (Browser $browser) use ($secondaryUser, $secondaryChild) {
            $browser->loginAs($secondaryUser, backpack_guard_name())
                    ->visit('/app/child')
                    ->waitForText('Showing 1 to 1 of 1 entries.', 25)
                    ->assertSee($secondaryChild->name)
                    ->clickLink('Hapus')
                    ->elsewhereWhenAvailable('.swal-modal', function (Browser $browser) {
                        $browser->assertSee('Perhatian')
                            ->assertSee('Adakah anda ingin menghapuskan rekod ini?')
                            ->press('Hapus');
                    })
                    ->waitForText('No entries.', 25)
                    ->assertSee('No data available in table');

            $browser->logout(backpack_guard_name());
        });

        $this->assertSame(0, Child::withoutGlobalScope(MyChildScope::class)->where('user_id', '=', $secondaryUser->getKey())->count());
    }


    /** @test */
    public function it_doesnt_remove_children_by_user_if_cancel_on_modal()
    {
        $secondaryUser = UserFactory::new()->create();
        $secondaryChild = ChildFactory::new()->guardian($secondaryUser)->create();

        $this->browse(function (Browser $browser) use ($secondaryUser, $secondaryChild) {
            $browser->loginAs($secondaryUser, backpack_guard_name())
                    ->visit('/app/child')
                    ->waitForText('Showing 1 to 1 of 1 entries.', 25)
                    ->assertSee($secondaryChild->name)
                    ->clickLink('Hapus')
                    ->elsewhereWhenAvailable('.swal-modal', function (Browser $browser) {
                        $browser->assertSee('Perhatian')
                            ->assertSee('Adakah anda ingin menghapuskan rekod ini?')
                            ->press('Batal');
                    })
                    ->waitForText('Showing 1 to 1 of 1 entries.', 25)
                    ->assertSee($secondaryChild->name);

            $browser->logout(backpack_guard_name());
        });

        $this->assertSame(1, Child::withoutGlobalScope(MyChildScope::class)->where('user_id', '=', $secondaryUser->getKey())->count());
    }
}
