<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.04.16
 * Time: 1:40
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Entity\RefRegion;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGeoData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $country1 = $this->getReference('uk');

        $region1 = new RefRegion();
        $region1->setName('Oxford');
        $region1->setCountry($country1);
        $region2 = new RefRegion();
        $region2->setName('Reading');
        $region2->setCountry($country1);
        $region3 = new RefRegion();
        $region3->setName('Brighton');
        $region3->setCountry($country1);

        $manager->persist($country1);
        $manager->persist($region1);
        $manager->persist($region2);
        $manager->persist($region3);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 8;
    }
}