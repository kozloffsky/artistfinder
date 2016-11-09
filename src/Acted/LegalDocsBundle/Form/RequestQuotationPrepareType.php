<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\RequestQuotation;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RequestQuotationPrepareType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'constraints' => [new NotBlank(['message' => 'Event is required field'])],
                'description' => 'Event id'
            ])
            ->add('request_quotation', EntityType::class, [
                'class' => RequestQuotation::class,
                'constraints' => [new NotBlank(['message' => 'Request quotation is required field'])],
                'description' => 'RequestQuotationId'
            ])
            ->add('balance_percent', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 100, 'min' => 0])
                ], 'description' => 'balance_percent'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection'   => false,
            'method' => 'POST'
        ));
    }
}
