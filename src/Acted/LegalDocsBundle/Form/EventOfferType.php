<?php

namespace Acted\LegalDocsBundle\Form;

use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Entity\RefCity;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Entity\RefEventType;
use Acted\LegalDocsBundle\Entity\RefVenueType;
use Acted\LegalDocsBundle\Popo\EventOfferData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Count;

class EventOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('event_date', DateType::class, [
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'constraints' => [new NotBlank()],
                'description' => 'Event date by format dd/MM/yyyy',
            ])
            ->add('event_time', TextType::class)
            ->add('type', EntityType::class, [
                'class' => RefEventType::class,
                'constraints' => [new NotBlank()],
                'description' => 'Type of event'
            ])
            ->add('country', EntityType::class, [
                'class' => RefCountry::class,
                'constraints' => [new NotBlank()],
                'description' => 'Country ID',
            ])
            ->add('city', EntityType::class, [
                'class' => RefCity::class,
                'constraints' => [new NotBlank()],
                'description' => 'City ID',
            ])
            ->add('location', TextType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('venue_type', EntityType::class, [
                'class' => RefVenueType::class,
                'description' => 'Venue type ID',
            ])
            ->add('number_of_guests', ChoiceType::class, [
                'choices_as_values' => true,
                'choices' => [
                    EventOfferData::NUMBER_OF_GUEST_MAX_50,
                    EventOfferData::NUMBER_OF_GUEST_MIN_50_MAX_100,
                    EventOfferData::NUMBER_OF_GUEST_MIN_100_MAX_500,
                    EventOfferData::NUMBER_OF_GUEST_MORE_500
                ],
                'constraints' => [new NotBlank()],
                'description' => 'Number of guests',
            ])
            ->add('performance', EntityType::class, [
                'class' => Performance::class,
                'multiple' => true,
                'constraints' => [new Count(['min' => 1])],
                'description' => 'Array of Performances IDs'
            ])
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'required' => false,
                'description' => 'Events if user auth and have some event'
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'description' => 'UserId'
            ])
            ->add('comment', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventOfferData::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'cascade_validation' => true,
        ]);

    }

    public function getBlockPrefix()
    {
        return null;
    }
}