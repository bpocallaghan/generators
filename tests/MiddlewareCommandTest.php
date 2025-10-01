<?php

namespace Bpocallaghan\Generators\Tests;

class MiddlewareCommandTest extends TestCase
{
    public function test_generate_middleware()
    {
        $this->artisan('generate:middleware AuthenticateAdmin');
        $this->assertFileExists('app/Http/Middleware/AuthenticateAdmin.php');
    }
}
