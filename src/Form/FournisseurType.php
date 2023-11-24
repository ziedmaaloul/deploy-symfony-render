<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('nom', TextType::class, [
            'label' => 'Raison Sociale',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('adresse', TextType::class, [
            'label' => 'Adresse',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('telephone', TextType::class, [
            'label' => 'Téléphone',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('fax', TextType::class, [
            'label' => 'Fax',
            'attr' => ['class' => 'form-control'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
