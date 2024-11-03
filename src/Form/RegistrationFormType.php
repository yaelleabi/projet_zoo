<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Validator\Constraints\Email;
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username', null, [
            'attr' => [
                'class' => 'form-control', 
                'placeholder' => 'Entrez votre adresse email'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer une adresse email.',
                ]),
                new Email([
                    'message' => 'L\'adresse email {{ value }} n\'est pas une adresse valide.',
                ]),
            ],
        ])
            
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Employé' => 'ROLE_EMPLOYEE',
                    'Veterinaire' => 'ROLE_VETERINARY',
                ],
                'expanded' => true, // Afficher sous forme de cases à cocher
                'multiple' => false, // Une seule option sélectionnable
            ]);

        // Transformer les données entre la vue et le modèle
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // Transforme un tableau en chaîne pour l'affichage dans le formulaire
                    return is_array($rolesArray) && count($rolesArray) > 0 ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // Transforme une chaîne en tableau pour la sauvegarde dans l'entité
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
