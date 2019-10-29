<?php

namespace Bpocallaghan\Generators\Tests;

use Illuminate\Support\Str;

class GenerateFilesTest extends TestCase
{
    /** @test */
    public function generate_default_file()
    {
        $this->artisan('generate:file test');

        $this->assertFileExists('resources/views/test.blade.php');
    }
}
