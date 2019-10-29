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
}
