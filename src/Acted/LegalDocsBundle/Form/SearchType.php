<?php

namespace Acted\LegalDocsBundle\Form;

use Acted\LegalDocsBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'description' => 'Array of categories IDs'
            ])
            ->add('query', TextType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'method' => 'GET',
        ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
