<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeLigne;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\CommandeLigneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande')]
class CommandeController extends AbstractController
{

    private $entityManager = null;
    private $commandeRepository = null;
    private $commandeLigneRepository= null;

    function __construct(CommandeRepository $commandeRepository , CommandeLigneRepository $commandeLigneRepository) {
        $this->commandeRepository = $commandeRepository;
        $this->commandeLigneRepository = $commandeLigneRepository;
    }

    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(): Response
    {
        $commands = null;
        $commandList = $this->commandeRepository->findAll();

        foreach($commandList as $commande){
            $commandLignes =  $this->commandeLigneRepository->findBy(["commande_id" => $commande->getId()]);

            if($commandeLignes){
                foreach($commandeLignes as $commandeLigne){
                    $commande->addCommandeLigne($commandeLigne);
                }
            }

            $commands[] = $commande;
        }


        dd([
            "relatedCommands" => $commands,
            "command" => $this->commandeRepository->findAll() , 
            "lines" => $this->commandeLigneRepository->findAll() ]);
        return $this->render('commande/index.html.twig', [
            'commandes' => $this->commandeRepository->findAll(),
        ]);

    }


    function setCommandeLigne(CommandeLigne $commandeLigneRepo, Commande $commande) : CommandeLigne {
    
        $commandeLigne = new CommandeLigne();
        $commandeLigne->setQuantity($commandeLigneRepo->getQuantity());
        $commandeLigne->setProduit($commandeLigneRepo->getProduit());
        $commandeLigne->setCommande($commande);

        $this->entityManager->persist($commandeLigne);
        $this->entityManager->flush();

        return $commandeLigne;
    }


    #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager , CommandeRepository $commandeRepository): Response
    {
        $this->entityManager = $entityManager;


        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {

            $commandesLines = $commande->getCommandeLignes();

            $newCommande = new Commande();
            $newCommande->setFournisseur($commande->getFournisseur());

            $entityManager->persist($newCommande);
            $entityManager->flush();

            if($commandesLines){
                foreach($commandesLines as $commandeLigne){
                   $this->setCommandeLigne($commandeLigne , $newCommande);
                }
            }
        }        

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
