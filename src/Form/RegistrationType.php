<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => true,
                'label' => 'Votre mot de passe',
                'first_options' => [
                    'label' =>'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Saississez votre mot de passe',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de renseigner un mot de passe',
                        ]),
                        new PasswordStrength([
                            'minLength' => 8,
                            'tooShortMessage' => 'Le mot de passe doit contenir au moins {{ length }} caractères',
                            'minStrength' => 4,
                            'message'=> 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial'
                        ])
                        // new Length([
                        //     'min' => 6,
                        //     'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                        //     // max length allowed by Symfony for security reasons
                        //     'max' => 4096,
                        // ]),
                    ]
                ],
                    'second_options' => [
                        'label' => 'Confirmez votre mot de passe'],
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre mot de passe',
                        'autocomplete' => 'new-password'],
                        'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.'
                    ])
            ->add('lastname')
            ->add('firstname')
            ->add('address')
            ->add('zip')
            ->add('city')
            ->add('country')
            ->add('number');
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
