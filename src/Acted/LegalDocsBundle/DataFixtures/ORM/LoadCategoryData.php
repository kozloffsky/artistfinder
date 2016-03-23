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
        $varietyActsCategory->setBackground($faker->imageUrl);

        $subCategory1 = new Category();
        $subCategory1->setTitle($faker->unique()->text(10));
        $subCategory1->setSlug($subCategory1->getTitle());
        $subCategory1->setParent($varietyActsCategory);
        $subCategory1->setBackground($faker->imageUrl);

        $subCategory2 = new Category();
        $subCategory2->setTitle($faker->unique()->text(10));
        $subCategory2->setSlug($subCategory2->getTitle());
        $subCategory2->setParent($varietyActsCategory);
        $subCategory2->setBackground($faker->imageUrl);

        $internationalArtists = new Category();
        $internationalArtists->setTitle('International Artists');
        $internationalArtists->setDescription($faker->realText(400));
        $internationalArtists->setSlug($internationalArtists->getTitle());
        $internationalArtists->setImage('assets/images/international.png');
        $internationalArtists->setBackground($faker->imageUrl);

        $subCategory3 = new Category();
        $subCategory3->setTitle($faker->unique()->text(10));
        $subCategory3->setSlug($subCategory3->getTitle());
        $subCategory3->setParent($internationalArtists);
        $subCategory3->setBackground($faker->imageUrl);

        $subCategory4 = new Category();
        $subCategory4->setTitle($faker->unique()->text(10));
        $subCategory4->setSlug($subCategory4->getTitle());
        $subCategory4->setParent($internationalArtists);
        $subCategory4->setBackground($faker->imageUrl);


        $manager->persist($varietyActsCategory);
        $manager->persist($internationalArtists);
        $manager->persist($subCategory1);
        $manager->persist($subCategory2);
        $manager->persist($subCategory3);
        $manager->persist($subCategory4);
        $manager->flush();

        $this->addReference('category1', $varietyActsCategory);
        $this->addReference('category2', $internationalArtists);
        $this->addReference('category3', $subCategory1);
        $this->addReference('category4', $subCategory2);
        $this->addReference('category5', $subCategory3);
        $this->addReference('category6', $subCategory4);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}