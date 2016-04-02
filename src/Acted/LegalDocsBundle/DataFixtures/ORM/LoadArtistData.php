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
use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Entity\RefCity;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Embed\Embed;
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
        $encoder = $this->container->get('security.password_encoder');

        $user = new User();
        $user->setFirstname($faker->firstName);
        $user->setLastname($faker->lastName);
        $user->setEmail($faker->unique()->email);
        $user->setPasswordHash($encoder->encodePassword($user, 'Aa123654'));
        $user->setPrimaryPhone($faker->unique()->phoneNumber);
        $user->setActive(true);
        $user->setAvatar($faker->imageUrl);
        $user->setBackground($faker->imageUrl);
        $manager->persist($user);

        $this->addReference('user', $user);

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

        $videoInfo = Embed::create('https://player.vimeo.com/video/17914974');
        preg_match('/src="(.+?)"/', $videoInfo->getCode(), $videoLinkMatch);
        if(isset($videoLinkMatch[1])){
            $video1->setLink($videoLinkMatch[1]);
        }
        $video1->setThumbnail($videoInfo->getImage());

        $video2 = new Media();
        $video2->setName($faker->word);
        $video2->setMediaType('video');
        $video2->setLink('https://player.vimeo.com/video/17214458');
        $video2->setPosition(1);
        $video2->setActive(true);

        $videoInfo = Embed::create('https://player.vimeo.com/video/17214458');
        preg_match('/src="(.+?)"/', $videoInfo->getCode(), $videoLinkMatch);
        if(isset($videoLinkMatch[1])){
            $video2->setLink($videoLinkMatch[1]);
        }
        $video2->setThumbnail($videoInfo->getImage());

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

        $profile->addCategory($this->getReference('category3'));
        $profile->addCategory($this->getReference('category4'));
        $profile->addCategory($this->getReference('category5'));

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

        $photoForSpotlights = range(1, 9);
        foreach ($photoForSpotlights as $spotlight) {
            $spotlightMedia = new Media();
            $spotlightMedia->setName($spotlight.'.jpg');
            $spotlightMedia->setMediaType('photo');
            $spotlightMedia->setLink('assets/images/slider/'.$spotlight.'.jpg');
            $spotlightMedia->setPosition(1);
            $spotlightMedia->setActive(true);
            $profile->addMedia($spotlightMedia);
            $manager->persist($spotlightMedia);
            $manager->flush();
            $this->addReference('spotlight'.$spotlight, $spotlightMedia);
        }


        $this->addReference('photo1', $photo1);
        $this->addReference('photo2', $photo2);

        $france = new RefCountry();
        $france->setName('France');
        $uk = new RefCountry();
        $uk->setName('United Kingdom');
        $germany = new RefCountry();
        $germany->setName('Germany');

        $manager->persist($france);
        $manager->persist($uk);
        $manager->persist($germany);
        $manager->flush();

        $this->addReference('uk', $uk);
        $this->addReference('germany', $germany);
        $this->addReference('france', $france);

        $city = new RefCity();
        $city->setName($faker->city);
        $city->setCountryId(1);
        $manager->persist($city);
        $manager->flush();

        $this->addReference('city', $city);

        $artist = new Artist();
        $artist->setName($faker->name);
        $artist->setSlug($artist->getName());
        $artist->setUser($user);
        $artist->setCity($city);
        $manager->persist($artist);
        $manager->flush();

        $this->addReference('artist', $artist);
    }

    public function getOrder()
    {
        return 2;
    }
}