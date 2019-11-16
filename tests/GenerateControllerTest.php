<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateControllerTest extends TestCase
{
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
}
