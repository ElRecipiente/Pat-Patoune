<?php
// src/Scheduler/Handler/SendDailySalesReportsHandler.php
namespace App\Scheduler\Handler;

use App\Scheduler\Message\SendDailySalesReports;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendDailySalesReportsHandler
{
    public function __invoke(SendDailySalesReports $message)
    {
        // ... do some work to send the report to the customers
    }
}