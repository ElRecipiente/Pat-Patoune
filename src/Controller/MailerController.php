<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VisitRepository;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function sendEmail(VisitRepository $visitRepository): Response
    {
        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailer = new Mailer($transport);

        // Récupérer les visites à notifier
        $visitsToNotify = $visitRepository->findVisitToNotify();
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

            $mailer->send($email);

            // Ajouter les détails de l'email dans la liste
            $emailDetails[] = sprintf(
                "Email envoyé à %s (%s) pour l'animal %s, visite prévue le %s.",
                $user->getFirstname() . ' ' . $user->getLastname(),
                $user->getEmail(),
                $animal->getName(),
                $visit->getVisitDate()->format('Y-m-d H:i')
            );

            // Ajouter une pause d'une seconde après chaque envoi
            if ($index < count($visitsToNotify) - 1) {
                sleep(1); // Pause de 1 seconde pour éviter d'être consideré comme spam
            }
        }

        // Construire la réponse avec les détails des emails envoyés
        $responseMessage = empty($emailDetails) 
            ? 'Aucun email envoyé.' 
            : implode("\n", $emailDetails);

        return new Response(nl2br($responseMessage));
    }
}
