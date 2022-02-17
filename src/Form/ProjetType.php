<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('titre')
            ->add('description',TextareaType::class, [
                'attr' => ['rows' => 10]    ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required'=>false  ,
                'mapped' => false,
                'multiple' => true,

                // unmapped means that this field is not associated to any entity property'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file// every time you edit the Product details'required' => false,

                // unmapped fields can't define their validation using annotations// in the associated entity, so you can use the PHP constraint classes'constraints' => [
                    'constraints' => [
                        new All([
                            'constraints' =>[
                                new File([
                                    'maxSize' => '1024k',
                                    'mimeTypes' => [
                                        'image/jpeg',
                                        'image/png',
                                    ],
                                    'mimeTypesMessage' => 'Veuiller télécharger un fichier valide',
                                ]),
                            ],
                        ]),
                    ] 
                ]);            	

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
