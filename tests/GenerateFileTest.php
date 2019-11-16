<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateFileTest extends TestCase
{
    /** @test */
    public function generate_file()
    {
        $this->artisan('generate:file test');

        $this->assertFileExists('resources/views/test.blade.php');
    }
}
