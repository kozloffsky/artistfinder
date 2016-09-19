<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Acted\LegalDocsBundle\Entity\Profile;

class PerformanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('techRequirement')
            ->add('profile')
            ->add('media')
            ->add('status', ChoiceType::class, [
                'choices_as_values' => true,
                'choices' => ['draft', 'published'],
                'description' => 'Performance status',
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\Performance',
            'allow_extra_fields' => true,
            'csrf_protection'   => false,
        ));
    }
}
