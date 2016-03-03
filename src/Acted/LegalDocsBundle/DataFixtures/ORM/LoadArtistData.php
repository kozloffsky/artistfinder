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
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadArtistData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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

        $photo1 = new Media();
        $photo1->setName($faker->word);
        $photo1->setMediaType('photo');
        $photo1->setLink($faker->imageUrl);
        $photo1->setPosition(1);
        $photo1->setActive(true);

        $photo2 = new Media();
        $photo2->setName($faker->word);
        $photo2->setMediaType('photo');
        $photo2->setLink($faker->imageUrl);
        $photo2->setPosition(1);
        $photo2->setActive(true);

        $video1 = new Media();
        $video1->setName($faker->word);
        $video1->setMediaType('video');
        $video1->setLink('https://player.vimeo.com/video/17914974');
        $video1->setPosition(1);
        $video1->setActive(true);

        $video2 = new Media();
        $video2->setName($faker->word);
        $video2->setMediaType('video');
        $video2->setLink('https://player.vimeo.com/video/17214458');
        $video2->setPosition(1);
        $video2->setActive(true);

        $audio1 = new Media();
        $audio1->setName($faker->word);
        $audio1->setMediaType('audio');
        $audio1->setLink('http://www.noiseaddicts.com/samples_1w72b820/3828.mp3');
        $audio1->setPosition(1);
        $audio1->setActive(true);

        $audio2 = new Media();
        $audio2->setName($faker->word);
        $audio2->setMediaType('audio');
        $audio2->setLink('http://www.noiseaddicts.com/samples_1w72b820/22.mp3');
        $audio2->setPosition(1);
        $audio2->setActive(true);

        $manager->persist($photo1);
        $manager->persist($photo2);
        $manager->persist($video1);
        $manager->persist($video2);
        $manager->persist($audio1);
        $manager->persist($audio2);
        $manager->flush();

        $profile = new Profile();
        $profile->setUser($user);
        $profile->setTitle($faker->word);
        $profile->setDescription($faker->text);
        $profile->setIsInternational(true);
        $profile->setPerformanceRange($faker->numberBetween(3, 10));
        $profile->setHeader($faker->word);
        $profile->setActive(true);
        $profile->setPaymentTypeId(1);
        $manager->persist($profile);
        $manager->flush();

        $this->addReference('profile', $profile);

        $profile->addMedia($photo1);
        $profile->addMedia($photo2);
        $profile->addMedia($video1);
        $profile->addMedia($video2);
        $profile->addMedia($audio1);
        $profile->addMedia($audio2);
        $manager->flush();


        $city = new RefCity();
        $city->setName($faker->city);
        $city->setCountryId(1);
        $manager->persist($city);
        $manager->flush();

        $this->addReference('city', $city);

        $artist = new Artist();
        $artist->setName($faker->name);
        $artist->setUser($user);
        $artist->setCity($city);
        $manager->persist($artist);
        $manager->flush();

        $this->addReference('artist', $artist);
    }

    public function getOrder()
    {
        return 1;
    }
}