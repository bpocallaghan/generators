<?php

namespace Bpocallaghan\Generators\Tests;

class MigrationCommandTest extends TestCase
{
    /** @test */
    public function generate_migration()
    {
        $this->artisan('generate:migration create_users_table');
        $this->assertFileExists('app/Models/User.php');
        $this->assertFileExists('database/migrations/'. date('Y_m_d_His') .'_create_users_table.php');

        $this->artisan('generate:migration create_user_comments_table');
        $this->assertFileExists('app/Models/UserComment.php');
        $this->assertFileExists('database/migrations/'. date('Y_m_d_His') .'_create_user_comments_table.php');
    }

    /** @test */
    public function generate_migration_pivot()
    {
        $this->artisan('generate:migration create_tags_table');
        $this->artisan('generate:migration create_posts_table');
        $this->artisan('generate:migration:pivot tags posts')->expectsQuestion("Add Many To Many Relationship in 'Tag' and 'Post' Models? [yes|no]", 'yes')->assertExitCode(0);

        $this->assertFileExists('database/migrations/'. date('Y_m_d_His') .'_create_post_tag_pivot_table.php');
    }
}
