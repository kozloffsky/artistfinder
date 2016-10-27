<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Acted\LegalDocsBundle\Entity\Artist;

class TechnicalRequirementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('description', TextType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'constraints' => [new NotBlank(['message' => 'Artist is required field'])],
                'description' => 'ArtistId'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\TechnicalRequirement',
            'allow_extra_fields' => true,
            'csrf_protection'   => false,
        ));
    }
}
