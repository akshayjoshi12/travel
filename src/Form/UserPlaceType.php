<?php

namespace App\Form;

use App\Entity\UserPlace;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\FilesType;


class UserPlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('placeImages', FileType::class, [
                
                'label' => 'Upload your best images or PDF document: ',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                'multiple' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
               
            ])
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('firstName', TextType::class, ['mapped' => false])
            ->add('lastName', TextType::class, ['mapped' => false])
            ->add('userName', TextType::class, ['mapped' => false])
            ->add('password', TextType::class, ['mapped' => false])
            ->add('Submit', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserPlace::class,
        ]);
    }
}