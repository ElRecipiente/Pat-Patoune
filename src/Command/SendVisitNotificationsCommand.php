<?php
// src/Command/SendVisitNotificationsCommand.php
namespace App\Command;

use App\Repository\VisitRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Console\Input\InputOption;

class SendVisitNotificationsCommand extends Command
{
    protected static $defaultName = 'send:visit-notifications';

    private $visitRepository;
    private $mailer;

    public function __construct(VisitRepository $visitRepository, MailerInterface $mailer)
    {
        parent::__construct();
        $this->visitRepository = $visitRepository;
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Envoie les notifications de visite par email')
            ->addOption('interval', null, InputOption::VALUE_OPTIONAL, 'Nombre de jours à partir de maintenant pour notifier', 28);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $interval = $input->getOption('interval');
        $visitsToNotify = $this->visitRepository->findVisitToNotify($interval);
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
                sleep(1); // Pause de 1 seconde pour éviter d'être considéré comme spam
            }
        }

        $output->writeln($emailDetails ? implode("\n", $emailDetails) : 'Aucun email envoyé.');

        return Command::SUCCESS;
    }
}
