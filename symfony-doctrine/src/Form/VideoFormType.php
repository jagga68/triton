<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class VideoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('created_at', DateType::class, [
            //     'label' => 'Set date',
            //     'widget' => 'single_text',
            // ])
            ->add('title', TextType::class, [
                'label' => 'Set video title',
                // 'data' => 'Example title',
                'required' => false,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Agree ?',
                'mapped' => false,
            ])
            ->add('file', FileType::class, [
                'label' => 'Video MP4 file',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Add video',
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){

            $video = $event->getData();
            $form = $event->getForm();
            if(!$video || null === $video->getId())
            {
                $form->add('created_at', DateType::class, [
                    'label' => 'Set date',
                    'widget' => 'single_text',
                ]);
            }

        });


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
