<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Performance;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;

class ArtistEventCreateType extends AbstractType
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
                'required' => false,
                'description' => 'Events if user auth and have some event'
            ])
            ->add('slug', TextType::class, [
                'constraints' => [
                ]
            ])
            ->add('comment', TextType::class, [
                'constraints' => [
                    new Length(['max' => 450])
                ]
            ])
            ->add('performance', EntityType::class, [
                'class' => Performance::class,
                'multiple' => true,
                'constraints' => [new Count(['min' => 1])],
                'description' => 'Array of Performances IDs'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection'   => false
        ));
    }
}
