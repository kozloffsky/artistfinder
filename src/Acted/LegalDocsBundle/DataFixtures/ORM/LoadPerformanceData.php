<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 03.03.16
 * Time: 12:30
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Entity\Performance;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPerformanceData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = $this->container->get('davidbadura_faker.faker');

        $profile = $this->getReference('profile');

        for($i=0; $i < 10; $i++) {
            $performance = new Performance();
            $performance->setTitle($faker->word);
            $performance->setProfile($profile);
            $performance->setTechRequirement($faker->text);

            $manager->persist($performance);
            $manager->flush();

            $photo1 = new Media();
            $photo1->setName($faker->word);
            $photo1->setMediaType('photo');
            $photo1->setLink($faker->imageUrl);
            $photo1->setPosition(1);
            $photo1->setActive(true);

            $video1 = new Media();
            $video1->setName($faker->word);
            $video1->setMediaType('video');
            $video1->setLink('https://player.vimeo.com/video/17914974');
            $video1->setPosition(1);
            $video1->setActive(true);

            $photo2 = new Media();
            $photo2->setName($faker->word);
            $photo2->setMediaType('photo');
            $photo2->setLink($faker->imageUrl);
            $photo2->setPosition(1);
            $photo2->setActive(true);

            $manager->persist($photo1);
            $manager->persist($photo2);
            $manager->persist($video1);

            $performance->addMedia($photo1);
            $performance->addMedia($photo2);
            $performance->addMedia($video1);

            $manager->flush();

            $this->addReference('performance'.$i, $performance);
        }
    }

    public function getOrder()
    {
        return 2;
    }
}