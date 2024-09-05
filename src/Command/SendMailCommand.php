<?php
// src/Command/SendMailCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use App\Repository\VisitRepository;

class SendMailCommand extends Command
{
    protected static $defaultName = 'app:send-mail';

    private $mailer;
    private $visitRepository;

    public function __construct(MailerInterface $mailer, VisitRepository $visitRepository)
    {
        parent::__construct();
        $this->mailer = $mailer;
        $this->visitRepository = $visitRepository;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Envoie des emails pour les visites à notifier.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailer = new Mailer($transport);

        // Récupérer les visites à notifier
        $visitsToNotify = $this->visitRepository->findVisitToNotify();
        $emailDetails = [];

        foreach ($visitsToNotify as $index => $visit) {
            $user = $visit->getAnimal()->getUser();
            $animal = $visit->getAnimal();

            // Créer l'email
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

            // Envoyer l'email
            $mailer->send($email);

            // Ajouter les détails de l'email dans la liste
            $emailDetails[] = sprintf(
                "Email envoyé à %s (%s) pour l'animal %s, visite prévue le %s.",
                $user->getFirstname() . ' ' . $user->getLastname(),
                $user->getEmail(),
                $animal->getName(),
                $visit->getVisitDate()->format('Y-m-d H:i')
            );

            // Pause pour éviter l'envoi trop rapide
            if ($index < count($visitsToNotify) - 1) {
                sleep(1); // Pause de 1 seconde
            }
        }

        // Sortir le résultat
        $output->writeln(empty($emailDetails) ? 'Aucun email envoyé.' : implode("\n", $emailDetails));

        return Command::SUCCESS;
    }
}
