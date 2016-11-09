<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Acted\LegalDocsBundle\Entity\Artist;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Form\Type\BooleanType;
use Acted\LegalDocsBundle\Entity\RequestQuotation;

class PerformancePriceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 128]),
                ], 'description' => 'Performance title'])
            ->add('package_name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 128]),
                ], 'description' => 'Package name'])
            ->add('options', 'collection', array(
                'type' => new PerformancePriceOptionType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'cascade_validation' => true,
                'attr' => array(
                    'nested_form' => true,
                    //'nested_form_min' => 1
                )
            ))
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'constraints' => [new NotBlank(['message' => 'Artist is required field'])],
                'description' => 'ArtistId'
            ])
            ->add('is_quotation', BooleanType::class, [
                'constraints' => [
                ], 'description' => 'Is quotation this service'])
            ->add('request_quotation', EntityType::class, [
                'class' => RequestQuotation::class,
                'constraints' => [],
                'description' => 'RequestQuotationId'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'Acted\LegalDocsBundle\Entity\Price',
            'allow_extra_fields' => true,
            'csrf_protection'   => false
        ));
    }
}
