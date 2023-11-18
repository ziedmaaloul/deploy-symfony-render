<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Repository\FournisseurRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommandeType extends AbstractType
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

        $builder
            ->add('datecomm')
            ->add('fournisseur', ChoiceType::class, [
                'label' => 'Fournissuer',
                'choices' => $this->fournisseurData,
                'attr' => ['class' => 'form-select'],
                'choice_value' => 'id'
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
