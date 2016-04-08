<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 05.03.16
 * Time: 14:42
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCategoryData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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

        $varietyActsCategory = new Category();
        $varietyActsCategory->setTitle('Variety Acts');
        $varietyActsCategory->setDescription($faker->realText(400));
        $varietyActsCategory->setSlug($varietyActsCategory->getTitle());
        $varietyActsCategory->setImage('assets/images/variety_acts.png');
        $varietyActsCategory->setBackground('assets/images/VarietyActs.jpg');
        $manager->persist($varietyActsCategory);

        $subCategories = range(1, 6);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Lorem ipsum');
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($varietyActsCategory);
            $manager->persist($subCategory);
            $manager->flush();
            $this->addReference('category'.$subCategoryId, $subCategory);
        }

        $liveMusic = new Category();
        $liveMusic->setTitle('Live Music');
        $liveMusic->setSlug($liveMusic->getTitle());
        $liveMusic->setImage('assets/images/live_music.png');
        $liveMusic->setBackground('assets/images/LiveMusic.jpg');
        $manager->persist($liveMusic);

        $subCategories = range(1, 6);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Lorem ipsum');
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($liveMusic);
            $manager->persist($subCategory);
            $manager->flush();
        }


        $internationalArtists = new Category();
        $internationalArtists->setTitle('International Artists');
        $internationalArtists->setDescription($faker->realText(400));
        $internationalArtists->setSlug($internationalArtists->getTitle());
        $internationalArtists->setImage('assets/images/international.png');
        $internationalArtists->setBackground('assets/images/InternationalShow.jpeg');
        $manager->persist($internationalArtists);

        $subCategories = range(1, 5);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Lorem ipsum');
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($internationalArtists);
            $manager->persist($subCategory);
            $manager->flush();
        }

        $emcees = new Category();
        $emcees->setTitle('Emcees & Comedians');
        $emcees->setSlug($emcees->getTitle());
        $emcees->setImage('assets/images/comedian.png');
        $emcees->setBackground('assets/images/EMCEEComedian.jpeg');
        $manager->persist($emcees);

        $subCategories = range(1, 6);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Lorem ipsum');
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($emcees);
            $manager->persist($subCategory);
            $manager->flush();
        }

        $dance = new Category();
        $dance->setTitle('Musical and Dance Acts');
        $dance->setSlug($dance->getTitle());
        $dance->setImage('assets/images/musicalDanceActs.png');
        $dance->setBackground('assets/images/DanceActs.jpg');
        $manager->persist($dance);

        $subCategories = range(1, 3);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Lorem ipsum');
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($internationalArtists);
            $manager->persist($subCategory);
            $manager->flush();
        }


        $children = new Category();
        $children->setTitle('Children Entertainment');
        $children->setSlug($children->getTitle());
        $children->setImage('assets/images/childrenEntertainment.png');
        $children->setBackground('assets/images/ChildrenEntertainment.jpg');
        $manager->persist($children);

        $subCategories = range(1, 6);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Lorem ipsum');
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($children);
            $manager->persist($subCategory);
            $manager->flush();
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
        return 2;
    }
}