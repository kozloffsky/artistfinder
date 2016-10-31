<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;

use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Entity\RefCity;

use Acted\LegalDocsBundle\Form\DataTransformer\Base64ToFileTransformer;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Acted\LegalDocsBundle\Form\Type\BooleanType;

class ProfileSettingsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 128]),
                    new Regex(['pattern' =>"#^[^<>$:!@\#$%*\(\)\^]+$#", 'message' => 'First name should not contain special characters.']),
                ], 'description' => 'First name'])

            ->add('last_name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 128]),
                    new Regex(['pattern' =>"#^[^<>$:!@\#$%*\(\)\^]+$#", 'message' => 'Last name should not contain special characters.'])
                ], 'description' => 'Last name'])

            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 128]),
                    new Regex(['pattern' =>"#^[^<>$:!@\#$%*\(\)\^]+$#", 'message' => 'Last name should not contain special characters.'])
                ],
                'description' => 'Artist name'
            ])

            ->add('post_code', TextType::class, [
                'constraints' => [
                    new Length(['max' => 32])
                ], 'description' => 'Post code'])

            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[\d\+\(\) -]+$/',
                        'message' => 'Phone can contain digits, brackets, +'
                    ]),
                ],
                'description' => 'Phone number (available chars: digits,+,(,)) (for ROLE_ARTIST)',
            ])

            ->add('country', TextType::class, ['constraints' => [new NotBlank()], 'description' => 'Country'])
            ->add('city', TextType::class, ['constraints' => [new NotBlank()], 'description' => 'City'])
            ->add('city_lat', NumberType::class, ['constraints' => [new NotBlank()], 'description' => 'City latitude'])
            ->add('city_lng', NumberType::class, ['constraints' => [new NotBlank()], 'description' => 'City longitude'])
            ->add('region_name', TextType::class, ['constraints' => [new NotBlank()], 'description' => 'Name of region'])
            ->add('region_lat', NumberType::class, ['constraints' => [new NotBlank()], 'description' => 'Region latitude'])
            ->add('region_lng', NumberType::class, ['constraints' => [new NotBlank()], 'description' => 'Region longitude'])

            /*->add('email', EmailType::class, ['constraints' => [
                new NotBlank(),
                new Email(['message' => 'Please provide a valid email address.'])], 'description' => 'Email'
            ])*/

            ->add('password', TextType::class, [
                'constraints' => [
                    new Length(['min' => 8]),
                    new Regex(['pattern' =>'/[a-z]/', 'message' => 'Password should contain lowercase char.']),
                    new Regex(['pattern' =>'/[A-Z]/', 'message' => 'Password should contain uppercase char.']),
                    new Regex(['pattern' =>'/[0-9]/', 'message' => 'Password should contain a digit.']),
                ],
                'description' => 'Password'
            ])


            ->add('file', TextType::class, [
                'required' => false
            ])
            
            ->add('work_abroad', BooleanType::class, [
                'constraints' => [
                ], 'description' => 'Work abroad'])

            ->add('account_name', TextType::class, [
                'constraints' => [
                    new Length(['max' => 512])
                ], 'description' => 'Account name'])

            ->add('account_number', TextType::class, [
                'constraints' => [
                    new Length(['max' => 32])
                ], 'description' => 'Account number'])

            ->add('bank_name', TextType::class, ['constraints' => [
                    new Length(['max' => 128])
                ], 'description' => 'Bank name'])

            ->add('billing_address', TextType::class, [
                'constraints' => [
                    new Length(['max' => 512])
                ], 'description' => 'Billing address'])

            ->add('vat_number', TextType::class, [
                'constraints' => [
                    new Length(['max' => 32])
                ], 'description' => 'Vat number'])

            ->add('swift_code', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^([a-zA-Z]){4}([a-zA-Z]){2}([0-9a-zA-Z]){2}([0-9a-zA-Z]{3})?$/',
                        'message' => 'This swift code is not correct.'
                    ]),
                ],
                'description' => ''
            ])

            ->add('iban', 'text',
                [
                    'constraints' => array(
                        new Callback(function($object, ExecutionContextInterface $context){
                            if (empty($context->getValue())) return false;

                            $iban = (string)$context->getValue();
                            $array = array();
                            $iban_replace_values = array();

                            # move first 4 chars to right
                            $left = substr($iban, 0, 4); # but set right-most 2 (checksum) to '00'
                            $right = substr($iban, 4);
                            # glue back together
                            $iban = $right . $left;

                            # Character substitution required for IBAN MOD97-10 checksum validation/generation
                            $iban_replace_chars = range('A','Z');
                            foreach (range(10, 35) as $tempvalue) {
                                $iban_replace_values[] = strval($tempvalue);
                            }
                            $iban = str_replace($iban_replace_chars, $iban_replace_values, $iban);

                            $length = mb_strlen($iban);
                            $size = 8;
                            $partsCount = ceil($length / $size);
                            $odd = 0;
                            # slice digits and calc a remainder
                            for ($i=0; $i < $partsCount; $i++) {
                                $part = (string)mb_substr($iban, $i * $size, $size);
                                $odd = (float)($odd . $part);
                                $odd = fmod($odd, 97);
                            }
                            if (1 != $odd) {
                                $context->buildViolation('IBAN is formed incorrectly.')
                                    ->atPath('iban')
                                    ->addViolation();
                            }

                        }),
                    )
                ]
            )
        ;

        $builder->get('file')->addModelTransformer(new Base64ToFileTransformer());

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection'   => false,
            'method' => 'PUT'
        ));
    }
}
