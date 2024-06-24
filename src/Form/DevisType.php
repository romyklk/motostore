<?php

namespace App\Form;

use App\Entity\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName',TextType::class, [
                'label' => 'Nom'
            ])
            ->add('email',EmailType::class, [
                'label' => 'Email'
            ])
            ->add('tel',TelType::class, [
                'label' => 'Téléphone'
            ])
            ->add('message',TextareaType::class, [
                'label' => 'Message'
            ])
            ->add('address',HiddenType::class, [
                'label' => 'Adresse'
            ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
