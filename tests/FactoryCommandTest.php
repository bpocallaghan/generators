<?php

namespace Bpocallaghan\Generators\Tests;

class FactoryCommandTest extends TestCase
{
    public function test_generate_factory()
    {
        $this->artisan('generate:factory Post');
        $this->assertFileExists('database/factories/PostFactory.php');
    }
}
