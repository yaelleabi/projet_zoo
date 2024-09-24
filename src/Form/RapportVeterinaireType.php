<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\RapportVeterinaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportVeterinaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Animal', EntityType::class, [
            'class' => Animal::class,
            'choice_label' => function (Animal $animal) {
                return $animal->getName() . ' - ' . $animal->getRace(); // Nom - Race
            },
            'label' => 'Choisir un animal',
            'placeholder' => 'Sélectionnez un animal', // Optionnel : affiche un choix vide par défaut
        ])
            ->add('state')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('detail')
           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RapportVeterinaire::class,
        ]);
    }
}
