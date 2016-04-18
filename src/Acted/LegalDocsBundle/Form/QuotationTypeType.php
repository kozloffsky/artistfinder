<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuotationTypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company_name')
            ->add('artist_name')
            ->add('street_address')
            ->add('city')
            ->add('zipcode')
            ->add('phone_num')
            ->add('fax_num')
            ->add('email_address')
            ->add('name')
            ->add('company_name2')
            ->add('street_address2')
            ->add('city2')
            ->add('zipcode2')
            ->add('phone')
            ->add('location')
            ->add('timing')
            ->add('special_instructions')
            ->add('today_date', 'date')
            ->add('quotation_id')
            ->add('acted_id')
            ->add('expire_date', 'date')
            ->add('description_service1')
            ->add('description_service2')
            ->add('is_service1_taxed')
            ->add('is_service2_taxed')
            ->add('service1_amount')
            ->add('service2_amount')
            ->add('deposit_percent')
            ->add('deposit_amount')
            ->add('balance_percent')
            ->add('balance_amount')
            ->add('balance_when')
            ->add('balance_mode')
            ->add('additional_comments')
            ->add('subtotal_amount')
            ->add('taxable_amount')
            ->add('tax_rate')
            ->add('tax_amount')
            ->add('other_amount')
            ->add('total_amount')
            ->add('event', null, ['required' => true])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\QuotationType'
        ));
    }
}
