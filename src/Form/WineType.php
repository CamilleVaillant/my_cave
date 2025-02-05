<?php

namespace App\Form;

use App\Entity\Cave;
use App\Entity\Wine;
use App\Entity\Cepage;
use App\Entity\region;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class WineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('year')
            ->add('body')
            ->add('imageName')
            ->add('updatedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('region', EntityType::class, [
                'class' => region::class,
                'choice_label' => 'id',
            ])
            ->add('cepages', EntityType::class, [
                'class' => Cepage::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('caves', EntityType::class, [
                'class' => Cave::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'mapped' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez upoader une image valide (JPEG, PNG, GIF).',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wine::class,
        ]);
    }
}
