<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\FournisseurRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProduitType extends AbstractType
{

    private $fournisseurRepository = null;
    private array $fournisseurData = [];

    public function __construct(FournisseurRepository $fournisseurRepository)
    {
        $this->fournisseurRepository = $fournisseurRepository;

        $fournisseurs = $this->fournisseurRepository->findAll();

        if($fournisseurs){
            foreach($fournisseurs as $fournisseur){
                $this->fournisseurData[$fournisseur->getNom()] = $fournisseur->getId();
            }
        }
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder->add('libelle', TextType::class, [
            'label' => 'Nom de produit',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('image', TextType::class, [
            'label' => 'Image',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('quantity', NumberType::class, [
            'label' => 'Quantité',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('price', NumberType::class, [
            'label' => 'Prix',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('fournisseur', EntityType::class, [
            'label' => 'Fournissuer',
            'class' => Fournisseur::class, // Le nom de l'entité Fournisseur
            'choice_label' => 'nom', // La propriété de l'entité à afficher dans le champ
            'attr' => ['class' => 'form-select'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
