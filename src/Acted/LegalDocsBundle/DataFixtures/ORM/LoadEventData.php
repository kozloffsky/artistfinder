<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 03.03.16
 * Time: 14:21
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;

use Acted\LegalDocsBundle\Entity\EventOffer;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\RefEventType;
use Acted\LegalDocsBundle\Entity\RefVenueType;
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


        $corporate = new RefEventType();
        $corporate->setEventType('Corporate event');
        $manager->persist($corporate);

        $this->addReference('eventType', $corporate);

        $conference = new RefEventType();
        $conference->setEventType('Conference/Trade show');
        $manager->persist($conference);

        $privateParty = new RefEventType();
        $privateParty->setEventType('Private party');
        $manager->persist($privateParty);

        $wedding = new RefEventType();
        $wedding->setEventType('Wedding');
        $manager->persist($wedding);

        $childrenParty = new RefEventType();
        $childrenParty->setEventType('Children party');
        $manager->persist($childrenParty);

        $productActivation = new RefEventType();
        $productActivation->setEventType('Product activation');
        $manager->persist($productActivation);

        $awardCeremony = new RefEventType();
        $awardCeremony->setEventType('Award ceremony');
        $manager->persist($awardCeremony);

        $publicEvent = new RefEventType();
        $publicEvent->setEventType('Public event');
        $manager->persist($publicEvent);

        $concert = new RefEventType();
        $concert->setEventType('Concert/Festival');
        $manager->persist($concert);

        $other = new RefEventType();
        $other->setEventType('Other');
        $manager->persist($other);

        $otherVenue = new RefVenueType();
        $otherVenue->setVenueType('Other');
        $manager->persist($otherVenue);

        $hotelBallroom = new RefVenueType();
        $hotelBallroom->setVenueType('Hotel Ballroom');
        $manager->persist($hotelBallroom);

        $outdoor = new RefVenueType();
        $outdoor->setVenueType('Outdoor');
        $manager->persist($outdoor);

        $townHall = new RefVenueType();
        $townHall->setVenueType('Town hall');
        $manager->persist($townHall);
        $this->addReference('venueType', $townHall);

        $residence = new RefVenueType();
        $residence->setVenueType('Residence');
        $manager->persist($residence);

        $restaurant = new RefVenueType();
        $restaurant->setVenueType('Restaurant');
        $manager->persist($restaurant);

        $barClub = new RefVenueType();
        $barClub->setVenueType('Bar/Club');
        $manager->persist($barClub);

        $mall = new RefVenueType();
        $mall->setVenueType('Mall');
        $manager->persist($mall);

        $office = new RefVenueType();
        $office->setVenueType('Office');
        $manager->persist($office);

        $manager->flush();

        for ($i = 0; $i < 300; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $event = new Event();
                $event->setEventRef(uniqid());
                $event->setUser($this->getReference('user'.$i));
                $event->setTitle($faker->text(100));
                $event->setDescription($faker->text);
                $event->setEventType($this->getReference('eventType'));
                $event->setVenueType($this->getReference('venueType'));
                $event->setIsInternational(true);
                $event->setAddress($faker->address);

                $cityNumber = $faker->randomElement([1, 2, 3]);
                $city = $this->getReference('city'.$cityNumber);
                $event->setCity($city);

                $event->setBudget($faker->randomFloat(null, 100, 10000));
                $event->setCurrencyId(1);
                $event->setStartingDate($faker->dateTime);
                $event->setEndingDate($faker->dateTime);
                $event->setTiming($faker->text(100));
                $event->setComments($faker->text);

                $manager->persist($event);
                $this->addReference('event' . $i . '_' . $j, $event);
            }
            $manager->flush();
        }

        $now = new \DateTime();

        for ($n=0; $n < 3; $n++) {
            $eventOffer = new EventOffer();
            $eventOffer->setOffer($this->getReference('offer_'. ($n+1)*10));
            $eventOffer->setEvent($this->getReference('event1_'.$n));
            $eventOffer->setSendDateTime($now);
            $eventOffer->setStatus(EventOffer::EVENT_OFFER_STATUS_PROPOSE);
            $manager->persist($eventOffer);
            $this->addReference('event_offer_'. $n, $eventOffer);
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
        return 6;
    }
}