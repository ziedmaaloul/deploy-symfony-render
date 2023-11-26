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

    protected function calculateFromArray($commandLines){

        $sum = 0;
        if(!$commandLines){
            return 0;
        }

        foreach ($commandLines as $commandLine){
            $sum += $commandLine->getProduit->getPrice() * $commandLine->getQuantity();
        }

        return $sum;
    }
   
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $todayCommands =  $this->commandeRepository->findAllToday();
        $monthCommands = $this->commandeLigneRepository->findAllThisMonth();
        $yearCommands = $this->commandeLigneRepository->findAllThisYear();
        $products = $this->commandeLigneRepository->findBestSellingProductsThisMonth();
        // dd([
        //     "today" => $todayCommands,
        //     "month" => $monthCommands,
        //     "year" => $yearCommands,
        //     "products" => $products
        // ]);
        // dd($todayCommands);
        return $this->render('index/index.html.twig', [
            'todayCommands' => count($todayCommands),
            'thisMonthRevenue' => $this->calculateFromArray($monthCommands),
            'thisYearRevenue' => $this->calculateFromArray($yearCommands),
            'controller_name' => 'IndexController',
        ]);
    }
}
