<?php

namespace App\Form;

use App\Entity\Destination;
use App\Entity\Duree;
use App\Entity\Sejour;
use App\Entity\TypeHebergement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class SejourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',
            TextType::class,
                ['label' => 'Titre']
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
            ->add('dureedata',
                EntityType::class,
                ['label' => 'Durée',
                    'class' => Duree::class,
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisissez une durée'
                ]
            )
            ->add('moisDepart',
                DateType::class,
                ['label' => 'Mois départ']
            )
            ->add('description',
                TextareaType::class,
                ['label' => 'Description']
            )
            ->add('promo',
                IntegerType::class,
                ['label' => 'Promo',
                    'required' => false]
            )
            ->add('image_1',
                FileType::class,
                ['label' => 'Image 1',
                    'required' => false]
            )
            ->add('image_2',
                FileType::class,
                ['label' => 'Image 2',
                    'required' => false]
            )
         /*   ->add('stock',
                IntegerType::class,
                ['label' => 'Nombre de places restantes']
            )*/

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sejour::class,
        ]);
    }
}
