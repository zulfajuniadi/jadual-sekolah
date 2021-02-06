<?php

namespace Database\Seeders;

use Database\Factories\ChildFactory;
use Database\Factories\ScheduleFactory;
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
        $monday = '1';

        $guardian = UserFactory::new()->create([
            'name' => 'Zulfa Juniadi',
            'email' => 'zulfajuniadi@gmail.com',
        ]);

        $naufal = ChildFactory::new()->guardian($guardian)->create([
            'name' => 'Naufal',
            'points' => 1,
            'avatar_config' => json_decode('{"eyes": "default", "mouths": "default", "clothes": "vneck", "glasses": "none", "eyebrows": "default2", "skincolor": "d08b5b", "accesories": "none", "haircolors": "404040_262626_101010", "hairstyles": "shorthairround", "facialhairs": "none", "fabriccolors": "5199e4", "glassopacity": "0.5", "backgroundcolors": "e5fde2"}', true),
        ]);

        ScheduleFactory::new()->student($naufal)->create([
            'day' => $monday,
            'start_time' => '13:30',
            'end_time' => '15:30',
            'name' => 'ORI',
        ]);

        $sarah = ChildFactory::new()->guardian($guardian)->create([
            'name' => 'Sarah',
            'points' => 2,
            'avatar_config' => json_decode('{"eyes": "hearts", "mouths": "smile", "clothes": "overall", "glasses": "none", "eyebrows": "default2", "skincolor": "ffdbb4", "accesories": "none", "haircolors": "404040_262626_101010", "hairstyles": "longhairbob", "facialhairs": "none", "fabriccolors": "ffafb9", "glassopacity": "0.5", "backgroundcolors": "d1d0fc"}', true),
        ]);

        ScheduleFactory::new()->student($sarah)->create([
            'day' => $monday,
            'start_time' => '09:00',
            'end_time' => '10:30',
            'name' => 'SA',
        ]);

        ScheduleFactory::new()->student($sarah)->create([
            'day' => $monday,
            'start_time' => '13:30',
            'end_time' => '14:00',
            'name' => 'MT',
        ]);

        ScheduleFactory::new()->student($sarah)->create([
            'day' => $monday,
            'start_time' => '14:00',
            'end_time' => '14:30',
            'name' => 'BA'
        ]);

        ScheduleFactory::new()->student($sarah)->create([
            'day' => $monday,
            'start_time' => '15:00',
            'end_time' => '16:00',
            'name' => 'PAI'
        ]);

        $syafiq = ChildFactory::new()->guardian($guardian)->create([
            'name' => 'Syafiq',
            'points' => 1,
            'avatar_config' => json_decode('{"eyes": "default", "mouths": "serious", "clothes": "hoodie", "glasses": "old", "eyebrows": "unibrow", "skincolor": "d08b5b", "accesories": "none", "haircolors": "404040_262626_101010", "hairstyles": "shorthairdreads", "facialhairs": "none", "fabriccolors": "25557c", "glassopacity": "0.5", "backgroundcolors": "d5effd"}', true),
        ]);

        ScheduleFactory::new()->student($syafiq)->create([
            'day' => $monday,
            'start_time' => '08:30',
            'end_time' => '09:00',
            'name' => 'PJ',
        ]);

        ScheduleFactory::new()->student($syafiq)->create([
            'day' => $monday,
            'start_time' => '09:00',
            'end_time' => '09:30',
            'name' => 'BI',
        ]);

        ScheduleFactory::new()->student($syafiq)->create([
            'day' => $monday,
            'start_time' => '10:00',
            'end_time' => '11:00',
            'name' => 'PAI',
        ]);

        ScheduleFactory::new()->student($syafiq)->create([
            'day' => $monday,
            'start_time' => '14:30',
            'end_time' => '15:30',
            'name' => 'SA',
        ]);
    }
}
