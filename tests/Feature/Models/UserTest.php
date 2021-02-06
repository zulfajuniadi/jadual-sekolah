<?php

namespace Tests\Feature\Models;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_public_slug_for_created_user()
    {
        $user = UserFactory::new()->create([
            'name' => 'Jasdy Syarman',
        ]);

        $this->assertNotNull($user->public_slug);
        $this->assertTrue(Str::startsWith($user->public_slug, Str::slug($user->name)));
    }
}
