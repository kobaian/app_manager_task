<?php

namespace App\Form;

use App\Entity\Image;
use App\Service\Helper\ImageHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, [
            'label'       => 'File to be converted',
            'mapped'      => false,
            'required'    => true,
        ])->add('targetExtension', ChoiceType::class, [
            'choices' => [
                ImageHelper::getImageExtensionsAssocArray(),
            ],
        ])
            ->add('targetImageWidth', IntegerType::class, ['label' => 'Target Image Width'])
            ->add('targetImageHeight', IntegerType::class, ['label' => 'Target Image Height'])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}