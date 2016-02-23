<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PerformanceContractType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artist_address')
            ->add('today_date', 'date')
            ->add('artist_details')
            ->add('client_details')
            ->add('event_date', 'date')
            ->add('event_location')
            ->add('performance_description')
            ->add('event_amount')
            ->add('currency')
            ->add('deposit_amount')
            ->add('deposit_percent')
            ->add('balance_amount')
            ->add('balance_percent')
            ->add('balance_mode')
            ->add('balance_when')
            ->add('transportation')
            ->add('accomodation')
            ->add('special_terms')
            ->add('last_call_date', 'date')
            ->add('artist_name')
            ->add('client_name')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\PerformanceContract'
        ));
    }
}
