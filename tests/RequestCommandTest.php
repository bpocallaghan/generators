<?php

namespace Bpocallaghan\Generators\Tests;

class RequestCommandTest extends TestCase
{
    /** @test */
    public function generate_request()
    {
        $this->artisan('generate:request PostStore');
        $this->assertFileExists('app/Http/Requests/PostStoreRequest.php');
    }
}
