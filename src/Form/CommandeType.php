<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Repository\FournisseurRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Fournisseur;


class CommandeType extends AbstractType
{

    private $fournisseurRepository = null;
    private array $fournisseurData = [];

    public function __construct(FournisseurRepository $fournisseurRepository)
    {
        $this->fournisseurRepository = $fournisseurRepository;

        $this->fournisseurData = $this->fournisseurRepository->findAll();

        // if($fournisseurs){
        //     foreach($fournisseurs as $fournisseur){
        //         $this->fournisseurData[$fournisseur] = $fournisseur->getId();
        //     }
        // }
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('fournisseur', EntityType::class, [
                'label' => 'Fournissuer',
                'class' => Fournisseur::class, // Le nom de l'entité Fournisseur
                'choice_label' => 'nom', // La propriété de l'entité à afficher dans le champ
                'attr' => ['class' => 'form-select'],
            ])
            ->add('commandeLignes', CollectionType::class, [
                'entry_type' => CommandeLigneType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
