<?php

namespace Bpocallaghan\Generators\Tests;

class TestCommandTest extends TestCase
{
    /** @test */
    public function generate_test()
    {
        $this->artisan('generate:test Controllers/UsersController');
        $this->assertFileExists('tests/Feature/Controllers/UsersControllerTest.php');

        $this->artisan('generate:test Models/Post --unit');
        $this->assertFileExists('tests/Unit/Models/PostTest.php');

        $this->artisan('generate:test Traits/InvoiceTest --unit');
        $this->assertFileExists('tests/Unit/Traits/InvoiceTest.php');
    }
}
