<?php

namespace Acted\LegalDocsBundle\Form;

use Acted\LegalDocsBundle\Entity\RefCountry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CountryFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', EntityType::class, [
                'class' => RefCountry::class,
                'constraints' => [new NotBlank()],
                'description' => 'Country ID',
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'method' => 'GET',
        ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
