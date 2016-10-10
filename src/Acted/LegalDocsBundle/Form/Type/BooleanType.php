<?php
namespace Acted\LegalDocsBundle\Form\Type;

use Acted\LegalDocsBundle\Form\DataTransformer\BooleanDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BooleanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new BooleanDataTransformer());
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'boolean';
    }
}