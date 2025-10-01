<?php

namespace Bpocallaghan\Generators\Tests;

class FileCommandTest extends TestCase
{
    public function test_generate_file()
    {
        $this->artisan('generate:file test');

        $this->assertFileExists('resources/views/test.blade.php');
    }
}
