<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Acted\LegalDocsBundle\Entity\Template;

class TemplateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type_id', ChoiceType::class, [
                'choices'  => Template::listTypes(),
                'label' => 'Type',
                'disabled' => true,
            ])
            ->add('template', 'textarea', [
                'attr' => [
                    'class' => 'tinymce',
                    'data-theme' => 'advanced' // Skip it if you want to use default theme
                ]
            ])
            ->add('is_active')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acted\LegalDocsBundle\Entity\Template'
        ));
    }
}
