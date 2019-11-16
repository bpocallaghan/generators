<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateModelTest extends TestCase
{
    /** @test */
    public function generate_model()
    {
        $this->artisan('generate:model test');
        $this->assertFileExists('app/Models/Test.php');

        $this->artisan('generate:model foo');
        $this->assertFileExists('app/Models/Foo.php');

        $this->artisan('generate:model foo.bar');
        $this->assertFileExists('app/Models/Bar.php');

        $this->artisan('generate:model plain --plain');
        $this->assertFileExists('app/Models/Plain.php');

        $this->artisan('generate:model foo --force');
        $this->assertFileExists('app/Models/Foo.php');
    }
}
