<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 22.03.16
 * Time: 13:48
 */

namespace Acted\LegalDocsBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResettingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', RepeatedType::class, [
            'first_options' => ['label' => 'Password'],
//            'second_options' => ['label' => 'Password confirmation'],
            'constraints' => [new NotBlank(), new Length(['min' => 6])]]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
        ]);

    }

    public function getBlockPrefix()
    {
        return null;
    }

}
