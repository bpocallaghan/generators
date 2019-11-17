<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateRepositoryTest extends TestCase
{
    /** @test */
    public function generate_repository()
    {
        $this->artisan('generate:repository Posts');
        $this->assertFileExists('app/Repositories/PostsRepository.php');

        $this->artisan('generate:repository TagsRepository');
        $this->assertFileExists('app/Repositories/TagsRepository.php');
    }
}