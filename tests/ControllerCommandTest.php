<?php

namespace Bpocallaghan\Generators\Tests;

class ControllerCommandTest extends TestCase
{
    /** @test */
    public function generate_controller()
    {
        $this->artisan('generate:controller test');
        $this->assertFileExists('app/Http/Controllers/TestController.php');
    }

    /** @test */
    public function uppercase_file_name()
    {
        $this->artisan('generate:controller foo.bar');
        $this->assertFileExists('app/Http/Controllers/Foo/BarController.php');

        $this->artisan('generate:controller fooBar');
        $this->assertFileExists('app/Http/Controllers/FooBarController.php');
    }

    /** @test */
    public function option_plain_stub()
    {
        $this->artisan('generate:controller plain --plain');
        $this->assertFileExists('app/Http/Controllers/PlainController.php');
    }

    /** @test */
    public function do_not_include_controller_suffix_if_already_in_name()
    {
        $this->artisan('generate:controller SuffixController');
        $this->assertFileExists('app/Http/Controllers/SuffixController.php');
    }

    /** @test */
    public function generate_controller_with_option_test()
    {
        $this->artisan('generate:controller foo --test');
        $this->assertFileExists('app/Http/Controllers/FooController.php');
        $this->assertFileExists('tests/Feature/Controllers/FooControllerTest.php');
    }
}
