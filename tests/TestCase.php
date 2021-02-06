<?php

namespace Tests;

use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Define test database seeder.
     *
     * @var string
     */
    public $seeder = TestDatabaseSeeder::class;
}
