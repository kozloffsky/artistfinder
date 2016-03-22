<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', ChoiceType::class, ['choices_as_values' => true, 'choices' => ['ROLE_ARTIST', 'ROLE_CLIENT'], 'constraints' => [new NotBlank()]])
            ->add('firstname', TextType::class, ['constraints' => [new NotBlank()]])
            ->add('lastname', TextType::class, ['constraints' => [new NotBlank()]])
            ->add('email', EmailType::class, ['constraints' => [new NotBlank()]])
            ->add('password', RepeatedType::class, ['constraints' => [new NotBlank()]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);

    }

    public function getBlockPrefix()
    {
        return null;
    }
}
