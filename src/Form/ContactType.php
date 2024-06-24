<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,
                [
                    'constraints' => [
                        new \Symfony\Component\Validator\Constraints\Regex([
                            'pattern' => '/^[a-zA-Z\s]*$/',
                            'message' => 'Le nom ne doit contenir que des lettres.'
                        ]),
                        new \Symfony\Component\Validator\Constraints\Length([
                            'min' => 2,
                            'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.'
                        ]),

                    ]
                ])
            ->add('email',EmailType::class,[
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Email([
                        'message' => 'Veuillez saisir une adresse email valide.'
                    ])
                ]
            
            ])
            ->add('phone',TelType::class,[
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Regex([
                        'pattern' => '/^[0-9]{6,12}$/',
                        'message' => 'Le numéro de téléphone doit contenir entre 6 et 12 chiffres sans espace.'
                    ])
                ]
            ])
            ->add('message',TextareaType::class,[
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Length([
                        'min' => 10,
                        'minMessage' => 'Le message doit contenir au moins {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('address',HiddenType::class,)
            ->add('city',HiddenType::class,)
            ->add('zip',HiddenType::class,)
            ->add('country',HiddenType::class,)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
