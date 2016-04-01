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
use Doctrine\Common\Persistence\ObjectManager;

class LoadCityData extends AbstractFixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $city1 = new RefCity();
        $city1->setCountryId(1);
        $city1->setName('London');

        $city2 = new RefCity();
        $city2->setCountryId(2);
        $city2->setName('Paris');

        $city3 = new RefCity();
        $city3->setCountryId(3);
        $city3->setName('Berlin');

        $manager->persist($city1);
        $manager->persist($city2);
        $manager->persist($city3);

        $manager->flush();
    }
}