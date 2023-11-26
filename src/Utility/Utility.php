<?php

namespace App\Utility;

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

class Utility 
{
    public static function calculateTotal(Commande $commande) : float {
        $total = 0;
        $commandesLignes = $commande->getCommandeLignes();
        if(!$commandesLignes){
            return 0;
        }

        foreach ($commandesLignes as $commandesLigne){
            $total += $commandesLigne->getQuantity() * $commandesLigne->getProduit()->getPrice();
        }

        return $total;
    }

    public static function getCommandDetails(Commande $commande ,CommandeLigneRepository $commandeLigneRepository ) : array {
        
        $commandLignes =  $commandeLigneRepository->findBy(["commande" => $commande->getId()]);

        if($commandLignes){
            foreach($commandLignes as $commandeLigne){
                $commande->addCommandeLigne($commandeLigne);
            }
        }

        return [
            "id" => $commande->getId(),
            "object" => $commande,
            "created_at" => $commande->getCreatedAt(),
            "fournisseur" => $commande->getFournisseur()->getNom(),
            'total' => Utility::calculateTotal($commande)
        ];
    }

}
