<?php

namespace App\Form;




use App\Entity\Destination;
use App\Entity\Search;
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
                ['class'=>Destination::class,
                    'choice_label'=>'getNom',
                    'placeholder'=>'Choisissez une catégorie',
                    'required'=>false])

            ->add('typeHebergement',EntityType::class,
                ['class'=>TypeHebergement::class,
                    'choice_label'=>'getNom',
                    'placeholder'=>'Choisissez votre héberment','required'=>false])
        ;
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
