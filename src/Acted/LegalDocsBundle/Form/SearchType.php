<?php

namespace Acted\LegalDocsBundle\Form;

use Acted\LegalDocsBundle\Entity\Category;
use Acted\LegalDocsBundle\Entity\RefCity;
use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Entity\RefRegion;
use Acted\LegalDocsBundle\Search\FilterCriteria;
use Acted\LegalDocsBundle\Search\OrderCriteria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

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
            ->add('country', EntityType::class, ['class' => RefCountry::class])
            ->add('region', EntityType::class, ['class' => RefRegion::class])
            ->add('query', TextType::class, ['required' => false])
            ->add('distance', ChoiceType::class,
                ['choices' => [FilterCriteria::DISTANCE_0_50, FilterCriteria::DISTANCE_0_100, FilterCriteria::DISTANCE_0_200, FilterCriteria::DISTANCE_ANY],
                'choices_as_values' => true]
            )

            ->add('location', ChoiceType::class,[
                'choices' => [FilterCriteria::LOCATION_100_KM, FilterCriteria::LOCATION_SAME_COUNTRY, FilterCriteria::LOCATION_INTERNATIONAL],
                'choices_as_values' => true,
            ])

            ->add('order', ChoiceType::class, [
                'choices' => [OrderCriteria::CHEAPEST, OrderCriteria::MORE_EXPENSIVE, OrderCriteria::LOWEST_RATED, OrderCriteria::TOP_RATED],
                'choices_as_values' => true,
            ])

            ->add('user_city', EntityType::class, [
                'constraints' => [new NotBlank(['groups' => 'distance'])],
                'class' => RefCity::class,
            ])
            ->add('page', IntegerType::class)
            ->add('with_video', ChoiceType::class, ['choices_as_values' => true, 'choices' => [true, false]])
            ->add('recommended', ChoiceType::class, ['choices_as_values' => true, 'choices' => [true, false]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'method' => 'GET',
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();
                if (isset($data['distance']) && $data['distance']) {
                    return ['Default', 'distance'];
                }

                if (isset($data['location'])
                    && in_array($data['location'], [FilterCriteria::LOCATION_SAME_COUNTRY, FilterCriteria::LOCATION_100_KM])) {
                    return ['Default', 'distance'];
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
