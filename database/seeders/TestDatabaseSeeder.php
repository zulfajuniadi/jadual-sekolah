<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = UserFactory::new()->create([
            'name' => 'Zulfa Juniadi',
            'email' => 'zulfajuniadi@gmail.com',
        ]);
    }
}
