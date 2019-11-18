<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateTraitTest extends TestCase
{
    /** @test */
    public function generate_trait()
    {
        $this->artisan('generate:trait Traits/UserHelper');
        $this->assertFileExists('app/Traits/UserHelper.php');

        $this->artisan('generate:trait Http/Controllers/Traits/PhotoHelper');
        $this->assertFileExists('app/Http/Controllers/Traits/PhotoHelper.php');
    }
}