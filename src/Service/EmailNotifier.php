<?php
// src/Service/EmailNotifier.php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotifier
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendVisitNotification($visit)
    {
        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($visit->getAnimal()->getUser()->getEmail())
            ->subject('Upcoming Visit Reminder')
            ->html(sprintf(
                'Reminder: You have an upcoming visit for your pet %s on %s.',
                $visit->getAnimal()->getName(),
                $visit->getVisitDate()->format('Y-m-d H:i')
            ));

        $this->mailer->send($email);
    }
}
