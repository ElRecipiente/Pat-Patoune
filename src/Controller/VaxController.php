<?php

namespace App\Controller;

use App\Entity\Vax;
use App\Form\VaxType;
use App\Repository\VaxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vax')]
class VaxController extends AbstractController
{
    #[Route('/', name: 'app_vax_index', methods: ['GET'])]
    public function index(VaxRepository $vaxRepository): Response
    {
        return $this->render('vax/index.html.twig', [
            'vaxes' => $vaxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vax_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vax = new Vax();
        $form = $this->createForm(VaxType::class, $vax);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vax);
            $entityManager->flush();

            return $this->redirectToRoute('app_vax_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vax/new.html.twig', [
            'vax' => $vax,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vax_show', methods: ['GET'])]
    public function show(Vax $vax): Response
    {
        return $this->render('vax/show.html.twig', [
            'vax' => $vax,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vax_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vax $vax, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VaxType::class, $vax);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vax_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vax/edit.html.twig', [
            'vax' => $vax,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vax_delete', methods: ['POST'])]
    public function delete(Request $request, Vax $vax, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vax->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vax);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vax_index', [], Response::HTTP_SEE_OTHER);
    }
}
