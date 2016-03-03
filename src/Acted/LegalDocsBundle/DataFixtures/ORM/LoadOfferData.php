<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 03.03.16
 * Time: 12:49
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\Offer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadOfferData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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

        for($i = 0; $i < 10; $i++) {
            $performance = $this->getReference('performance'.$i);

            for($j = 0; $j < 5; $j++) {
                $offer = new Offer();
                $offer->setPerformance($performance);
                $offer->setTitle($faker->text(100));
                $offer->setPrice($faker->randomFloat(null, 10, 10000));
                $offer->setCurrencyId(1);
                $offer->setDepositValue($faker->randomFloat(null, 1, 100));
                $offer->setDepositType($faker->word);
                $offer->setPaymentTerms($faker->text);
                $offer->setComments($faker->text);

                $manager->persist($offer);
                $manager->flush();
            }
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}