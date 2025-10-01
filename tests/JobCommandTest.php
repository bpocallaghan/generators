<?php

namespace Bpocallaghan\Generators\Tests;

class JobCommandTest extends TestCase
{
    public function test_generate_job()
    {
        $this->artisan('generate:job SendReminderEmail');
        $this->assertFileExists('app/Jobs/SendReminderEmail.php');
    }

    public function test_generate_job_with_option_test()
    {
        $this->artisan('generate:job ProductPaid --test');
        $this->assertFileExists('app/Jobs/ProductPaid.php');
        $this->assertFileExists('tests/Unit/Jobs/ProductPaidTest.php');
    }
}
