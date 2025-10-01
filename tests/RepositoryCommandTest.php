<?php

namespace Bpocallaghan\Generators\Tests;

class RepositoryCommandTest extends TestCase
{
    public function test_generate_repository()
    {
        $this->artisan('generate:repository Post');
        $this->assertFileExists('app/Repositories/PostRepository.php');

        $this->artisan('generate:repository TagsRepository');
        $this->assertFileExists('app/Repositories/TagsRepository.php');
    }

    public function test_generate_repository_with_option_test()
    {
        $this->artisan('generate:repository Foo --test');
        $this->assertFileExists('app/Repositories/FooRepository.php');
        $this->assertFileExists('tests/Unit/Repositories/FooRepositoryTest.php');
    }

    public function test_generate_repository_with_contract_stub()
    {
        $this->artisan('generate:repository BookingRepository --contract');
        $this->assertFileExists('app/Repositories/BookingRepository.php');
    }
}
