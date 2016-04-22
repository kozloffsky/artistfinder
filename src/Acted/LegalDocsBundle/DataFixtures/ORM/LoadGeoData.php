<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.04.16
 * Time: 1:40
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\RefCity;
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
        $france = new RefCountry();
        $france->setName('France');
        $uk = new RefCountry();
        $uk->setName('United Kingdom');
        $germany = new RefCountry();
        $germany->setName('Germany');

        $region1 = new RefRegion();
        $region1->setName('Oxford');
        $region1->setCountry($uk);
        $region2 = new RefRegion();
        $region2->setName('Reading');
        $region2->setCountry($uk);
        $region3 = new RefRegion();
        $region3->setName('Brighton');
        $region3->setCountry($uk);
        $london = new RefRegion();
        $london->setName('London');
        $london->setCountry($uk);

        $region4 = new RefRegion();
        $region4->setName('Baden-Württemberg');
        $region4->setCountry($germany);
        $region5 = new RefRegion();
        $region5->setName('Bavaria');
        $region5->setCountry($germany);
        $region6 = new RefRegion();
        $region6->setName('Hesse');
        $region6->setCountry($germany);
        $berlin = new RefRegion();
        $berlin->setName('Berlin');
        $berlin->setCountry($germany);

        $region7 = new RefRegion();
        $region7->setName('Brittany');
        $region7->setCountry($france);
        $region8 = new RefRegion();
        $region8->setName('Corsica');
        $region8->setCountry($france);
        $region9 = new RefRegion();
        $region9->setName('Île-de-France');
        $region9->setCountry($france);

        $manager->persist($uk);
        $manager->persist($germany);
        $manager->persist($france);

        $this->addReference('uk', $uk);
        $this->addReference('germany', $germany);
        $this->addReference('france', $france);

        $manager->persist($region1);
        $manager->persist($region2);
        $manager->persist($region3);
        $manager->persist($region4);
        $manager->persist($region5);
        $manager->persist($region6);
        $manager->persist($region7);
        $manager->persist($region8);
        $manager->persist($region9);
        $manager->persist($london);
        $manager->persist($berlin);

        $this->addReference('london', $london);
        $this->addReference('berlin', $berlin);
        $this->addReference('ile-de-france', $region9);

        $city1 = new RefCity();
        $city1->setName('London');
        $city1->setRegion($london);

        $city2 = new RefCity();
        $city2->setName('Paris');
        $city2->setRegion($region9);

        $city3 = new RefCity();
        $city3->setName('Berlin');
        $city3->setRegion($berlin);

        $this->addReference('city1', $city1);
        $this->addReference('city2', $city2);
        $this->addReference('city3', $city3);


        $manager->persist($city1);
        $manager->persist($city2);
        $manager->persist($city3);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}