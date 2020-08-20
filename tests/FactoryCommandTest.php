<?php

namespace Bpocallaghan\Generators\Tests;

class FactoryCommandTest extends TestCase
{
    /** @test */
    public function generate_factory()
    {
        $this->artisan('generate:factory Post');
        $this->assertFileExists('database/factories/PostFactory.php');
    }
}
