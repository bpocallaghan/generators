<?php

namespace Bpocallaghan\Generators\Tests;

class ContractCommandTest extends TestCase
{
    public function test_generate_contract()
    {
        $this->artisan('generate:contract Cache');
        $this->assertFileExists('app/Contracts/CacheRepository.php');

        $this->artisan('generate:contract PostsRepository');
        $this->assertFileExists('app/Contracts/PostsRepository.php');
    }
}
