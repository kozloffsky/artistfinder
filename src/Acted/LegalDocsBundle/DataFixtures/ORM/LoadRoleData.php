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

class LoadRoleData extends AbstractFixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $artistRole = new RefRole();
        $artistRole->setCode('ROLE_ARTIST');
        $artistRole->setName('Artist');

        $clientRole = new RefRole();
        $clientRole->setCode('ROLE_CLIENT');
        $clientRole->setName('Client');

        $manager->persist($artistRole);
        $manager->persist($clientRole);
        $manager->flush();
    }
}