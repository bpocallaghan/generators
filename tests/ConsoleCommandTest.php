<?php

namespace Bpocallaghan\Generators\Tests;

class ConsoleCommandTest extends TestCase
{
    /** @test */
    public function generate_console()
    {
        $this->artisan('generate:console SendEmails');
        $this->assertFileExists('app/Console/Commands/SendEmails.php');
    }

    /** @test */
    public function generate_console_with_option_test()
    {
        $this->artisan('generate:job NotifyApi --test');
        $this->assertFileExists('app/Jobs/NotifyApi.php');
        $this->assertFileExists('tests/Unit/Jobs/NotifyApiTest.php');
    }
}
