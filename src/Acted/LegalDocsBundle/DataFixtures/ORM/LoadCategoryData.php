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
use Symfony\Component\HttpFoundation\Request;

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
        ini_set("memory_limit","1024M");

        for ($i=1; $i < 31; $i++) {
            $imagePath = '/images/'. $i . '.jpg';
            $this->container->get('liip_imagine.controller')->filterAction(new Request(), $imagePath, 'small');
            $this->container->get('liip_imagine.controller')->filterAction(new Request(), $imagePath, 'medium');
        }

        $faker = $this->container->get('davidbadura_faker.faker');

        $categoryDescription = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
        do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.';

        $varietyActsCategory = new Category();
        $varietyActsCategory->setTitle('Variety Acts');
        $varietyActsCategory->setDescription($categoryDescription);
        $varietyActsCategory->setSlug($varietyActsCategory->getTitle());
        $varietyActsCategory->setImage('assets/images/variety_acts.png');
        $varietyActsCategory->setBackground('assets/images/VarietyActs.jpg');
        $manager->persist($varietyActsCategory);

        $acrobats = new Category();
        $acrobats->setTitle('Acrobats');
        $acrobats->setSlug($acrobats->getTitle());
        $acrobats->setParent($varietyActsCategory);
        $acrobats->setRecommend(true);
        $manager->persist($acrobats);
        $this->setReference('acrobats', $acrobats);

        $fireShow = new Category();
        $fireShow->setTitle('Fire Show');
        $fireShow->setSlug($fireShow->getTitle());
        $fireShow->setParent($varietyActsCategory);
        $fireShow->setRecommend(true);
        $manager->persist($fireShow);
        $this->setReference('fire-show', $fireShow);

        $subCategories = range(1, 6);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Sub-category '.$subCategoryId);
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($varietyActsCategory);
            $manager->persist($subCategory);
            $this->addReference('category'.$subCategoryId, $subCategory);
        }

        $liveMusic = new Category();
        $liveMusic->setTitle('Live Music');
        $liveMusic->setDescription($categoryDescription);
        $liveMusic->setSlug($liveMusic->getTitle());
        $liveMusic->setImage('assets/images/live_music.png');
        $liveMusic->setBackground('assets/images/LiveMusic.jpg');
        $manager->persist($liveMusic);

        $subCategories = range(1, 6);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Sub-category '.$subCategoryId);
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($liveMusic);
            $this->addReference('category_live_'.$subCategoryId, $subCategory);
            $manager->persist($subCategory);
        }

        $singers = new Category();
        $singers->setTitle('Singers');
        $singers->setSlug($singers->getTitle());
        $singers->setParent($liveMusic);
        $singers->setRecommend(true);
        $manager->persist($singers);
        $this->setReference('singers', $singers);


        $internationalArtists = new Category();
        $internationalArtists->setTitle('International Artists');
        $internationalArtists->setDescription($categoryDescription);
        $internationalArtists->setSlug($internationalArtists->getTitle());
        $internationalArtists->setImage('assets/images/international.png');
        $internationalArtists->setBackground('assets/images/InternationalShow.jpeg');
        $manager->persist($internationalArtists);

        $subCategories = range(1, 5);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Sub-category '.$subCategoryId);
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($internationalArtists);
            $this->addReference('category_international_'.$subCategoryId, $subCategory);
            $manager->persist($subCategory);
        }

        $emcees = new Category();
        $emcees->setTitle('Emcees & Comedians');
        $emcees->setSlug($emcees->getTitle());
        $emcees->setDescription($categoryDescription);
        $emcees->setImage('assets/images/comedian.png');
        $emcees->setBackground('assets/images/EMCEEComedian.jpeg');
        $manager->persist($emcees);

        $subCategories = range(1, 6);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Sub-category '.$subCategoryId);
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($emcees);
            $this->addReference('category_emcees_'.$subCategoryId, $subCategory);
            $manager->persist($subCategory);
        }

        $dance = new Category();
        $dance->setTitle('Musical and Dance Acts');
        $dance->setSlug($dance->getTitle());
        $dance->setDescription($categoryDescription);
        $dance->setImage('assets/images/musicalDanceActs.png');
        $dance->setBackground('assets/images/DanceActs.jpg');
        $manager->persist($dance);

        $subCategories = range(1, 3);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Sub-category '.$subCategoryId);
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($dance);
            $this->addReference('category_dance_'.$subCategoryId, $subCategory);
            $manager->persist($subCategory);
        }


        $children = new Category();
        $children->setTitle('Children Entertainment');
        $children->setSlug($children->getTitle());
        $children->setDescription($categoryDescription);
        $children->setImage('assets/images/childrenEntertainment.png');
        $children->setBackground('assets/images/ChildrenEntertainment.jpg');
        $manager->persist($children);

        $subCategories = range(1, 6);
        foreach ($subCategories as $subCategoryId) {
            $subCategory = new Category();
            $subCategory->setTitle('Sub-category '.$subCategoryId);
            $subCategory->setSlug($faker->unique()->text(10));
            $subCategory->setParent($children);
            $this->addReference('category_children_'.$subCategoryId, $subCategory);
            $manager->persist($subCategory);
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