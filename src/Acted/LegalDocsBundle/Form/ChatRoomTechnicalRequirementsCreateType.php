<?php

namespace Acted\LegalDocsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Acted\LegalDocsBundle\Entity\ChatRoom;
use Acted\LegalDocsBundle\Entity\TechnicalRequirement;
use Acted\LegalDocsBundle\Entity\RequestQuotation;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChatRoomTechnicalRequirementsCreateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chat_room', EntityType::class, [
                'class' => ChatRoom::class,
                'constraints' => [new NotBlank(['message' => 'Chat room is required field'])],
                'description' => 'ChatRoomId'
            ])
            ->add('technical_requirement', EntityType::class, [
                'class' => TechnicalRequirement::class,
                'constraints' => [new NotBlank(['message' => 'Technical requirement is required field'])],
                'description' => 'TechnicalRequirementId'
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
