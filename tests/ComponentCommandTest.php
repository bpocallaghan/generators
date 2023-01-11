<?php

namespace Bpocallaghan\Generators\Tests;

class ComponentCommandTest extends TestCase
{
    /** @test */
    public function generate_component()
    {
        $this->artisan('generate:component foo');
        $this->assertFileExists('app/View/Components/Foo.php');
        $this->assertFileExists('resources/views/components/foo.blade.php');

        $this->artisan('generate:component Bar');
        $this->assertFileExists('app/View/Components/Bar.php');
        $this->assertFileExists('resources/views/components/bar.blade.php');

        $this->artisan('generate:component FooBar');
        $this->assertFileExists('app/View/Components/FooBar.php');
        $this->assertFileExists('resources/views/components/foo-bar.blade.php');

        $this->artisan('generate:component Foo/Bar');
        $this->assertFileExists('app/View/Components/Foo/Bar.php');
        $this->assertFileExists('resources/views/components/foo/bar.blade.php');

        $this->artisan('generate:component folder.foo');
        $this->assertFileExists('app/View/Components/Folder/Foo.php');
        $this->assertFileExists('resources/views/components/folder/foo.blade.php');

        $this->artisan('generate:component folder.foo-bar');
        $this->assertFileExists('app/View/Components/Folder/FooBar.php');
        $this->assertFileExists('resources/views/components/folder/foo-bar.blade.php');
    }

    /** @test */
    public function generate_component_test_option()
    {
        $this->artisan('generate:component Foo --test');
        $this->assertFileExists('app/View/Components/Foo.php');
        $this->assertFileExists('resources/views/components/foo.blade.php');
        $this->assertFileExists('tests/Unit/View/Components/FooTest.php');
    }
}
