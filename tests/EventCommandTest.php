<?php

namespace Bpocallaghan\Generators\Tests;

class EventCommandTest extends TestCase
{
    public function test_generate_events()
    {
        $this->artisan('generate:event InvoiceWasPaid');
        $this->assertFileExists('app/Events/InvoiceWasPaid.php');

        $this->artisan('generate:listener NotifyUserAboutPayment --event=InvoiceWasPaid');
        $this->assertFileExists('app/Listeners/NotifyUserAboutPayment.php');
    }
}
