<?php

namespace App\Form;



use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu',
                TextareaType::class,[
                    'label' =>'Votre commentaire']
            )
            ->add(
                'note',
                ChoiceType::class,
                [
                    'label' => 'Note',
                    'choices' => [
                        '1 étoile' => '1',
                        '2 étoiles' => '2',
                        '3 étoiles' =>'3',
                        '4 étoiles' =>'4',
                        '5 étoiles' => '5',
                    ]
                ]
            )
        ;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
