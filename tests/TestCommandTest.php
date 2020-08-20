<?php

namespace Bpocallaghan\Generators\Tests;

class TestCommandTest extends TestCase
{
    /** @test */
    public function generate_test()
    {
        $this->artisan('generate:test UserCanLogin');
        $this->assertFileExists('tests/Feature/UserCanLoginTest.php');

        $this->artisan('generate:test Post --unit');
        $this->assertFileExists('tests/Unit/PostTest.php');

        $this->artisan('generate:test Billing/InvoiceTest --unit');
        $this->assertFileExists('tests/Unit/Billing/InvoiceTest.php');
    }
}
