<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Form\VisitType;
use App\Repository\VisitRepository;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/visit')]
class VisitController extends AbstractController
{
    #[Route('/', name: 'app_visit', methods: ['GET'])]
    public function index(VisitRepository $visitRepository): Response
    {
        $user = $this->getUser();
        $animals = $user->getAnimals();

        if (!$user) {
            throw $this->createAccessDeniedException('User not found');
        }

        return $this->render('visit/visit.html.twig', [
            'visits' => $visitRepository->findAll()
        ]);
    }

    #[Route('/{animalId}', name: 'app_animal_visits', methods: ['GET'])]
    public function OneAnimalVisit(int $animalId, VisitRepository $visitRepository, AnimalRepository $animalRepository): Response
    {
        $animal = $animalRepository->find($animalId);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }

        return $this->render('visit/animal_visit.html.twig', [
            'visits' => $visitRepository->findBy(['animal' => $animalId]),
            'animal' => $animal
        ]);
    }
}
