<?php

/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.03.16
 * Time: 15:57
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Entity\Profile;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Entity\RefCity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadArtistData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $faker = $this->container->get('davidbadura_faker.faker');

        $user = new User();
        $user->setFirstname($faker->firstName);
        $user->setLastname($faker->lastName);
        $user->setEmail($faker->email);
        $user->setPasswordHash(md5($faker->password));
        $user->setPrimaryPhone($faker->phoneNumber);
        $user->setActive(true);
        $user->setAvatar($faker->imageUrl);
        $user->setBackground($faker->imageUrl);
        $manager->persist($user);
        $manager->flush();

        $media1 = new Media();
        $media1->setName($faker->word);
        $media1->setMediaType('photo');
        $media1->setLink($faker->imageUrl);
        $media1->setPosition(1);
        $media1->setActive(true);
        $media2 = new Media();
        $media2->setName($faker->word);
        $media2->setMediaType('photo');
        $media2->setLink($faker->imageUrl);
        $media2->setPosition(1);
        $media2->setActive(true);
        $manager->persist($media1);
        $manager->persist($media2);
        $manager->flush();


        $city = new RefCity();
        $city->setName($faker->city);
        $city->setCountryId(1);
        $manager->persist($city);
        $manager->flush();

        $artist = new Artist();
        $artist->setName($faker->name);
        $artist->setUserId($user->getId());
        $artist->setCity($city);
        $manager->persist($artist);
        $manager->flush();
    }


}