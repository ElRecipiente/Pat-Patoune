<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\User;
use App\Form\AnimalType;
use App\Form\HealthBookletFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HealthBookletController extends AbstractController
{
    #[Route('/carnet/{id}', name: 'app_health_booklet')]
    public function index($id): Response
    {
        $user = $this->getUser();

        $animals = [];
        if ($user instanceof User) {
            $animals = $user->getAnimals();
        }

        $current_animal = [];
        foreach ($animals as $animal) {
            // strval to have same type than $id
            if (strval($animal->getId()) === $id) {
                $current_animal = $animal;
            }
        }

        $animal_info = [
            'name' => $current_animal->getName(),
            'Numéro d\'identification' => $current_animal->getIdentificationNumber(),
            'Numéro de tatouage' => $current_animal->getTatooNumber(),
            'Sexe' => $current_animal->getSex(),
            'Date de naissance' => $current_animal->getBirthDate()->format('d-m-Y'),
            'Date de stérilisation' => $current_animal->getSterilisationDate()->format('d-m-Y'),
            'Race de l\'animal' => $current_animal->getBreedType(),
            'Couleur du pelage' => $current_animal->getColor(),
            'Marques distinctives' => $current_animal->getDistinctiveMarks(),
        ];


        return $this->render('health_booklet/index.html.twig', [
            'animal_info' => $animal_info,
            'link_to_edit' => '/modifier_le_carnet_de_sante/'.$id,
        ]);
    }


    #[Route('/modifier_le_carnet_de_sante/{id}', name: 'app_health_booklet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animal $animal, EntityManagerInterface $entityManager, $id): Response
    {
        $form = $this->createForm(HealthBookletFormType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_health_booklet', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('health_booklet/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }
}
