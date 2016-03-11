<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class MediaUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', ['constraints' => [new NotBlank(['groups' => 'photo']), new Image()]])
            ->add('video', 'text', ['constraints' => [new NotBlank(['groups' => 'video'])]])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'validation_groups' => function(FormInterface $form) {
                $data = $form->getData();

                if(is_null($data['video'])){
                    return ['Default', 'photo'];
                }
                return ['Default', 'video'];
            }
        ]);

    }

    public function getName()
    {
        return null;
    }
}
