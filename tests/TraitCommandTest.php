<?php

namespace Bpocallaghan\Generators\Tests;

class TraitCommandTest extends TestCase
{
    public function test_generate_trait()
    {
        $this->artisan('generate:trait Traits/UserHelper');
        $this->assertFileExists('app/Traits/UserHelper.php');

        $this->artisan('generate:trait Http/Controllers/Traits/PhotoHelper');
        $this->assertFileExists('app/Http/Controllers/Traits/PhotoHelper.php');
    }

    public function test_generate_trait_with_option_test()
    {
        $this->artisan('generate:trait Traits/RoleHelper --test');
        $this->assertFileExists('app/Traits/RoleHelper.php');
        $this->assertFileExists('tests/Unit/Traits/RoleHelperTest.php');
    }
}
