<?php

namespace Bpocallaghan\Generators\Tests;

class ResourceCommandTest extends TestCase
{
    /** @test */
    public function generate_resource()
    {
        $this->artisan('generate:resource post')
            ->expectsQuestion('Create a Post model?', true)
            ->expectsQuestion('Create crud views for the post resource?', true)
            ->expectsQuestion('Create a controller (PostsController) for the post resource?', true)
            ->expectsQuestion('Create a migration (create_posts_table) for the post resource?', true)
            ->expectsQuestion('Create a seeder (PostsTableSeeder) for the post resource?', true)
            ->expectsQuestion('Create a test (PostTest) for the post resource?', true)
            ->expectsQuestion('Create a factory (PostFactory) for the post resource?', true)
            ->expectsQuestion('Migrate the database?', false)
            ->expectsQuestion('Run \'composer dump-autoload\'?', false)
            ->assertExitCode(0);

        $this->assertFileExists('app/Models/Post.php');
        $this->assertFileExists('resources/views/posts/create_edit.blade.php');
        $this->assertFileExists('resources/views/posts/index.blade.php');
        $this->assertFileExists('resources/views/posts/show.blade.php');
        $this->assertFileExists('app/Http/Controllers/PostsController.php');
        $this->assertFileExists('database/migrations/'. date('Y_m_d_His') .'_create_posts_table.php');
        $this->assertFileExists('database/factories/PostFactory.php');
        $this->assertFileExists('database/seeders/PostsTableSeeder.php');
        $this->assertFileExists('tests/Feature/PostsTest.php');
        $this->assertFileExists('tests/Unit/PostTest.php');
    }

    /** @test */
    public function generate_resource_with_admin_controller_stub()
    {
        $this->artisan('generate:resource articles --controller=admin')
            ->expectsQuestion('Create a Article model?', true)
            ->expectsQuestion('Create crud views for the article resource?', true)
            ->expectsQuestion('Create a controller (ArticlesController) for the article resource?', true)
            ->expectsQuestion('Create a migration (create_articles_table) for the article resource?', true)
            ->expectsQuestion('Create a seeder (ArticlesTableSeeder) for the article resource?', true)
            ->expectsQuestion('Create a test (ArticleTest) for the article resource?', true)
            ->expectsQuestion('Create a factory (ArticleFactory) for the article resource?', true)
            ->expectsQuestion('Migrate the database?', false)
            ->expectsQuestion('Run \'composer dump-autoload\'?', false)
            ->assertExitCode(0);

        $this->assertFileExists('app/Models/Article.php');
        $this->assertFileExists('resources/views/articles/create_edit.blade.php');
        $this->assertFileExists('resources/views/articles/index.blade.php');
        $this->assertFileExists('resources/views/articles/show.blade.php');
        $this->assertFileExists('app/Http/Controllers/ArticlesController.php');
        $this->assertFileExists('database/migrations/'. date('Y_m_d_His') .'_create_articles_table.php');
        $this->assertFileExists('database/factories/ArticleFactory.php');
        $this->assertFileExists('database/seeders/ArticlesTableSeeder.php');
        $this->assertFileExists('tests/Feature/ArticlesTest.php');
        $this->assertFileExists('tests/Unit/ArticleTest.php');
    }

    /** @test */
    public function generate_resource_with_bootstrap_4_stubs()
    {
        $this->artisan('generate:resource articles --view=b3')
            ->expectsQuestion('Create a Article model?', false)
            ->expectsQuestion('Create crud views for the article resource?', true)
            ->expectsQuestion('Create a controller (ArticlesController) for the article resource?', false)
            ->expectsQuestion('Create a migration (create_articles_table) for the article resource?', false)
            ->expectsQuestion('Create a seeder (ArticlesTableSeeder) for the article resource?', false)
            ->expectsQuestion('Create a test (ArticleTest) for the article resource?', false)
            ->expectsQuestion('Create a factory (ArticleFactory) for the article resource?', false)
            ->expectsQuestion('Migrate the database?', false)
            ->expectsQuestion('Run \'composer dump-autoload\'?', false)
            ->assertExitCode(0);

        $this->assertFileExists('resources/views/articles/create_edit.blade.php');
        $this->assertFileExists('resources/views/articles/index.blade.php');
        $this->assertFileExists('resources/views/articles/show.blade.php');
    }
}
