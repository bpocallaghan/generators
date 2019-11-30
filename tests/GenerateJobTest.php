<?php

namespace Bpocallaghan\Generators\Tests;

class GenerateJobTest extends TestCase
{
    /** @test */
    public function generate_job()
    {
        $this->artisan('generate:job SendReminderEmail');
        $this->assertFileExists('app/Jobs/SendReminderEmail.php');
    }
}