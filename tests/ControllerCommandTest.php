<?php

namespace Bpocallaghan\Generators\Tests;

class ControllerCommandTest extends TestCase
{
    /** @test */
    public function generate_controller()
    {
        $this->artisan('generate:controller test');
        $this->assertFileExists('app/Http/Controllers/TestController.php');

        $this->artisan('generate:controller foo.bar');
        $this->assertFileExists('app/Http/Controllers/Foo/BarController.php');

        $this->artisan('generate:controller fooBar');
        $this->assertFileExists('app/Http/Controllers/FooBarController.php');

        $this->artisan('generate:controller plain --plain');
        $this->assertFileExists('app/Http/Controllers/PlainController.php');

        $this->artisan('generate:controller SuffixController');
        $this->assertFileExists('app/Http/Controllers/SuffixController.php');
    }
}
