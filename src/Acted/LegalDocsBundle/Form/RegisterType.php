<?php

namespace Acted\LegalDocsBundle\Form;

use Acted\LegalDocsBundle\Entity\Category;
use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Popo\RegisterUser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', ChoiceType::class, [
                'choices_as_values' => true,
                'choices' => ['ROLE_ARTIST', 'ROLE_CLIENT'],
                'constraints' => [new NotBlank()]]
            )

            ->add('firstname', TextType::class, ['constraints' => [new NotBlank()]])

            ->add('lastname', TextType::class, ['constraints' => [new NotBlank()]])

            ->add('email', EmailType::class, ['constraints' => [new NotBlank(), new Email()]])

            ->add('password', RepeatedType::class, ['constraints' => [new NotBlank(), new Length(['min' => 6])]])

            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'constraints' => [new Count(['min' => 1, 'groups' => 'artist'])]])

            ->add('name', TextType::class, ['constraints' => [new NotBlank(['groups' => 'artist'])]])

            ->add('country', EntityType::class, [
                'class' => RefCountry::class,
                'constraints' => [new NotBlank(['groups' => 'artist'])]]
            )

            ->add('phone', TextType::class, ['constraints' => [
                new NotBlank(['groups' => 'artist']),
                new Regex(['pattern' => '/^[\d\+\(\) -]+$/'])]]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegisterUser::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'validation_groups' => function (FormInterface $form) {
                /** @var RegisterUser $data */
                $data = $form->getData();
                if ($data->getRole() == 'ROLE_ARTIST') {
                    return ['Default', 'artist'];
                }
                return ['Default'];
            }
        ]);

    }

    public function getBlockPrefix()
    {
        return null;
    }
}
