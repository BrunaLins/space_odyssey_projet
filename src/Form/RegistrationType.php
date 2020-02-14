<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nom', TextType::class,
                ['label'=>'Nom'])
            ->add('prenom',
                TextType::class,
                ['label' =>'Prénom']
            )
            ->add('civilite',TextType::class,[
                'label'=>'Civilite'])

            ->add ('adresse',TextType::class,
                ['label'=>'Adresse'])
            ->add('codepostal',TextType::class,[
                'label'=>'Code postal'
            ])
           ->add('ville',TextType::class,[
               'label'=>'Ville'
           ])
            ->add('pays',TextType::class,[
                'label'=>'Pays'
            ])
            ->add('email',
                EmailType::class,
                ['label'=> 'E-mail'])
            ->add('plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Mot de passe',
                        'help' => 'Le mot de passe doit faire entre 6 et 20 caractères et contenir au moins une majuscule et un chiffre'
                    ],
                    'second_options'=>[
                        'label'=> 'Confirmation du mot de passe'
                    ],
                    'invalid_message' => 'La confirmation ne correspond pas au mot de passe'
                ]
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}