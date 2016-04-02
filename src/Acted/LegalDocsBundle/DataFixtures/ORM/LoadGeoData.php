<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.04.16
 * Time: 1:40
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


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

        $country2 = $this->getReference('germany');

        $region4 = new RefRegion();
        $region4->setName('Baden-Württemberg');
        $region4->setCountry($country2);
        $region5 = new RefRegion();
        $region5->setName('Bavaria');
        $region5->setCountry($country2);
        $region6 = new RefRegion();
        $region6->setName('Hesse');
        $region6->setCountry($country2);

        $country3 = $this->getReference('france');

        $region7 = new RefRegion();
        $region7->setName('Brittany');
        $region7->setCountry($country3);
        $region8 = new RefRegion();
        $region8->setName('Corsica');
        $region8->setCountry($country3);
        $region9 = new RefRegion();
        $region9->setName('Île-de-France');
        $region9->setCountry($country3);

        $manager->persist($country1);
        $manager->persist($country2);
        $manager->persist($country3);
        $manager->persist($region1);
        $manager->persist($region2);
        $manager->persist($region3);
        $manager->persist($region4);
        $manager->persist($region5);
        $manager->persist($region6);
        $manager->persist($region7);
        $manager->persist($region8);
        $manager->persist($region9);

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