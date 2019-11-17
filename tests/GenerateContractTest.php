<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateContractTest extends TestCase
{
    /** @test */
    public function generate_contract()
    {
        $this->artisan('generate:contract Cache');
        $this->assertFileExists('app/Contracts/CacheRepository.php');

        $this->artisan('generate:contract PostsRepository');
        $this->assertFileExists('app/Contracts/PostsRepository.php');
    }
}