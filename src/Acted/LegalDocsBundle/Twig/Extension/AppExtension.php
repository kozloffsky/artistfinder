<?php

namespace Acted\LegalDocsBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;

class AppExtension extends \Twig_Extension
{

    /** @var  ObjectManager */
    private $manager;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app';
    }

    public function setEntityManager(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function getFunctions()
    {
        return [
            'categories' => new \Twig_SimpleFunction('categories', [$this, 'renderCategories'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
            'countries' => new \Twig_SimpleFunction('countries', [$this, 'getCountries']),
        ];
    }

    public function renderCategories(\Twig_Environment $twig)
    {
        $categoriesRepo = $this->manager->getRepository('ActedLegalDocsBundle:Category');
        $categories = $categoriesRepo->childrenHierarchy();
        return $twig->render('ActedLegalDocsBundle:Default:categories.html.twig', compact('categories'));
    }

    public function getCountries()
    {
        return $this->manager->getRepository('ActedLegalDocsBundle:RefCountry')->findAll();
    }

}
