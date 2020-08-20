<?php

namespace Bpocallaghan\Generators\Tests;

class SeedCommandTest extends TestCase
{
    /** @test */
    public function generate_seed()
    {
        $this->artisan('generate:seed post');
        $this->assertFileExists('database/seeds/PostsTableSeeder.php');

        $this->artisan('generate:seed UserTableSeeder');
        $this->assertFileExists('database/seeds/UsersTableSeeder.php');
    }
}
