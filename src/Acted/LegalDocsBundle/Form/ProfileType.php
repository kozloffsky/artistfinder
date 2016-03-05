<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId')
            ->add('title')
            ->add('header')
            ->add('description')
            ->add('isInternational')
            ->add('performanceRange')
            ->add('paymentTypeId')
            ->add('active')
            ->add('user')
            ->add('media')
            ->add('categories')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\Profile',
            'allow_extra_fields' => true,
            'csrf_protection'   => false,
            'method' => 'PATCH',
        ));
    }
}
