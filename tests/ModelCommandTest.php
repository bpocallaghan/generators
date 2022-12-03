<?php

namespace Bpocallaghan\Generators\Tests;

class ModelCommandTest extends TestCase
{
    /** @test */
    public function generate_model()
    {
        $this->artisan('generate:model test');
        $this->assertFileExists('app/Models/Test.php');

        $this->artisan('generate:model foo');
        $this->assertFileExists('app/Models/Foo.php');

        $this->artisan('generate:model foo.bar');
        $this->assertFileExists('app/Models/Bar.php');

        $this->artisan('generate:model plain --plain');
        $this->assertFileExists('app/Models/Plain.php');

        $this->artisan('generate:model foo --force');
        $this->assertFileExists('app/Models/Foo.php');
    }

    /** @test */
    public function generate_model_with_migration()
    {
        $this->artisan('generate:model foo --migration');
        $this->assertFileExists('app/Models/Foo.php');
        $this->assertFileExists('database/migrations/'. date('Y_m_d_His') .'_create_foos_table.php');

        $this->artisan('generate:model UserComment --migration');
        $this->assertFileExists('app/Models/UserComment.php');
        $this->assertFileExists('database/migrations/'. date('Y_m_d_His') .'_create_user_comments_table.php');
    }

    /** @test */
    public function generate_model_with_option_factory()
    {
        $this->artisan('generate:model Comment --factory');
        $this->assertFileExists('app/Models/Comment.php');
        $this->assertFileExists('database/factories/CommentFactory.php');
    }

    /** @test */
    public function generate_model_with_option_test()
    {
        $this->artisan('generate:model Post --test');
        $this->assertFileExists('app/Models/Post.php');
        $this->assertFileExists('tests/Unit/Models/PostTest.php');
    }
}
