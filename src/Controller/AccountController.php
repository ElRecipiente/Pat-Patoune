<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        $user = $this->getUser();
        $animals = [];
        if ($user instanceof User) {
            $animals = $user->getAnimals();
        }

        return $this->render('account/index.html.twig', [
            'username' => $user->getFirstname(),
            'animals' => $animals,
        ]);
    }
}
