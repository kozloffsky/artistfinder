<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Acted\LegalDocsBundle\Entity\TechnicalRequirement;

class DocumentTechnicalRequirementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('technical_requirement', EntityType::class, [
                'class' => TechnicalRequirement::class,
                'constraints' => [new NotBlank(['message' => 'technical_requirement is required field'])],
                'description' => 'technical requirement id'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\DocumentTechnicalRequirement',
            'allow_extra_fields' => true,
            'csrf_protection'   => false,
        ));
    }
}
