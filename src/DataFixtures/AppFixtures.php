<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use App\Entity\Produit;
use Faker\Provider\Base;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AppFixtures extends Fixture
{

    private $passwordHasher = null;
    private $fournisseurRepository  = null;

    public function __construct( UserPasswordHasherInterface $passwordHasher , FournisseurRepository $fournisseurRepository){
        $this->passwordHasher = $passwordHasher;
        $this->fournisseurRepository = $fournisseurRepository;
    }

    public function setUser(ObjectManager $manager) {
        $user = new User();
        $newHashedPassword = $this->passwordHasher->hashPassword($user, "admin");
        $user->setPassword($newHashedPassword);
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEmail("admin@admin.admin");
        $manager->persist($user);
        $manager->flush();
    }


    public function setFournissuer(ObjectManager $manager){
        $fournisseurs = null;
        $faker = Factory::create();
        
        for ($i = 0; $i < 10; $i++) {
            $fournisseur = new Fournisseur();
            $fournisseur->setNom($faker->company);
            $fournisseur->setAdresse($faker->address);
            $fournisseur->setTelephone($faker->phoneNumber);
            $fournisseur->setFax($faker->phoneNumber);
            $manager->persist($fournisseur);
            $manager->flush();

            $fournisseurs[] = $fournisseur;
        }
        return $fournisseurs;

    }

    public function setProduit(ObjectManager $manager , $fournisseurs){
        $faker = Factory::create();
        
        for ($i = 0; $i < 30; $i++) {
            $produit = new Produit();
            $fournisseurId = Base::numberBetween($min = 0, $max = 9);
            $produit->setFournisseur($fournisseurs[$fournisseurId]);
            $produit->setLibelle($faker->company);
            $produit->setQuantity(Base::numberBetween($min = 0, $max = 90));
            $produit->setPrice(Base::randomFloat($nbMaxDecimals = NULL, $min = 5, $max = 300));
            $produit->setImage("http://tunisianet.com.tn/img/cms/pc-de-bureau-lenovo-s510-i3-4go-500go-.jpg");
            $manager->persist($produit);
        }
        $manager->flush();

    }


    public function load(ObjectManager $manager): void
    {
        $fournisseurs = $this->setFournissuer($manager);
        $this->setProduit($manager , $fournisseurs);
        $this->setUser($manager);
    }
}
