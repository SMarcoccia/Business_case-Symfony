<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('annee')
            ->add('kilometrage')
            ->add('prix')
            ->add('description')
            ->add('immatriculation')
            ->add('reference')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('marque')
            ->add('modele')
            ->add('carburant')
            ->add('garage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
