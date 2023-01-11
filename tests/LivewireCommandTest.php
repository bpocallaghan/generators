<?php

namespace Bpocallaghan\Generators\Tests;

class LivewireCommandTest extends TestCase
{
    /** @test */
    public function generate_livewire()
    {
        $this->artisan('generate:livewire foo');
        $this->assertFileExists('app/Http/Livewire/Foo.php');
        $this->assertFileExists('resources/views/livewire/foo.blade.php');

        $this->artisan('generate:livewire Bar');
        $this->assertFileExists('app/Http/Livewire/Bar.php');
        $this->assertFileExists('resources/views/livewire/bar.blade.php');

        $this->artisan('generate:livewire FooBar');
        $this->assertFileExists('app/Http/Livewire/FooBar.php');
        $this->assertFileExists('resources/views/livewire/foo-bar.blade.php');

        $this->artisan('generate:livewire Foo/Bar');
        $this->assertFileExists('app/Http/Livewire/Foo/Bar.php');
        $this->assertFileExists('resources/views/livewire/foo/bar.blade.php');

        $this->artisan('generate:livewire folder.foo');
        $this->assertFileExists('app/Http/Livewire/Folder/Foo.php');
        $this->assertFileExists('resources/views/livewire/folder/foo.blade.php');

        $this->artisan('generate:livewire folder.foo-bar');
        $this->assertFileExists('app/Http/Livewire/Folder/FooBar.php');
        $this->assertFileExists('resources/views/livewire/folder/foo-bar.blade.php');
    }

    /** @test */
    public function generate_livewire_test_option()
    {
        $this->artisan('generate:livewire Foo --test');
        $this->assertFileExists('app/Http/Livewire/Foo.php');
        $this->assertFileExists('resources/views/livewire/foo.blade.php');
        $this->assertFileExists('tests/Feature/Livewire/FooTest.php');
    }

    /** @test */
    public function generate_livewire_request_option()
    {
        $this->artisan('generate:livewire Foo/Bar/Baz --request');
        $this->assertFileExists('app/Http/Livewire/Foo/Bar/Baz.php');
        $this->assertFileExists('resources/views/livewire/foo/bar/baz.blade.php');
        $this->assertFileExists('app/Http/Requests/Foo/Bar/BazRequest.php');
    }
}
