<?php
// src/Scheduler/Message/SendDailySalesReports.php
namespace App\Scheduler\Message;

class SendDailySalesReports
{
    public function __construct(private int $id) {}

    public function getId(): void
    {
        print 'hello';
    }
}