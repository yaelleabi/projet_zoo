<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\RapportVeterinaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

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
            ->add('state', TextType::class, [
                'label' => 'État de santé',
            ])
            ->add('date', DateType::class, [
                'label' => 'Date du rapport',
                'widget' => 'single_text',
            ])
            ->add('detail', TextareaType::class, [
                'label' => 'Détails du rapport',
                'attr' => ['rows' => 4], // Optionnel : définit la taille de la zone de texte
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RapportVeterinaire::class,
        ]);
    }
}
