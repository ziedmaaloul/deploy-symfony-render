<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use App\Entity\Fournisseur;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AppFixtures extends Fixture
{

    private $passwordHasher = null;

    public function __construct( UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
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
        $faker = Factory::create();
        
        for ($i = 0; $i < 10; $i++) {
            $fournisseur = new Fournisseur();
            $fournisseur->setNom($faker->company);
            $fournisseur->setAdresse($faker->address);
            $fournisseur->setTelephone($faker->phoneNumber);
            $fournisseur->setFax($faker->phoneNumber);
            $manager->persist($fournisseur);
        }
        $manager->flush();

    }


    public function load(ObjectManager $manager): void
    {
        $this->setFournissuer($manager);
        $this->setUser($manager);
    }
}
