<?php

namespace App\Form;

use App\Entity\Video;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoCandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'Entretient vidéo'=>'Entretient',
                    'CV vidéo'=>'CV'
                ]
            ])

            ->add('status',ChoiceType::class,[
                'choices'=>[
                    'Public'=>'0',
                    'Privée'=>'1'
                ]

            ])
            ->add('description')
            ->add('video', TextType::class,[
                'label'=>'Lien du vidéo'
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
