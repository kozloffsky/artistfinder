<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.04.16
 * Time: 1:14
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\RefCity;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCityData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $city1 = new RefCity();
        $london = $this->getReference('london');
        $city1->setName('London');
        $city1->setRegion($london);

        $city2 = new RefCity();
        $ildefrance = $this->getReference('ile-de-france');
        $city2->setName('Paris');
        $city2->setRegion($ildefrance);

        $city3 = new RefCity();
        $berlin = $this->getReference('berlin');
        $city3->setName('Berlin');
        $city3->setRegion($berlin);

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
        return 9;
    }
}