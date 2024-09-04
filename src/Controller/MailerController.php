<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VisitRepository;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailer = new Mailer($transport);
    
        $email = (new Email())
            ->from('pat@patpatoune.com')
            ->to('client@gmail.com')
            ->subject('Rappel de la vaccination de votre bestiole')
            ->html('<p>Bonjour, voici le rendez-vous de ...</p>');
    
        $mailer->send($email);
    
        return new Response('Email envoyé.');
    }
}
