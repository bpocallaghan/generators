<?php

namespace Bpocallaghan\Generators\Tests;

class LivewireCommandTest extends TestCase
{
    /** @test */
    public function generate_livewire()
    {
        $this->artisan('generate:livewire foo');
        $this->assertFileExists('app/Http/Livewire/Foo.php');

        $this->artisan('generate:livewire Bar');
        $this->assertFileExists('app/Http/Livewire/Bar.php');

        $this->artisan('generate:livewire FooBar');
        $this->assertFileExists('app/Http/Livewire/FooBar.php');

        $this->artisan('generate:livewire Foo/Bar');
        $this->assertFileExists('app/Http/Livewire/Foo/Bar.php');

        $this->artisan('generate:livewire folder.foo');
        $this->assertFileExists('app/Http/Livewire/Folder/Foo.php');

        $this->artisan('generate:livewire folder.foo-bar');
        $this->assertFileExists('app/Http/Livewire/Folder/FooBar.php');
    }

    /** @test */
    public function generate_livewire_test_option()
    {
//        $this->artisan('generate:model foo --test');
//        $this->artisan('generate:model foo --request');
    }
}
