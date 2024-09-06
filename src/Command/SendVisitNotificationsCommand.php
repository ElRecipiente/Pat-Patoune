<?php
// src/Command/SendVisitNotificationsCommand.php
namespace App\Command;

use App\Repository\VisitRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Console\Input\InputOption;
use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;

class SendVisitNotificationsCommand extends Command
{
    protected static $defaultName = 'send:visit-notifications';

    private $visitRepository;
    private $mailer;
    private EntityManagerInterface $entityManager;

    public function __construct(VisitRepository $visitRepository, MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->visitRepository = $visitRepository;
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Envoie les notifications de visite par email')
            ->addOption('interval', null, InputOption::VALUE_OPTIONAL, 'Nombre de jours à partir de maintenant pour notifier', $_ENV['VISIT_NOTIFICATION_DELAY'] );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailer = new Mailer($transport);
        
        $interval = $input->getOption('interval');
        $visitsToNotify = $this->visitRepository->findVisitToNotify($interval);
        $emailDetails = [];
        
        foreach ($visitsToNotify as $index => $visit) {
            $user = $visit->getAnimal()->getUser();
            $animal = $visit->getAnimal();
            // Envoi de l'email
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
            $output->writeln("Email envoyé à " . $user->getEmail());
    
            // Ajouter une nouvelle entrée dans la table Notification
            $notification = new Notification();
            $notification->setUser($user);
            $notification->setSendingDate(new \DateTime());
            $notification->setStatus(1);
    
            // Persister la notification
            $this->entityManager->persist($notification);
            $output->writeln("Notification ajoutée en mémoire pour " . $user->getEmail());
        }
    
        // Flusher les notifications
        $this->entityManager->flush();
    
        return Command::SUCCESS;
    }
    
}
