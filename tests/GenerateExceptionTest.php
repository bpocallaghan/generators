<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateExceptionTest extends TestCase
{
    /** @test */
    public function generate_exception()
    {
        $this->artisan('generate:exception UserIsNotLoggedIn');
        $this->assertFileExists('app/Exceptions/UserIsNotLoggedIn.php');
    }
}