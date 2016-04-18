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
        $photoForSpotlights = range(1, 9);
        foreach ($photoForSpotlights as $spotlightId) {
            $spotlight = new Homespotlight();
            $spotlight->setMedia($this->getReference('spotlight'.$spotlightId));
            $manager->persist($spotlight);
        }
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