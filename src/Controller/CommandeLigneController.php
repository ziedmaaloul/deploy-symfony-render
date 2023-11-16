<?php

namespace App\Controller;

use App\Entity\CommandeLigne;
use App\Form\CommandeLigneType;
use App\Repository\CommandeLigneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande/ligne')]
class CommandeLigneController extends AbstractController
{
    #[Route('/', name: 'app_commande_ligne_index', methods: ['GET'])]
    public function index(CommandeLigneRepository $commandeLigneRepository): Response
    {
        return $this->render('commande_ligne/index.html.twig', [
            'commande_lignes' => $commandeLigneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_ligne_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commandeLigne = new CommandeLigne();
        $form = $this->createForm(CommandeLigneType::class, $commandeLigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commandeLigne);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_ligne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande_ligne/new.html.twig', [
            'commande_ligne' => $commandeLigne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_ligne_show', methods: ['GET'])]
    public function show(CommandeLigne $commandeLigne): Response
    {
        return $this->render('commande_ligne/show.html.twig', [
            'commande_ligne' => $commandeLigne,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_ligne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CommandeLigne $commandeLigne, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeLigneType::class, $commandeLigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_ligne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande_ligne/edit.html.twig', [
            'commande_ligne' => $commandeLigne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_ligne_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeLigne $commandeLigne, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeLigne->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commandeLigne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_ligne_index', [], Response::HTTP_SEE_OTHER);
    }
}
