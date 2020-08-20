<?php

namespace Bpocallaghan\Generators\Tests;

class ViewCommandTest extends TestCase
{
    /** @test */
    public function generate_view()
    {
        $this->artisan('generate:view view');
        $this->assertFileExists('resources/views/view.blade.php');

        $this->artisan('generate:view foo.bar');
        $this->assertFileExists('resources/views/foo/bar.blade.php');

        $this->artisan('generate:view foo --stub=view_show');
        $this->assertFileExists('resources/views/foo.blade.php');

        $this->artisan('generate:view foo --name=foo_bar');
        $this->assertFileExists('resources/views/foo/foo_bar.blade.php');
    }
}
