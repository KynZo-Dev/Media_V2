<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LastName', TextType::class, [
                'label' => 'Nom',
                'required' => 'true',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter un Nom valide',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre Nom doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('FirstName', TextType::class, [
                'label' => 'Prénom',
                'required' => 'true',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter un Prénom valide',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre Prénom doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => 'true'
            ])
            ->add('Address', TextType::class, [
                'label' => 'Adresse',
                'required' => 'true'
            ])
            ->add('PostalCode', NumberType::class, [
                'label' => 'Code Postal',
                'required' => 'true'
            ])
            ->add('BirthDay', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                'label' => 'Anniversaire',
                'required' => 'true'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Accepter conditions général',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions général.',
                    ]),
                ],
                'required' => 'true',
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'required' => 'true',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter un mot de passe valide',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
