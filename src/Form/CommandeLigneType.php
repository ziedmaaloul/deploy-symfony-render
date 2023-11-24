<?php

namespace App\Form;

use App\Entity\CommandeLigne;
use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\ProduitRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CommandeLigneType extends AbstractType
{

    private $produitRepository = null;
    private array $produitData = [];

    public function __construct(ProduitRepository $produitRepository)
    {
        $this->produitRepository = $produitRepository;

        $produits = $this->produitRepository->findAll();

        if($produits){
            foreach($produits as $produit){
                $this->produitData[$produit->getLibelle()] = $produit->getId();
            }
        }
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('produit', EntityType::class, [
            'label' => 'Produit',
            'class' => Produit::class, // Le nom de l'entité Fournisseur
            'choice_label' => 'libelle', // La propriété de l'entité à afficher dans le champ
            'attr' => ['class' => 'form-select'],
        ])
        ->add('quantity', NumberType::class, [
            'label' => 'Quantité',
            'attr' => ['class' => 'form-control'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeLigne::class,
        ]);
    }
}
