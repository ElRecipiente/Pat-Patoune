<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $user = $this->getUser();
        $callback_link = '/account';
        if (!$user) {
            $callback_link = '/login';
        }

        return $this->render('home_page/index.html.twig', [
            'user' => $user,
            'callback_link' => $callback_link,
        ]);
    }
}
