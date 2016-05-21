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
        ini_set("memory_limit","1024M");

        $faker = $this->container->get('davidbadura_faker.faker');
        $encoder = $this->container->get('security.password_encoder');

        $videoInfo1 = Embed::create('https://player.vimeo.com/video/17914974');
        preg_match('/src="(.+?)"/', $videoInfo1->getCode(), $videoLinkMatch1);

        $videoInfo2 = Embed::create('https://player.vimeo.com/video/17214458');
        preg_match('/src="(.+?)"/', $videoInfo2->getCode(), $videoLinkMatch2);

        $recommendedCategories = [
            $this->getReference('singers'),
            $this->getReference('acrobats'),
            $this->getReference('fire-show'),
        ];

        $cities = [];
        for ($i = 1; $i <= 33; $i++) {
            $cities[] = $this->getReference('city'.$i);
        }

        $categories = [
            $this->getReference('category1'),
            $this->getReference('category2'),
            $this->getReference('category3'),
            $this->getReference('category4'),
            $this->getReference('category5'),
            $this->getReference('category6'),
            $this->getReference('category_live_1'),
            $this->getReference('category_live_2'),
            $this->getReference('category_live_3'),
            $this->getReference('category_live_4'),
            $this->getReference('category_live_5'),
            $this->getReference('category_live_6'),
            $this->getReference('category_international_1'),
            $this->getReference('category_international_2'),
            $this->getReference('category_international_3'),
            $this->getReference('category_international_4'),
            $this->getReference('category_international_5'),
            $this->getReference('category_emcees_1'),
            $this->getReference('category_emcees_2'),
            $this->getReference('category_emcees_3'),
            $this->getReference('category_emcees_4'),
            $this->getReference('category_emcees_5'),
            $this->getReference('category_emcees_6'),
            $this->getReference('category_dance_1'),
            $this->getReference('category_dance_2'),
            $this->getReference('category_dance_3'),
        ];

        for ($i = 1; $i <= 33; $i++) {
            $cities[] = $this->getReference('city'.$i);
        }

        for ($i = 0; $i < 300; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setEmail($faker->unique()->email);
            $user->setPasswordHash($encoder->encodePassword($user, 'Aa123654'));
            $user->addRole($this->getReference('artistRole'));
            $user->setPrimaryPhone($faker->unique()->phoneNumber);
            $user->setActive(true);
            $user->setAvatar($faker->imageUrl);
            $user->setBackground($faker->imageUrl);
            $manager->persist($user);

            $this->addReference('user' . $i, $user);

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

            $manager->persist($photo1);
            $manager->persist($photo2);

            $profile = new Profile();
            $profile->setUser($user);
            $profile->setTitle($faker->word);
            $profile->setDescription($faker->text);
            $profile->setIsInternational(true);
            $profile->setPerformanceRange($faker->numberBetween(3, 10));
            $profile->setHeader($faker->word);
            $profile->setActive(true);
            $profile->setPaymentTypeId(1);

            $profile->addCategory($faker->randomElement($categories));

            $manager->persist($profile);

            $this->addReference('profile' . $i, $profile);

            $profile->addMedia($photo1);
            $profile->addMedia($photo2);

            if ($faker->boolean(30)) {
                $video1 = new Media();
                $video1->setName($faker->word);
                $video1->setMediaType('video');
                $video1->setLink('https://player.vimeo.com/video/17914974');
                $video1->setPosition(1);
                $video1->setActive(true);
                $manager->persist($video1);
                if (isset($videoLinkMatch[1])) {
                    $video1->setLink($videoLinkMatch[1]);
                }
                $video1->setThumbnail($videoInfo1->getImage());
                $profile->addMedia($video1);

                if ($faker->boolean(50)) {
                    $video2 = new Media();
                    $video2->setName($faker->word);
                    $video2->setMediaType('video');
                    $video2->setLink('https://player.vimeo.com/video/17214458');
                    $video2->setPosition(1);
                    $video2->setActive(true);
                    $manager->persist($video2);
                    if (isset($videoLinkMatch[1])) {
                        $video2->setLink($videoLinkMatch[1]);
                    }
                    $video2->setThumbnail($videoInfo2->getImage());
                    $profile->addMedia($video2);
                }
            }

            if ($faker->boolean(70)) {
                $audio1 = new Media();
                $audio1->setName($faker->word);
                $audio1->setMediaType('audio');
                $audio1->setLink('https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/257717036&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true');
                $audio1->setPosition(1);
                $audio1->setActive(true);

                $audio2 = new Media();
                $audio2->setName($faker->word);
                $audio2->setMediaType('audio');
                $audio2->setLink('https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/237603952&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true');
                $audio2->setPosition(1);
                $audio2->setActive(true);

                $manager->persist($audio1);
                $manager->persist($audio2);

                $profile->addMedia($audio1);
                $profile->addMedia($audio2);
            }


            if ($i == 1) {
                $photoForSpotlights = range(1, 9);
                foreach ($photoForSpotlights as $spotlight) {
                    $spotlightMedia = new Media();
                    $spotlightMedia->setName($spotlight . '.jpg');
                    $spotlightMedia->setMediaType('photo');
                    $spotlightMedia->setLink('assets/images/slider/' . $spotlight . '.jpg');
                    $spotlightMedia->setPosition(1);
                    $spotlightMedia->setActive(true);
                    $profile->addMedia($spotlightMedia);
                    $manager->persist($spotlightMedia);
                    $this->setReference('spotlight' . $spotlight, $spotlightMedia);
                }
            }

            $this->setReference('photo1', $photo1);
            $this->setReference('photo2', $photo2);

            $artist = new Artist();
            $artist->setName($faker->unique()->name);
            $artist->setSlug($artist->getName());
            $artist->setUser($user);

            $artist->setCity($faker->randomElement($cities));

            if ($faker->boolean(40)) {
                $artist->setRecommend(rand(0, 100));
                $profile->addCategory($faker->randomElement($recommendedCategories));
            }


            $manager->persist($artist);
            $manager->flush();

            $this->setReference('artist' . $i, $artist);
        }
    }

    public function getOrder()
    {
        return 3;
    }
}