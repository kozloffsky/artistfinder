<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 15.03.16
 * Time: 11:53
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\RefRole;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        ini_set("memory_limit","1024M");

        $artistRole = new RefRole();
        $artistRole->setCode('ROLE_ARTIST');
        $artistRole->setName('Artist');

        $clientRole = new RefRole();
        $clientRole->setCode('ROLE_CLIENT');
        $clientRole->setName('Client');

        $manager->persist($artistRole);
        $manager->persist($clientRole);
        $this->addReference('artistRole', $artistRole);
        $this->addReference('clientRole', $clientRole);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}