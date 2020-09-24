<?php

namespace Bpocallaghan\Generators\Tests;

class SeederCommandTest extends TestCase
{
    /** @test */
    public function generate_seeder()
    {
        $this->artisan('generate:seeder post');
        $this->assertFileExists('database/seeders/PostsTableSeeder.php');

        $this->artisan('generate:seeder UserTableSeeder');
        $this->assertFileExists('database/seeders/UsersTableSeeder.php');
    }
}
