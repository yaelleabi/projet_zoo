<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\AnimalFeeding;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AnimalFeedingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de nourrissage',
            ])
            ->add('foodType', TextType::class, [
                'label' => 'Type de nourriture',
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
            ])
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
                'label' => 'Animal',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnimalFeeding::class,
        ]);
    }
}
