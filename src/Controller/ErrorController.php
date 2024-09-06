<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/404', name: 'error_404')]
    public function error404(): Response
    {
        return $this->render('error/error_404.html.twig', [
            'title' => '404 : Oups ! Cette page n\'existe pas !',
            'message' => "Désolé ! On ne sait pas comment vous êtes arrivés là, mais cette page n'existe pas.",
        ]);
    }
}