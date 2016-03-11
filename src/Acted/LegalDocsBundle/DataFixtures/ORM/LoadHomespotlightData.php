<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 12.03.16
 * Time: 1:39
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\Homespotlight;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadHomespotlightData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $spotlight1 = new Homespotlight();
        $spotlight1->setMedia($this->getReference('photo1'));

        $spotlight2 = new Homespotlight();
        $spotlight2->setMedia($this->getReference('photo2'));

        $manager->persist($spotlight1);
        $manager->persist($spotlight2);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 7;
    }
}