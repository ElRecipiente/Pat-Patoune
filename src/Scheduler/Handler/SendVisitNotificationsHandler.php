<?php 
// src/Scheduler/Handler/SendVisitNotificationsHandler.php
namespace App\Scheduler\Handler;

use App\Repository\VisitRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;
use App\Scheduler\Message\SendVisitNotifications;

#[AsMessageHandler]
class SendVisitNotificationsHandler
{
    private $visitRepository;
    private $mailer;

    public function __construct(VisitRepository $visitRepository, MailerInterface $mailer)
    {
        $this->visitRepository = $visitRepository;
        $this->mailer = $mailer;
    }

    public function __invoke(SendVisitNotifications $message)
    {
        $visitsToNotify = $this->visitRepository->findVisitToNotify();
        $emailDetails = [];

        foreach ($visitsToNotify as $index => $visit) {
            $user = $visit->getAnimal()->getUser();
            $animal = $visit->getAnimal();

            $email = (new Email())
                ->from('pat@patpatoune.com')
                ->to($user->getEmail())
                ->subject(sprintf(
                    'Rappel de la vaccination de %s le %s',
                    $animal->getName(),
                    $visit->getVisitDate()->format('d-m-Y')
                ))
                ->html(sprintf(
                    '<p>Bonjour %s,</p><p>Voici un rappel pour la visite de votre animal %s prévue le %s.</p>',
                    $user->getFirstname(),
                    $animal->getName(),
                    $visit->getVisitDate()->format('Y-m-d H:i')
                ));

            $this->mailer->send($email);

            $emailDetails[] = sprintf(
                "Email envoyé à %s (%s) pour l'animal %s, visite prévue le %s.",
                $user->getFirstname() . ' ' . $user->getLastname(),
                $user->getEmail(),
                $animal->getName(),
                $visit->getVisitDate()->format('Y-m-d H:i')
            );

            if ($index < count($visitsToNotify) - 1) {
                sleep(1);
            }
        }
    }
}
