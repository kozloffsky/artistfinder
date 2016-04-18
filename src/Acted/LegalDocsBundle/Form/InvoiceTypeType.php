<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceTypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company_name')
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
            ->add('today_date', 'date')
            ->add('invoice_id')
            ->add('acted_id')
            ->add('due_date', 'date')
            ->add('description_service1')
            ->add('description_service2')
            ->add('service1_unitprice')
            ->add('service2_unitprice')
            ->add('service1_qty')
            ->add('service2_qty')
            ->add('is_service1_taxed')
            ->add('is_service2_taxed')
            ->add('service1_amount')
            ->add('service2_amount')
            ->add('subtotal_amount')
            ->add('taxable_amount')
            ->add('tax_rate')
            ->add('tax_amount')
            ->add('other_amount')
            ->add('total_amount')
            ->add('acted_company_name')
            ->add('event', null, ['required' => true])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\InvoiceType'
        ));
    }
}
