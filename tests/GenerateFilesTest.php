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
}
