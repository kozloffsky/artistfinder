<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Acted\LegalDocsBundle\Form\Type\BooleanType;

class PerformancePriceOptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qty', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 128, 'min' => 1])
                ], 'description' => 'qty'])
            ->add('duration', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 123456789, 'min' => 1])
                ], 'description' => 'Duration'])
            ->add('price_on_request', BooleanType::class, [
                'constraints' => [
                ], 'description' => 'Price on request'])
            ->add('price1', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 123456789, 'min' => 1])
                ], 'description' => 'Price1'])
            ->add('price2', IntegerType::class, [
                'constraints' => [
                    new Length(['max' => 123456789, 'min' => 1])
                ], 'description' => 'Price2'])
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
