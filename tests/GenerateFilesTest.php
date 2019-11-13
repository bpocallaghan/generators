<?php

namespace Bpocallaghan\Generators\Tests;

use Illuminate\Support\Str;

class GenerateFilesTest extends TestCase
{
    /** @test */
    public function generate_default()
    {
        $this->artisan('generate:file test');

        $this->assertFileExists('resources/views/test.blade.php');
    }

    /** @test */
    public function generate_view()
    {
        $this->artisan('generate:view view');
        $this->assertFileExists('resources/views/view.blade.php');

        $this->artisan('generate:view foo.bar');
        $this->assertFileExists('resources/views/foo/bar.blade.php');

        $this->artisan('generate:view foo --stub=view_show');
        $this->assertFileExists('resources/views/foo.blade.php');

        $this->artisan('generate:view foo --name=foo_bar');
        $this->assertFileExists('resources/views/foo/foo_bar.blade.php');
    }

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
    public function generate_controller()
    {
        $this->artisan('generate:controller test')->expectsQuestion('Run \'composer dump-autoload\'?', false)->assertExitCode(0);
        $this->assertFileExists('app/Http/Controllers/TestController.php');

        $this->artisan('generate:controller foo.bar')->expectsQuestion('Run \'composer dump-autoload\'?', false)->assertExitCode(0);
        $this->assertFileExists('app/Http/Controllers/Foo/BarController.php');

        $this->artisan('generate:controller fooBar')->expectsQuestion('Run \'composer dump-autoload\'?', false)->assertExitCode(0);
        $this->assertFileExists('app/Http/Controllers/FooBarController.php');

        $this->artisan('generate:controller plain --plain')->expectsQuestion('Run \'composer dump-autoload\'?', false)->assertExitCode(0);
        $this->assertFileExists('app/Http/Controllers/PlainController.php');

        $this->artisan('generate:controller SuffixController')->expectsQuestion('Run \'composer dump-autoload\'?', false)->assertExitCode(0);
        $this->assertFileExists('app/Http/Controllers/SuffixController.php');
    }

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
