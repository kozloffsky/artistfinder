<?php

namespace Acted\LegalDocsBundle\Form;

use Acted\LegalDocsBundle\Entity\Category;
use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Entity\RefCity;
use Acted\LegalDocsBundle\Form\DataTransformer\PhoneTransformer;
use Acted\LegalDocsBundle\Popo\RegisterUser;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CreateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', ChoiceType::class, [
                'choices_as_values' => true,
                'choices' => ['ROLE_ARTIST', 'ROLE_CLIENT'],
                'constraints' => [new NotBlank()],
                'description' => 'User role',
            ])

            ->add('firstname', TextType::class, ['constraints' => [new NotBlank()], 'description' => 'First name'])
            ->add('email', TextType::class, [
                'required' => false
            ])

            ->add('lastname', TextType::class, ['constraints' => [new NotBlank()], 'description' => 'Last name'])

            ->add('password', RepeatedType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 8]),
                    new Regex(['pattern' =>'/[a-z]/', 'message' => 'Password should contain lowercase char, uppercase char, and digit']),
                    new Regex(['pattern' =>'/[A-Z]/', 'message' => 'Password should contain lowercase char, uppercase char, and digit']),
                    new Regex(['pattern' =>'/[0-9]/', 'message' => 'Password should contain lowercase char, uppercase char, and digit']),
                ],
                'description' => 'Password and confirmation field'
            ])

            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'constraints' => [new Count(['min' => 1, 'groups' => 'artist'])],
                'description' => 'Array of categories IDs (for ROLE_ARTIST)'
            ])

            ->add('name', TextType::class, [
                'constraints' => [new NotBlank(['groups' => 'artist'])],
                'description' => 'Artist name (also is uses for "slug" generation) (for ROLE_ARTIST)'
            ])

            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank(['groups' => 'artist']),
                    new Regex([
                        'pattern' => '/^[\d\+\(\) -]+$/',
                        'message' => 'Phone can contain digits, brackets, +'
                    ]),
                ],
                'description' => 'Phone number (available chars: digits,+,(,)) (for ROLE_ARTIST)',
            ])

            ->add('country', TextType::class, ['constraints' => [new NotBlank(['groups' => 'artist'])], 'description' => 'Country'])
            ->add('city', TextType::class, ['constraints' => [new NotBlank(['groups' => 'artist'])], 'description' => 'City'])
            ->add('city_lat', NumberType::class, ['constraints' => [new NotBlank(['groups' => 'artist'])], 'description' => 'City latitude'])
            ->add('city_lng', NumberType::class, ['constraints' => [new NotBlank(['groups' => 'artist'])], 'description' => 'City longitude'])
            ->add('region_name', TextType::class, ['constraints' => [new NotBlank(['groups' => 'artist'])], 'description' => 'Name of region'])
            ->add('region_lat', NumberType::class, ['constraints' => [new NotBlank(['groups' => 'artist'])], 'description' => 'Region latitude'])
            ->add('region_lng', NumberType::class, ['constraints' => [new NotBlank(['groups' => 'artist'])], 'description' => 'Region longitude'])
            ->add('place_id', TextType::class, ['constraints' => [new NotBlank(['groups' => 'artist'])], 'description' => 'Place id'])


            ->add('fake', TextType::class, [
                'required' => false,
            ])
            ->add('temp_password', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'description' => 'Temp password for created user',
            ])
        ;

        $builder->get('phone')->addModelTransformer(new PhoneTransformer());
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
