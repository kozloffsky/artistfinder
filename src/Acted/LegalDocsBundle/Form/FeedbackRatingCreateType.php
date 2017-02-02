<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Artist;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Range;

class FeedbackRatingCreateType extends AbstractType
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
                'constraints' => [new NotBlank(['message' => 'Event is required field'])],
                'description' => 'Event id'
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'constraints' => [new NotBlank(['message' => 'Artist is required field'])],
                'description' => 'ArtistId'
            ])
            ->add('rating', IntegerType::class, [
                'constraints' => [new Range([
                    'min' => 1,
                    'max' => 5,
                    'minMessage' => 'You should set only positive recommend value more or equal 1',
                    'maxMessage' => 'You should set only positive recommend value less or equal 5',
                ])]
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
            'csrf_protection'   => false,
            'method' => 'POST'
        ));
    }
}
