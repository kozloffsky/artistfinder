<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use Acted\LegalDocsBundle\Entity\Category;
use Acted\LegalDocsBundle\Entity\Artist;

class RecommendType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', IntegerType::class, [
                'constraints' => [new Range([
                    'min' => 1,
                    'max' => 100,
                    'minMessage' => 'You should set only positive recommend value less or equal 100',
                    'maxMessage' => 'You should set only positive recommend value less or equal 100',
                ])]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'constraints' => [new NotBlank(['message' => 'Category is required field'])],
                'multiple' => false,
                'description' => 'Main categories ID'
            ])
            ->add('user', EntityType::class, [
                'class' => Artist::class,
                'constraints' => [new NotBlank(['message' => 'User is required field'])],
                'description' => 'UserId'
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\Recommend',
            'allow_extra_fields' => true,
            'csrf_protection'   => false,
        ));
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
