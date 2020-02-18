<?php

namespace App\Form;




use App\Entity\Destination;
use App\Entity\Duree;
use App\Entity\TypeHebergement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('destination',
                EntityType::class,
                [
                    'class'=>Destination::class,
                    'choice_label'=>'getNom',
                    'placeholder'=>'Choisissez une catégorie',
                    'required'=>false,
//                    attr = attribut dans les balise html pour ajouter du syle css champ option
//                    label_attr = changement css label crée une class css
                    'attr' => [
                        'class' => 'form_search'
                    ],
                    'label_attr' =>[
                        'class' => 'label_search'
                    ]
                ]
            )

            ->add('duree',
                EntityType::class,
                ['class'=>Duree::class,
                    'choice_label'=>'getNom',
                    'placeholder'=>'Choisissez la durée du séjour',
                    'required'=>false])

            ->add('typeHebergement',EntityType::class,
                ['class'=>TypeHebergement::class,
                    'choice_label'=>'getNom',
                    'placeholder'=>'Choisissez votre héberment',
                    'required'=>false,
                    'attr' => [
                        'class' => 'form_search'
                    ],
                    'label_attr' =>[
                        'class' => 'label_search'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection'=>false,
            'method'=>'get'

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
