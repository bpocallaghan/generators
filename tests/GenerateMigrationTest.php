<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateMigrationTest extends TestCase
{
    /** @test */
    public function generate_migration()
    {
        $this->artisan('generate:migration create_users_table');
        $this->assertFileExists('app/Models/User.php');
        $this->assertFileExists('database/migrations/'. date('Y_m_d_His') .'_create_users_table.php');

        $this->artisan('generate:migration create_posts_table');
        $this->assertFileExists('app/Models/Post.php');
        $this->assertFileExists('database/migrations/'. date('Y_m_d_His') .'_create_posts_table.php');
    }
}
