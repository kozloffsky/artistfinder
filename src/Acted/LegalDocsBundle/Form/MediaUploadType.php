<?php

namespace Acted\LegalDocsBundle\Form;

use Acted\LegalDocsBundle\Form\DataTransformer\Base64ToFileTransformer;
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
            ->add('audio', 'text', ['constraints' => [new NotBlank(['groups' => 'audio'])]])
        ;
        $builder->get('file')->addModelTransformer(new Base64ToFileTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'validation_groups' => function(FormInterface $form) {
                $data = $form->getData();

                if(!empty($data['video'])){
                    return ['Default', 'video'];
                }

                if(!empty($data['audio'])){
                    return ['Default', 'audio'];
                }

                return ['Default', 'photo'];
            }
        ]);

    }

    public function getName()
    {
        return null;
    }
}
