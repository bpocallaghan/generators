<?php

namespace Bpocallaghan\Generators\Tests;

class NotificationCommandTest extends TestCase
{
    /** @test */
    public function generate_notification()
    {
        $this->artisan('generate:notification ContractUsSubmitted');
        $this->assertFileExists('app/Notifications/ContractUsSubmitted.php');

        $this->artisan('generate:notification Admin/UserRegistered');
        $this->assertFileExists('app/Notifications/Admin/UserRegistered.php');
    }
}
