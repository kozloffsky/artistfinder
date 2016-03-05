<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 03.03.16
 * Time: 14:21
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\Event;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadEventData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
            $event = new Event();
            $event->setEventRef($faker->unique()->word);
            $event->setUser($this->getReference('user'));
            $event->setTitle($faker->text(100));
            $event->setDescription($faker->text);
            $event->setEventTypeId(1);
            $event->setIsInternational(true);
            $event->setAddress($faker->address);
            $event->setCity($this->getReference('city'));
            $event->setBudget($faker->randomFloat(null, 100, 10000));
            $event->setCurrencyId(1);
            $event->setStartingDate($faker->dateTime);
            $event->setEndingDate($faker->dateTime);
            $event->setTiming($faker->text(100));
            $event->setComments($faker->text);

            $manager->persist($event);
            $manager->flush();

            $this->addReference('event'.$i, $event);
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}