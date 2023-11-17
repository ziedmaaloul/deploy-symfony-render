<?php

namespace App\Form;

use App\Entity\Produit;
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

class ProduitType extends AbstractType
{

    private $fournisseurRepository = null;
    public function __construct(FournisseurRepository $fournisseurRepository)
    {
        $this->fournisseurRepository = $fournisseurRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        dd($this->fournisseurRepository->findAll());
        $builder->add('libelle', TextType::class, [
            'label' => 'Nom de produit',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('image', FileType::class, [
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
        ->add('fournisseur', ChoiceType::class, [
            'label' => 'Fournissuer',
            'choices' => [
                'Option 1' => 'option1',
                'Option 2' => 'option2',
                'Option 3' => 'option3',
            ],
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
