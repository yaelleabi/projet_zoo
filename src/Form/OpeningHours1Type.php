<?php

namespace App\Form;

use App\Entity\OpeningHours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class OpeningHours1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day' ,ChoiceType::class, [
                'choices' => [
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                    'Dimanche' => 'Dimanche',
                ],
                'label' => 'Jour de la semaine'
            ])
            ->add('openHour',  TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure d\'ouverture'
            ])
            ->add('closeHour',  TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure de fermeture'
            ]);
           // ->add('isOpen');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OpeningHours::class,
        ]);
    }
}
