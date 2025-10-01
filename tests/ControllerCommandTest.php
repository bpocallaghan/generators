<?php

namespace Bpocallaghan\Generators\Tests;

class ControllerCommandTest extends TestCase
{
    public function test_generate_controller()
    {
        $this->artisan('generate:controller test');
        $this->assertFileExists('app/Http/Controllers/TestController.php');
    }

    public function test_uppercase_file_name()
    {
        $this->artisan('generate:controller foo.bar');
        $this->assertFileExists('app/Http/Controllers/Foo/BarController.php');

        $this->artisan('generate:controller fooBar');
        $this->assertFileExists('app/Http/Controllers/FooBarController.php');
    }

    public function test_option_plain_stub()
    {
        $this->artisan('generate:controller plain --plain');
        $this->assertFileExists('app/Http/Controllers/PlainController.php');
    }

    public function test_do_not_include_controller_suffix_if_already_in_name()
    {
        $this->artisan('generate:controller SuffixController');
        $this->assertFileExists('app/Http/Controllers/SuffixController.php');
    }

    public function test_generate_controller_with_option_test()
    {
        $this->artisan('generate:controller foo --test');
        $this->assertFileExists('app/Http/Controllers/FooController.php');
        $this->assertFileExists('tests/Feature/Controllers/FooControllerTest.php');
    }
}
