<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeLigne;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\CommandeLigneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    
    private $entityManager = null;
    private $commandeRepository = null;
    private $commandeLigneRepository= null;

    public function __construct(CommandeRepository $commandeRepository , 
                        CommandeLigneRepository $commandeLigneRepository
                        ) {
        $this->commandeRepository = $commandeRepository;
        $this->commandeLigneRepository = $commandeLigneRepository;
    }

   
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $todayCommands =  $this->commandeRepository->findAllToday();
        dd($todayCommands);
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
