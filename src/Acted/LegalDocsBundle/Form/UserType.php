<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('passwordHash')
            ->add('primaryPhone')
            ->add('secondaryPhone')
            ->add('active')
            ->add('avatar')
            ->add('background')
            ->add('profile')
            ->add('artist')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\User',
            'allow_extra_fields' => true,
            'csrf_protection'   => false,
            'method' => 'PATCH',
        ));
    }
}
