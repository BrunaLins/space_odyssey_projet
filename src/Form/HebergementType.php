<?php

namespace App\Form;

use App\Entity\Destination;
use App\Entity\Hebergement;
use App\Entity\TypeHebergement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HebergementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',
                TextType::class,
                ['label' => 'Nom']
            )
            ->add('destination',
                EntityType::class,
                ['label' => 'Destination',
                    'class' => Destination::class,
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisissez une destination'
                ]
            )
            ->add('typeHebergement',
                EntityType::class,
                ['label' => 'Type Hébergement',
                    'class' => TypeHebergement::class,
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisissez un type d\'hébergement'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hebergement::class,
        ]);
    }
}
