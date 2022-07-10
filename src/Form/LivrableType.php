<?php

namespace App\Form;

use App\Entity\Livrable;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivrableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule')
            ->add('doc')
            ->add('DocFile',FileType::class,[
                'label'=>'Document (PDF)',
                'required'=>false,
                'mapped'=>false,
                'data_class'=>null,
                'constraints'=>[
                    new \Symfony\Component\Validator\Constraints\File([
                        'maxSize'=>'10M',
                        'mimeTypes'=>['application/pdf'],
                        'mimeTypesMessage'=>'Please upload a valid PDF document',
                    ])
                ]
            ])
            //->add('Tache')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livrable::class,
        ]);
    }
}
