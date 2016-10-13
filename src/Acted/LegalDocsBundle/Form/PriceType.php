<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Acted\LegalDocsBundle\Entity\Artist;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\Service;
use Acted\LegalDocsBundle\Entity\Profile;

use Symfony\Component\Validator\Constraints\Image;
use Acted\LegalDocsBundle\Form\DataTransformer\Base64ToFileTransformer;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PriceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('performance_title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 128]),
                ], 'description' => 'Performance title'])
            ->add('service_title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 128]),
                ], 'description' => 'Service title'])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'constraints' => [new NotBlank(['message' => 'Artist is required field'])],
                'description' => 'ArtistId'
            ])
            ->add('qty', IntegerType::class, [
                'constraints' => [
                    new Length(['max' => 128, 'min' => 1])
                ], 'description' => 'qty'])
            ->add('duration', IntegerType::class, [
                'constraints' => [
                    new Length(['max' => 123456789, 'min' => 1])
                ], 'description' => 'Duration'])
            ->add('price1', IntegerType::class, [
                'constraints' => [
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
            'csrf_protection'   => false,
            'method' => 'POST'
        ));
    }
}
