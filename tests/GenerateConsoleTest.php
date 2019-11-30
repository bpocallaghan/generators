<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateConsoleTest extends TestCase
{
    /** @test */
    public function generate_console()
    {
        $this->artisan('generate:console SendEmails');
        $this->assertFileExists('app/Console/Commands/SendEmails.php');
    }
}