<?php
// src/Scheduler/Message/SendVisitNotifications.php
namespace App\Scheduler\Message;

class SendVisitNotifications
{
    private int $visitId;

    public function __construct(int $visitId)
    {
        $this->visitId = $visitId;
    }

    public function getVisitId(): int
    {
        return $this->visitId;
    }
}
