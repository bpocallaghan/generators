<?php

namespace Bpocallaghan\Generators\Tests;

class ExceptionCommandTest extends TestCase
{
    public function test_generate_exception()
    {
        $this->artisan('generate:exception UserIsNotLoggedIn');
        $this->assertFileExists('app/Exceptions/UserIsNotLoggedIn.php');
    }
}
